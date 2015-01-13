<?php

class V0Controller extends Controller
{
    /**
     * 生成首页
     *
     */
    public function actionIndex()
    {
        $msg = $this->msgcode();
        $sign =Yii::app()->getRequest()->getParam("sign");
        $data =Yii::app()->getRequest()->getParam("data");
        $salt = "xFlaSd!$&258";
        if($sign==md5($data.$salt))
        {
            $reques = json_decode($data,true);
            if(!call_user_func(array('V0Controller',$reques['action']),$reques))
            {
                die();
            }
            else
            {
                $msg['msg'] = "请求的action不存在";
            }
        }
        echo json_encode($msg);
    }


    /**
     * 首页新闻接口
     * @param $arr
     */
    public function homenews($arr)
    {
        $ayy = array();
        $slide = array();
        foreach(TmpList::$news_list as $k=>$val)
        {
            if($k==2)
                $type = 1;
            elseif($k==5)
                $type = 2;
            else
                $type = 0;
            $ayy[$k] = array('id'=>$k,"title"=>"","img_url"=>"","type"=>$type,"news_id"=>NULL);
        }
        $msg = $this->msgcode();
        $connection = Yii::app()->db;
        $sql = 'select * from(select * from jixiang.jx_news order by id desc )a group by type';

        $sql1 = 'select * from(select * from jixiang.jx_news where img_url is not null and type in(0,2,3) order by id desc )a group by type';
        $row1 =  $connection->createCommand($sql1)->query();
        foreach($row1 as $v)
        {
            if($v['type']==2)
                $typ = 1;
            else
                $typ = 0;
            array_push($slide,array('id'=>$v['type'],"title"=>$v['title'],"img_url"=>"http://it2048.cn/api/".Yii::app()->request->baseUrl.$v['img_url'],"type"=>$typ,"news_id"=>$v['id']));
        }

        $rows = $connection->createCommand($sql)->query();
        foreach ($rows as $v ){
            $ayy[$v['type']]["title"] = $v['title'];
            $ayy[$v['type']]["news_id"] = $v['id'];
            $ayy[$v['type']]["img_url"] = "http://it2048.cn/api/".Yii::app()->request->baseUrl.$v['img_url'];
        }
        $this->msgsucc($msg);
        $msg['data'] = array("slide"=>$slide,"list"=>$ayy);
        echo json_encode($msg);
    }

    /**
     * 新闻分类接口
     * @param $type
     * @param $msg
     *
     */
    private function cateNews($type,&$msg)
    {
        $slideArr = array();
        $listArr = array();
        $slide = AppJxNews::model()->findAll("type=:tp and img_url is not null and status=1 order by id desc limit 0,4",array(":tp"=>$type));
        $list = AppJxNews::model()->findAll("type=:tp order by id desc limit 0,24",array(":tp"=>$type));
        $sta = $type==3?1:0;
        if(empty($slide))
        {
            $i = 0;
            foreach($list as $val)
            {
                $summary = mb_substr(trim(strip_tags($val['content'])),0,40,"utf-8");
                if($i<4)
                    $slideArr[$i] = array("id"=>$val['id'],"title"=>$val['title'],"img_url"=>$val['img_url'],"type"=>$sta,"time"=>$val['addtime'],"summary"=>$summary);
                $listArr[$i] = array("id"=>$val['id'],"title"=>$val['title'],"img_url"=>$val['img_url'],"type"=>$sta,"time"=>$val['addtime'],"summary"=>$summary);
                $i++;
            }
        }else{
            foreach($slide as $val)
            {
                $summary = mb_substr(trim(strip_tags($val['content'])),0,40,"utf-8");
                array_push($slideArr,array("id"=>$val['id'],"title"=>$val['title'],"img_url"=>$val['img_url'],"type"=>$sta,"time"=>$val['addtime'],"summary"=>$summary));
            }
            $i = 0;
            foreach($list as $val)
            {
                $summary = mb_substr(trim(strip_tags($val['content'])),0,40,"utf-8");
                $listArr[$i] = array("id"=>$val['id'],"title"=>$val['title'],"img_url"=>$val['img_url'],"type"=>$sta,"time"=>$val['addtime'],"summary"=>$summary);
                $i++;
            }
        }
        $msg['code'] = 0;
        $msg['msg'] = "成功";
        $msg['data'] = array("slide"=>$slideArr,"list"=>$listArr);
    }

    /**
     * 分类分页接口
     * @param $type
     * @param $msg
     * @param $page
     */
    private function catepage($type,&$msg,$page)
    {
        $listArr = array();
        $cnt = ($page-1)*20;
        $list = AppJxNews::model()->findAll("type=:tp order by id desc limit {$cnt},20",array(":tp"=>$type));
        $sta = $type==3?1:0;
        foreach($list as $val)
        {
            array_push($listArr,array("id"=>$val['id'],"title"=>$val['title'],"img_url"=>$val['img_url'],"type"=>$sta,"time"=>$val['addtime']));
        }
        $msg['code'] = 0;
        $msg['msg'] = "成功";
        $msg['data'] = $listArr;
    }

    /**
     * 天气显示接口
     *
     */
    private function weather()
    {

    }
    public function typelist($arr)
    {
        $msg = $this->msgcode();
        $type = $arr['id'];
        $status = $arr['type'];
        //新闻
        if($status==0)
        {
            $this->cateNews($type,$msg);
        //图片
        }elseif($status==1)
        {
            $this->cateNews(2,$msg);
        //天气
        }elseif($status==2)
        {
            $this->weather();
        }
        echo json_encode($msg);
    }

    public function typepage($arr)
    {
        $msg = $this->msgcode();
        $type = $arr['id'];
        $status = $arr['type'];
        $page = $arr['page'];
        //新闻
        if($status==0)
        {
            $this->catepage($type,$msg,$page);
            //图片
        }elseif($status==1)
        {
            $this->catepage(2,$msg,$page);
        }
        echo json_encode($msg);
    }

    public function actionDemo()
    {
        $params = array(
            'action' => 'typelist',
            'id' => 0,
            'type' => 0,
            'page' => 1
        );
        $salt = "xFlaSd!$&258";
        $data = json_encode($params);
        $sign = md5($data.$salt);
        $rtnList = array(
            "data"=>$data,
            "sign"=>$sign
        );
        print_r(RemoteCurl::getInstance()->post('http://192.168.1.100/jixiang/server/project/index.php', http_build_query($rtnList)));
    }
}