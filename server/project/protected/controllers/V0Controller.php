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


    public function homenews($arr)
    {
        $ayy = array();
        foreach(TmpList::$news_list as $k=>$val)
        {
            if($k==2)
                $type = 1;
            elseif($k==5)
                $type = 2;
            else
                $type = 0;
            $ayy[$k] = array('id'=>$k,"title"=>"","img_url"=>"","type"=>$type);
        }
        $msg = $this->msgcode();
        $connection = Yii::app()->db;
        $sql = 'select * from(select * from jixiang.jx_news order by id desc )a group by type';
        $rows = $connection->createCommand($sql)->query();
        foreach ($rows as $v ){
            $ayy[$v['type']]["title"] = $v['title'];
            $ayy[$v['type']]["img_url"] = "http://it2048.cn/api/".Yii::app()->request->baseUrl.$v['img_url'];
        }
        $this->msgsucc($msg);
        echo json_encode($msg);
    }


    public function actionDemo()
    {
        $params = array(
            'action' => 'homenews',
            'zoneId' => 1,
            'serverId' => 2,
            'playerId' => 3,
            'playerName' => 4
        );
        $salt = "xFlaSd!$&258";
        $data = json_encode($params);
        $sign = md5($data.$salt);
        $rtnList = array(
            "data"=>$data,
            "sign"=>$sign
        );
        print_r(RemoteCurl::getInstance()->post('http://127.0.0.1/jixiang/server/project/index.php', http_build_query($rtnList)));
    }
}