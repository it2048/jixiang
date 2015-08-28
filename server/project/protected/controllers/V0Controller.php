<?php

class V0Controller extends Controller
{
    public $utrl = "http://120.24.234.19";
    public $layout = '//layouts/home';
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

    protected function zm($str,$status=1)
    {
        $strmp = '<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=320,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.3,user-scalable=no">
</head>
<body>
%s
</body>
</html>
';
        $str = preg_replace("/width[:0-9\s]+px;/is","", $str);
        preg_match_all("/<img(.*)(src=\"[^\"]+\")[^>]+>/isU", $str, $arr);
        for($i=0,$j=count($arr[0]);$i<$j;$i++){
            $str = str_replace($arr[0][$i],"<img ".$arr[2][$i]." style='width:99%; height:auto; margin:4px;'/>",$str);
        }
        if($status==0)
            return $str;
        else
            return sprintf($strmp,$str);
    }


    public function getslide($arr)
    {
        $msg = $this->msgcode();
        $status = empty($arr['type'])?1:$arr['type'];
        $status = $status==1?1:2;
        $tm = time();
        $arr = array();
        $allList = AppRsSlide::model()->findAll("type={$status} and stime<{$tm} and etime>{$tm}");
        foreach($allList as $val)
        {
            array_push($arr,array(
                "img_url"=>$this->utrl.Yii::app()->request->baseUrl.$val['img_url'],"type"=>0,
                "news_id"=>$val['newsid']
            ));
        }
        if(!empty($arr))
        {
            $this->msgsucc($msg);
            $msg['data'] = $arr;
        }else
        {
            $msg['msg'] = "广告位为空";
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
            if($k>7) break;
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
        $sql = 'select * from(select * from jixiang.jx_news where (img_url is not null and img_url != "") or type not in(0,1,2,3,4) order by id desc )a group by type';

        $sql1 = 'select * from(select * from jixiang.jx_news where img_url is not null and img_url != "" and type in(0,2,3) order by id desc )a group by type';
        $row1 =  $connection->createCommand($sql1)->query();
        foreach($row1 as $v)
        {
            if($v['type']==2)
                $typ = 1;
            else
                $typ = 0;
            array_push($slide,array('id'=>$v['type'],"title"=>$v['title'],"img_url"=>$this->utrl.Yii::app()->request->baseUrl.$v['img_url'],"type"=>$typ,"news_id"=>$v['id']));
        }
        $tm = time();
        $allList = AppRsSlide::model()->findAll("type=0 and stime<{$tm} and etime>{$tm}");
        foreach($allList as $val)
        {
            array_push($slide,array(
                'id'=>8,"title"=>$val['title'],
                "img_url"=>$this->utrl.Yii::app()->request->baseUrl.$val['img_url'],"type"=>0,
                "news_id"=>$val['newsid']
            ));
        }

        $rows = $connection->createCommand($sql)->query();
        foreach ($rows as $v ){
            if(empty($v['img_url'])||$v['type']==8) continue;
            $pass = empty($v['img_url'])?"":$this->utrl.Yii::app()->request->baseUrl.$v['img_url'];
            $ayy[$v['type']]["title"] = $v['title'];
            $ayy[$v['type']]["news_id"] = $v['id'];
            $ayy[$v['type']]["img_url"] = $this->getSlt($pass,0);
        }
        $this->msgsucc($msg);
        $msg['data'] = array("slide"=>$slide,"list"=>$ayy);
        echo json_encode($msg);
    }


    protected function setUrlFromContent($url,$content)
    {
        if(empty($url))
        {
            if(!empty($content))
            {
                preg_match('/<img.+src=\"?(.+\.(jpg|gif|bmp|bnp|png))\"?.+>/i',$content,$matches);
                if(!empty($matches[1]))
                {
                    return $matches[1];
                }else{
                    return "";
                }
            }else{
                return "";
            }

        }else{
            return $this->utrl.Yii::app()->request->baseUrl.$url;
        }
    }

    protected function getSlt($url,$sta=1)
    {
        $utl = $url;
        if($sta!==1&&strpos($url,"/slt")!==false)
        {
            $utl = str_replace("/slt","/slt/slt",$url);
        }
        return $utl;
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
        $connection = Yii::app()->db;
        $sql = "select distinct title,a.* from jixiang.jx_news a where type={$type} and status=0 group by title order by id desc limit 0,20";
        $list =  $connection->createCommand($sql)->query();
        
        $sql1 = "select distinct title,a.* from jixiang.jx_news a where type={$type} and img_url is not null and status=1 group by title order by id desc limit 0,6";
        $slide =  $connection->createCommand($sql1)->query();

        $sta = $type==2?1:0;
        if(empty($slide))
        {
            $i = 0;
            foreach($list as $val)
            {
                $ct = substr_count($val['child_list'],',')+2;
                if($ct==2) $ct=1;
                $summary = mb_substr(trim(strip_tags($val['content'])),0,40,"utf-8");
                $pass = $this->setUrlFromContent($val['img_url'],$val['content']);
                $listArr[$i] = array("id"=>$val['id'],"title"=>$val['title'],"img_url"=>$this->getSlt($pass,
                        $sta),"type"=>$sta,
                    "time"=>$val['addtime'],"summary"=>$summary,"imgcount"=>$ct);
                $i++;
            }
        }else{
            foreach($slide as $val)
            {
                $pass = $this->setUrlFromContent($val['img_url'],$val['content']);
                $summary = mb_substr(trim(strip_tags($val['content'])),0,40,"utf-8");
                array_push($slideArr,array("id"=>$val['id'],"title"=>$val['title'],"img_url"=>$pass,"type"=>$sta,"time"=>$val['addtime'],"summary"=>$summary));
            }
            $i = 0;
            foreach($list as $val)
            {
                $ct = substr_count($val['child_list'],',')+2;
                if($ct==2) $ct=1;
                $summary = mb_substr(trim(strip_tags($val['content'])),0,40,"utf-8");
                $pass = $this->setUrlFromContent($val['img_url'],$val['content']);
                $listArr[$i] = array("id"=>$val['id'],"title"=>$val['title'],"img_url"=>$this->getSlt($pass,$sta),
                    "type"=>$sta,"time"=>$val['addtime'],"summary"=>$summary,"imgcount"=>$ct);
                $i++;
            }
        }
        $msg['code'] = 0;
        $msg['msg'] = "成功";
        $msg['data'] = array("slide"=>$slideArr,"list"=>$listArr);
    }


    /**
     * 新闻分类接口
     * @param $type
     * @param $msg
     *
     */
    private function cateImg($type,&$msg,$page=1)
    {
        if($page<1)$page=1;
        $listArr = array();
        $lmt = ($page-1)*20;
        $connection = Yii::app()->db;

        $sql = "select distinct title,a.* from jixiang.jx_news a where type={$type} and child_list!='' group by title order by id desc limit {$lmt},20";
        $list =  $connection->createCommand($sql)->query();
        
        $sta = 1;
        $i = 0;
        foreach($list as $val)
        {
            $ct = substr_count($val['child_list'],',');
            if($ct==0) $ct = 2;
            else $ct += 2;
            $summary = mb_substr(trim(strip_tags($val['content'])),0,40,"utf-8");
            $listArr[$i] = array("id"=>$val['id'],"title"=>$val['title'],"img_url"=>$this->getSlt($this->utrl.Yii::app()->request->baseUrl.$val['img_url'],1),
                "type"=>$sta,"time"=>$val['addtime'],"summary"=>$summary,"imgcount"=>$ct);
            $i++;
        }
        $msg['code'] = 0;
        $msg['msg'] = "成功";
        $msg['data'] = array("slide"=>array(),"list"=>$listArr);
    }
    private function pageImg($type,&$msg,$page=1)
    {
        if($page<1)$page=1;
        $listArr = array();
        $lmt = ($page-1)*20;
        $connection = Yii::app()->db;
        $sql = "select distinct title,a.* from jixiang.jx_news a where type={$type} and child_list!='' group by title order by id desc limit {$lmt},20";
        $list =  $connection->createCommand($sql)->query();
        $sta = 1;
        $i = 0;
        foreach($list as $val)
        {
            $ct = substr_count($val['child_list'],',');
            if($ct==0) $ct = 2;
            else $ct += 2;
            $summary = mb_substr(trim(strip_tags($val['content'])),0,40,"utf-8");
            $listArr[$i] = array("id"=>$val['id'],"title"=>$val['title'],"img_url"=>$this->getSlt($this->utrl.Yii::app()->request->baseUrl.$val['img_url'],1),
                "type"=>$sta,"time"=>$val['addtime'],"summary"=>$summary,"imgcount"=>$ct);
            $i++;
        }
        $msg['code'] = 0;
        $msg['msg'] = "成功";
        $msg['data'] = $listArr;
    }
    /**
     * 分类分页接口
     * @param $type
     * @param $msg
     * @param $page
     */
    private function catepage($type,&$msg,$page)
    {
        if($page<1)$page=1;
        $listArr = array();
        $cnt = ($page-1)*20;
        $connection = Yii::app()->db;
        $sql = "select distinct title,a.* from jixiang.jx_news a where type={$type} and status=0 group by title order by id desc limit {$cnt},20";
        $list =  $connection->createCommand($sql)->query();
        
        $sta = $type==2?1:0;
        foreach($list as $val)
        {
            $summary = mb_substr(trim(strip_tags($val['content'])),0,40,"utf-8");
            $ct = substr_count($val['child_list'],',')+2;
            $pass = $this->setUrlFromContent($val['img_url'],$val['content']);
            if($ct==2) $ct=1;
            array_push($listArr,array("id"=>$val['id'],"title"=>$val['title'],"img_url"=>$this->getSlt($pass,$sta),
                "type"=>$sta,"time"=>$val['addtime'],"summary"=>$summary,"imgcount"=>$ct));
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
            $this->cateImg(2,$msg);
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
        if($page<1)$page=1;
        //新闻
        if($status==0)
        {
            $this->catepage($type,$msg,$page);
            //图片
        }elseif($status==1)
        {
            $this->pageImg(2,$msg,$page);
        }
        echo json_encode($msg);
    }

    protected function img_revert($str)
    {
        if(trim($str)=="")
        {
            return "";
        }else{
            return $this->utrl.Yii::app()->request->baseUrl.$str;
        }
    }
    /**
     * 新闻详情
     * @param type $arr
     */
    public function newsdesc($arr)
    {
        $msg = $this->msgcode();
        $id = $arr['id'];
        $type = $arr['type'];
        $row = AppJxNews::model()->findByPk($id);
        if(!empty($row))
        {
            $src = $row['source'];
            if(strpos($row['source'],"《")!==false)
            {
                $src = ltrim($src,"《");
            }
            if(strpos($row['source'],"》")!==false)
            {
                $src = rtrim($src,"》");
            }
            $this->msgsucc($msg);
            $content = str_replace("<img ","<img width='100%' ",$row['content']);
            $content = str_replace('src="/UploadFiles','src="http://www.kbcmw.com/UploadFiles',$content);
            if($row['type']==6)
            {
                $content = str_replace('>,', '>', $content);
            }

            if($type==0)
            {
                $msg['data'] = array("id"=>$row['id'],"addtime"=>$row['addtime'],"title"=>$row['title']
                ,"content"=> $this->zm($content)
                ,"img_url"=>$this->img_revert($row['img_url'])
                ,"comment"=>$row['comment']
                ,"like"=>$row['like']
                ,"han"=>$row['han']
                ,"hate"=>$row['hate']
                ,"source"=>$src
                ,"comtype"=>$row['comtype']
                ,"url"=>$this->utrl.'/api/jixiang/server/project/index.php/home/news/id/'.$row['id']
                //,"html"=>$this->getHtml($row['title'],$this->zm($content,0),$src,$row['addtime'])
                );
            }else
            {
                $tmp = array();
                array_push($tmp,array("id"=>$row['id'],"addtime"=>$row['addtime'],"title"=>$row['title']
                ,"content"=>$this->zm($content)
                ,"img_url"=>$this->img_revert($row['img_url'])
                ,"comment"=>$row['comment']
                ,"like"=>$row['like']
                ,"han"=>$row['han']
                ,"hate"=>$row['hate']
                ,"source"=>$src,
                    "comtype"=>$row['comtype']));
                if(!empty($row['child_list']))
                {
                    $rowLs = AppJxNews::model()->findAll("id in(".$row['child_list'].")");
                    foreach ($rowLs as $val) {

                        $sou = $val['source'];
                        if(strpos($val['source'],"《")!==false)
                        {
                            $sou = ltrim($sou,"《");
                        }
                        if(strpos($val['source'],"》")!==false)
                        {
                            $sou = rtrim($sou,"》");
                        }
                        array_push($tmp,array("id"=>$val['id'],"addtime"=>$val['addtime'],"title"=>$val['title']
                        ,"content"=>$this->zm($val['content'])
                        ,"img_url"=>$this->img_revert($val['img_url'])
                        ,"comment"=>$val['comment']
                        ,"like"=>$val['like']
                        ,"han"=>$val['han']
                        ,"hate"=>$val['hate']
                        ,"source"=>$sou
                        ,"comtype"=>$val['comtype']));
                    }
                }

                $msg['data'] = $tmp;
            }
        }else
            $msg['msg'] = "文章不存在";
        echo json_encode($msg);
    }
    /**
     * 获取token
     * @param type $id
     * @return type
     */
    private function getToken($um)
    {
        $salt = "xFl@&^852";
        $um->login_time = time();
        $um->key = substr(md5($um->id.$salt.$um->type.$um->login_time),3,16);
        $um->save();
        return $um->key;
    }
    /**
     * 验证用户是否已经登录
     * @param type $id
     * @param type $token
     * @return type
     */
    private function chkToken($id,$token)
    {
        $salt = "xFl@&^852";
        $um = AppJxUser::model()->findByPk($id);
        if(empty($um))
        {
            return false;
        }
        else
        {
            if($um->type!=1&&$um->login_time+302400>time()&&substr(md5($um->id.$salt.$um->type.$um->login_time),3,16)==$token)
            {
                return true;
            }else
            {
                return false;
            }
        }
    }

    /**
     * 帐号登录
     */
    public function login($arr)
    {
        $msg = $this->msgcode();
        $salt = "xFl@&^852";
        $tel = $arr['tel'];
        $password = $arr['password'];
        if($tel==""||$password=="")
        {
            $msg['msg'] = "存在必填项为空，请确定参数满足条件";
            echo json_encode($msg);die();
        }
        $mod = AppJxUser::model()->find("tel=:tl and type=0",array("tl"=>$tel));
        $tmp = $mod;
        if(!empty($mod)&&md5($password.$salt)==$mod->password)
        {
            $this->msgsucc($msg);
            $msg['msg'] = "登录成功";
            $msg['data'] = array("id"=>$mod->id,
                "token"=>$this->getToken($tmp),
                "tel"=>$mod->tel,
                "uname"=>$mod->uname,
                "img_url"=>$this->img_revert($mod->img_url)
            );
        }
        else
            $msg['msg'] = "帐号或者密码错误";
        echo json_encode($msg);
    }

    /**
     * 帐号登出
     */
    public function logout($arr)
    {
        $msg = $this->msgcode();
        $user_id = $arr['user_id'];
        $token = $arr['token'];
        if(!$this->chkToken($user_id,$token))
        {
            $msg['code'] = 2;
            $msg['msg'] = "无权限，请登录";
        }else{
            $mod = AppJxUser::model()->findByPk($user_id);
            if(empty($mod))
            {
                $msg['msg'] = "用户不存在";
            }else{
                $mod->login_time = time();
                if($mod->save())
                {
                    $this->msgsucc($msg);
                    $msg['msg'] = "已退出登录";
                }

            }
        }
        echo json_encode($msg);
    }

    private function getHtml($title,$content,$source,$time)
    {
        if(date('H:i:s',$time)=='00:00:00')
            $time = date('Y-m-d',$time);
        else
            $time = date('Y-m-d H:i:s',$time);
        return $this->renderPartial('news', array(
            'model' => array("title"=>$title,"content"=>$content,"source"=>$source,"time"=>$time)),true,false);
    }

    /**
     * 获取用户信息
     */
    public function getuserinfo($arr)
    {
        $msg = $this->msgcode();
        $user_id = $arr['user_id'];
        $token = $arr['token'];
        if(!$this->chkToken($user_id,$token))
        {
            $msg['code'] = 2;
            $msg['msg'] = "无权限，请登录";
        }else{
            $mod = AppJxUser::model()->findByPk($user_id);
            if(empty($mod))
            {
                $msg['msg'] = "用户不存在";
            }else{
                $this->msgsucc($msg);
                $msg['data'] = array(
                    "id"=>$mod->id,
                    "tel"=>$mod->tel,
                    "uname"=>$mod->uname,
                    "img_url"=>$this->img_revert($mod->img_url)
                );
            }
        }
        echo json_encode($msg);
    }

    public function commentlist($arr)
    {
        $msg = $this->msgcode();
        $news_id = $arr['news_id'];
        $newModel = AppJxNews::model()->findByPk($news_id);
        if(empty($newModel)||$newModel->comtype==1)
        {
            $msg['code'] = 3;
            $msg['msg'] = "禁止评论";
        }else{
            $page = empty($arr['page'])?1:$arr['page'];
            if($page<1)$page=1;
            $star = 20*($page-1);
            $comm = AppJxComment::model()->findAll("news_id={$news_id} order by id desc limit {$star},20");

            $str = "";
            foreach($comm as $valq)
            {
                $str .= sprintf('%d,',$valq->user_id);
            }
            $userApp = array();
            $userNc = array();
            $userImg = array();
            if($str!="")
            {
                $str = rtrim($str,",");
                $userList = AppJxUser::model()->findAll("id in({$str})");
                foreach($userList as $val)
                {
                    $userApp[$val->id] = $val->tel;
                    $userNc[$val->id] = $val->uname;
                    $userImg[$val->id] = $val->img_url;
                }
            }
            $this->msgsucc($msg);
            $allList = array();
            foreach($comm as $val)
            {
                array_push($allList,array(
                    "id"=>$val->id,
                    "parent_id"=>$val->parent_id,
                    "parent_user"=>$val->parent_user,
                    "user_id"=>$val->user_id,
                    "comment"=>$val->comment,
                    "user_account"=>empty($userApp[$val->user_id])?$val->user_id:$userApp[$val->user_id],
                    "user_nic"=>empty($userNc[$val->user_id])?$val->user_id:$userNc[$val->user_id],
                    "addtime"=>$val->addtime,
                    "user_img"=>empty($userImg[$val->user_id])?"":$this->utrl.Yii::app()->request->baseUrl.$userImg[$val->user_id]
                ));
            }
            $msg['data'] = $allList;
        }
        echo json_encode($msg);
    }


    /**
     * 评论
     */
    public function comment($arr)
    {
        $msg = $this->msgcode();
        $user_id = $arr['user_id'];
        $token = $arr['token'];
        $news_id = $arr['news_id'];
        $content = $arr['content'];
        $parent_id = $arr['parent_id'];
        $parent_user = $arr['parent_user'];

        $black = AppJxConfig::model()->findByPk("comment");
        $lackList= explode(",",$black->value);
        $bl = true;
        foreach($lackList as $as)
        {
            if(strpos($content,$as)!==false)
            {
                $bl = false;
                break;
            }
        }
        $newmodel = AppJxNews::model()->find("id={$news_id} and (comtype is null or comtype=0)");
        if(!$bl)
        {
            $msg['msg'] = "评论中包含非法词汇";
        }
        elseif(empty($newmodel))
        {
            $msg['msg'] = "该文章禁止评论";
        }
        elseif($user_id==""||$token==""||$news_id==""||$content=="")
        {
            $msg['msg'] = "存在必填项为空，请确定参数满足条件";
        }elseif(!$this->chkToken($user_id,$token))
        {
            $msg['code'] = 2;
            $msg['msg'] = "无权限，请登录";
        }else{
            $comm = new AppJxComment();
            $comm->news_id = $news_id;
            $comm->parent_id = $parent_id;
            $comm->parent_user = $parent_user;
            $comm->user_id = $user_id;
            $comm->comment = $content;
            $comm->addtime = time();
            if($comm->save())
            {
                $mdl = AppJxNews::model()->findByPk($news_id);
                $mdl->comment = $mdl->comment+1;
                $mdl->save();
                $this->msgsucc($msg);
                $msg['msg'] = "评论发布成功";
            }
        }
        echo json_encode($msg);
    }

    /**
     * 帐号注册
     * @param type $arr
     */
    public function register($arr)
    {
        $msg = $this->msgcode();
        $salt = "xFl@&^852";
        $tel = $arr['tel'];
        $password = $arr['password'];
        $vcode = trim($arr['verifycode']);
        if($tel==""||$password=="")
        {
            $msg['msg'] = "存在必填项为空，请确定参数满足条件";
            echo json_encode($msg);die();
        }
        $model = AppJxUser::model()->find("tel=:tl and type=1 and password='123456'",array("tl"=>$tel));
        if(!empty($model))
        {
            if(empty($model->check))
            {
                $msg['msg'] = "验证码失效，请重新获取";
            }
            elseif(!Sms::check($tel))
            {
                $model->check = "";
                $model->save();
                $msg['msg'] = "验证时间超时，请重新获取";
            }
            elseif($model->check != $vcode)
            {
                $model->check = "";
                $model->save();
                $msg['msg'] = "验证码错误，请重新获取";
            }else
            {
                $model->tel = $tel;
                $model->password = md5($password.$salt);
                $model->fhtime = time();
                $model->ctime = time();
                $model->check = "";
                //注册用户默认是被封号的
                $model->type = 0;
                if($model->save())
                {
                    $this->msgsucc($msg);
                    $id = $model->attributes['id'];
                    $msg['data'] = array("id"=>$id,
                        "token"=>$this->getToken($model));
                }else
                {
                    $msg['msg'] = "注册失败";
                }
            }
        }else
        {
            $msg['msg'] = "号码已被注册";
        }
        echo json_encode($msg);
    }

    /**
     * 点赞的状态
     * @param $arr
     */
    public function zanstatus($arr)
    {
        $msg = $this->msgcode();
        $user_id = $arr['user_id'];
        $token = $arr['token'];
        $news_id = $arr['news_id'];
        if(!$this->chkToken($user_id,$token))
        {
            $msg['code'] = 2;
            $msg['msg'] = "无权限，请登录";
        }else{
            $id = AppJxDegree::model()->find("news_id={$news_id} and user_id={$user_id}");
            $this->msgsucc($msg);
            if(empty($id))
            {
                $msg['data'] = 0;
            }else
            {
                $msg['data'] = $id->type;
            }
        }
        echo json_encode($msg);
    }

    /**
     * 点赞
     * @param $arr
     */
    public function setzan($arr)
    {
        $msg = $this->msgcode();
        $user_id = $arr['user_id'];
        $token = $arr['token'];
        $news_id = $arr['news_id'];
        $type = $arr['type'];
        if(!$this->chkToken($user_id,$token))
        {
            $msg['code'] = 2;
            $msg['msg'] = "无权限，请登录";
        }else{
            $id = AppJxDegree::model()->find("news_id={$news_id} and user_id={$user_id}");
            $news = AppJxNews::model()->findByPk($news_id);
            $this->msgsucc($msg);
            if(empty($id))
            {
                $modl = new AppJxDegree();
                $modl->news_id = $news_id;
                $modl->user_id = $user_id;
                $modl->type = $type;
                $modl->save();
                if(!empty($news))
                {
                    if($type==1)
                    {
                        $news->like = $news->like+1;
                    }elseif($type==2)
                    {
                        $news->han = $news->han+1;
                    }elseif($type==3)
                    {
                        $news->hate = $news->hate+1;
                    }
                    $news->save();
                }

            }else
            {
                if(!empty($news))
                {
                    if($type==1)
                    {
                        $news->like = $news->like+1;
                    }elseif($type==2)
                    {
                        $news->han = $news->han+1;
                    }elseif($type==3)
                    {
                        $news->hate = $news->hate+1;
                    }
                    if($id->type==1)
                    {
                        $news->like = $news->like-1;
                    }elseif($id->type==2)
                    {
                        $news->han = $news->han-1;
                    }elseif($id->type==3)
                    {
                        $news->hate = $news->hate-1;
                    }
                    $news->save();
                }
                $id->type = $type;
                $id->save();
            }
        }
        echo json_encode($msg);
    }

    /**
     * 更新用户头像和昵称
     * @param $arr
     */
    public function updateuserinfo($arr)
    {
        $msg = $this->msgcode();
        $user_id = $arr['user_id'];
        $token = $arr['token'];
        $uname = empty($arr['uname'])?"":$arr['uname'];
        if(!$this->chkToken($user_id,$token))
        {
            $msg['code'] = 2;
            $msg['msg'] = "无权限，请登录";
        }else{
            $model = AppJxUser::model()->findByPk($user_id);
            $uimg = empty($_FILES['file'])?"":$_FILES['file'];
            if(!empty($uimg['name']))
            {
                $img = array("png","jpg","gif");
                $_tmp_pathinfo = pathinfo($uimg['name']);
                if (in_array(strtolower($_tmp_pathinfo['extension']),$img)) {
                    //设置图片路径
                    $flname = 'photo/'.time().$user_id.".".$_tmp_pathinfo['extension'];
                    $dest_file_path = Yii::app()->basePath . '/../public/'.$flname;
                    $filepathh = dirname($dest_file_path);
                    if (!file_exists($filepathh))
                        $b_mkdir = mkdir($filepathh, 0777, true);
                    else
                        $b_mkdir = true;
                    if ($b_mkdir && is_dir($filepathh)) {
                        //转存文件到 $dest_file_path路径
                        if (move_uploaded_file($uimg['tmp_name'], $dest_file_path)) {
                            $img_url ='/public/'.$flname;
                            if(!empty($model->img_url))
                                @unlink(Yii::app()->basePath . '/..'.$model->img_url);
                            $model->img_url = $img_url;
                        }else
                        {
                            $msg["msg"] = '头像存储失败';
                            $msg["code"] = 4;
                        }
                    }
                } else {
                    $msg["msg"] = '上传的文件格式只能为jpg,png,gif';
                    $msg["code"] = 3;
                }
            }
            if($msg["code"]==1)
            {
                if($uname!="")
                    $model->uname = $uname;
                if($model->save())
                {
                    $this->msgsucc($msg);
                    $msg['msg'] = "用户名已修改完成";
                    $msg['data'] = array(
                        "id"=>$user_id,
                        "tel"=>$model->tel,
                        "uname"=>$model->uname,
                        "img_url"=>$this->img_revert($model->img_url)
                    );
                }else
                {
                    $msg['msg'] = "保存失败";
                }
            }
        }
        echo json_encode($msg);
    }



    /**
     * 收藏的状态
     * @param $arr
     */
    public function collectstatus($arr)
    {
        $msg = $this->msgcode();
        $user_id = $arr['user_id'];
        $token = $arr['token'];
        $news_id = $arr['news_id'];
        if(!$this->chkToken($user_id,$token))
        {
            $msg['code'] = 2;
            $msg['msg'] = "无权限，请登录";
        }else{
            $id = AppJxCollect::model()->find("news_id={$news_id} and user_id={$user_id}");
            $this->msgsucc($msg);
            if(empty($id))
            {
                $msg['data'] = 0;
            }else
            {
                $msg['data'] = 1;
            }
        }
        echo json_encode($msg);
    }

    /**
     * 收藏与取消收藏
     * @param $arr
     */
    public function setcollect($arr)
    {
        $msg = $this->msgcode();
        $user_id = $arr['user_id'];
        $token = $arr['token'];
        $news_id = $arr['news_id'];
        $type = $arr['type'];
        if(!$this->chkToken($user_id,$token))
        {
            $msg['code'] = 2;
            $msg['msg'] = "无权限，请登录";
        }else{
            $id = AppJxCollect::model()->find("news_id={$news_id} and user_id={$user_id}");
            //取消收藏
            if($type==0)
            {
                if(!empty($id))
                {
                    if($id->delete())
                    {
                        $this->msgsucc($msg);
                    }
                }else{
                    $msg['msg'] = "该文章您并未收藏";
                }
                //收藏
            }elseif($type==1)
            {
                if(empty($id))
                {
                    $modl = new AppJxCollect();
                    $modl->news_id = $news_id;
                    $modl->user_id = $user_id;
                    $modl->time = time();
                    if($modl->save())
                    {
                        $this->msgsucc($msg);
                        $msg['msg'] = "文章已添加至“我的收藏”";
                    }
                }else
                {
                    $msg['msg'] = "请勿重复收藏";
                }
            }
        }
        echo json_encode($msg);
    }

    /**
     * 获取收藏列表
     * @param $arr
     */
    public function getcollectlist($arr)
    {
        $msg = $this->msgcode();
        $user_id = $arr['user_id'];
        $token = $arr['token'];
        $page = empty($arr['page'])?1:$arr['page'];
        if($page<1)$page=1;
        $cnt = ($page-1)*20;
        if(!$this->chkToken($user_id,$token))
        {
            $msg['code'] = 2;
            $msg['msg'] = "无权限，请登录";
        }else{

            $connection = Yii::app()->db;
            $sql = "SELECT * FROM jx_collect left join jx_news on jx_collect.news_id = jx_news.id where jx_collect.user_id={$user_id} and jx_news.title is not null order by time desc limit {$cnt},20"; //构造SQL
            $sqlCom = $connection->createCommand($sql);
            $lst = $sqlCom->queryAll();
            $data = array();
            $this->msgsucc($msg);
            foreach ($lst as $value) {
                $pass = empty($value['img_url'])?"":$this->utrl.Yii::app()->request->baseUrl.$value['img_url'];
                $sta = $value['type']==2?1:0;
                array_push($data,array(
                    "id"=>$value['id'], //新闻编号
                    "title"=>$value['title'],"time"=>$value['addtime'],
                    "img_url"=>$this->getSlt($pass,0),
                    "type"=>$sta
                ));
            }
            $msg['data'] = $data;
        }
        echo json_encode($msg);
    }

    /**
     * 发送验证码
     * @param type $arr
     */
    public function sendverifycode($arr)
    {
        $msg = $this->msgcode();
        $tel = $arr['tel'];
        $type = $arr['type']==1?1:0;
        $sb = empty($arr['uuid'])?"":$arr['uuid'];
        $umode = AppJxUser::model()->find("tel=:tl",array(":tl"=>$tel));
        //改密码
        if($type==1)
        {
            if(empty($umode))
            {
                $msg['msg'] = "用户不存在";
            }else{
                list($msec, $sec) = explode(' ', microtime());
                $code = substr($msec,4,4);
                $umode->check = $code;
                if($umode->save())
                {
                    $con = new Sms();
                    $mll = $con->sendNotice($tel,$sb);
                    if($mll['code']==0)
                    {
                        $content = sprintf("验证码：%s ，您目前正在使用吉祥甘孜账密保护功能，请勿告知他人。",$code);
                        if($con->sendSMS($tel,$content))
                            $this->msgsucc($msg);
                        else
                            $msg['msg'] = '发送短信出错';
                    }
                    else{
                        $msg['msg'] = $mll['msg'];
                    }
                }
            }
        }else
        {
            if(empty($umode)||$umode->password=="123456")
            {
                $msg['msg'] = "号码有误";

                if(empty($umode))
                    $model = new AppJxUser();
                else
                    $model = $umode;
                $model->tel = $tel;
                $model->password = "123456";
                $model->fhtime = time();
                $model->ctime = time();
                //注册用户默认是被封号的
                $model->type = 1;
                list($msec, $sec) = explode(' ', microtime());
                $code = substr($msec,4,4);
                $model->check = $code;

                if($model->save())
                {
                    $con = new Sms();
                    $mll = $con->sendNotice($tel,$sb);
                    if($mll['code']==0)
                    {
                        $content = sprintf("验证码：%s ，您目前正在使用吉祥甘孜账密保护功能，请勿告知他人。",$code);
                        if($con->sendSMS($tel,$content))
                            $this->msgsucc($msg);
                        else
                            $msg['msg'] = '发送短信出错';
                    }
                    else{
                        $msg['msg'] = $mll['msg'];
                    }
                }

            }else
            {
                $msg['msg'] = "用户已经存在";
            }
        }

        echo json_encode($msg);
    }


    /**
     * 获取收藏列表
     * @param $arr
     */
    public function updatepassword($arr)
    {
        $msg = $this->msgcode();
        $tel = $arr['tel'];
        $newpass = $arr['newpassword'];
        $vcode = trim($arr['verifycode']);
        $umode = AppJxUser::model()->find("tel=:tl",array(":tl"=>$tel));
        if(!empty($umode))
        {
            if(empty($umode->check))
            {
                $msg['msg'] = "验证码失效，请重新获取";
            }
            elseif(!Sms::check($tel))
            {
                $umode->check = "";
                $umode->save();
                $msg['msg'] = "验证时间超时或次数过多，请重新获取";
            }
            elseif($umode->check != $vcode)
            {
                $umode->check = "";
                $msg['msg'] = "验证码错误，请重新获取";
            }else
            {
                $salt = "xFl@&^852";
                $umode->password = md5($newpass.$salt);
                $umode->login_time = time();
                $umode->check = "";
                if($umode->save())
                {
                    $this->msgsucc($msg);
                    $msg['msg'] = "修改密码成功，请重新登录";
                }
            }
        }
        echo json_encode($msg);
    }
    /**
     * 天气显示接口
     *
     */
    public function getweather($arr)
    {
        $msg = $this->msgcode();
        $zone = $arr['zone'];
        $url = "http://api.map.baidu.com/telematics/v3/weather?location={$zone}&output=json&ak=0QDaLukGIKr22SwQKTWNxGSz";

        $data = json_decode(RemoteCurl::getInstance()->get($url),true);
        $allList = array();
        if($data['status']=="success")
        {
            if(!empty($data['results'][0]['weather_data'])&&is_array($data['results'][0]['weather_data']))
            {
                $this->msgsucc($msg);
                $model = $data['results'][0]['weather_data'];
                $start = strpos($model[0]['date'],"：");
                $crent = mb_substr($model[0]['date'],$start+3,strlen($model[0]['date'])-1);
                foreach($model as $k=>$val)
                {
                    $crent = $k==0?$crent:"";
                    $day = mb_substr($val['date'],0,6);
                    array_push($allList,array("current_temperature"=>$crent,"date"=>$day,
                        "weather"=>$this->getW($val['weather']),"temperature"=>$val['temperature'],
                        "wind"=>$val['wind']
                    ));
                }

            }
            else
            {
                $msg['msg'] = "天气获取失败";
            }
            $msg['data'] = $allList;
        }
        echo json_encode($msg);
    }

    private function getW($str)
    {
        $arr = array("ICE"=>"雹","SNOW"=>"雪","RAIN"=>"雨","SUN"=>"晴","CLOUD"=>"云","WIND"=>"风");
        $rtn = "";
        foreach($arr as $k=>$val)
        {
            if(strpos($str,$val)!==false)
            {
                $rtn = $k;
                break;
            }
        }
        if($rtn=="")
            $rtn="SUN";
        return $rtn;
    }

    public function search($arr)
    {
        $page = empty($arr['page'])?1:$arr['page'];
        $words = $arr['words'];
        if($page<1)$page=1;
        $listArr = array();
        $cnt = ($page-1)*20;
        $list = AppJxNews::model()->findAll("title like '%{$words}%' or content like '%{$words}%' order by id desc limit {$cnt},20");
        foreach($list as $val)
        {
            $content = html_entity_decode(trim(strip_tags($val['content'])));
            $type = $val['type']==2?1:0;
            if(mb_strpos($val['title'],$words,1,"utf-8")!=false)
                $summary = mb_substr($content,0,30,"utf-8");
            else
            {
                $k = mb_strpos($content,$words,1,"utf-8");
                $lmt = 30;
                if($k<10)
                {
                    $star = $k;
                    $lmt = $lmt+10-$star;
                }
                else
                {
                    $star = $k-10;
                }
                $summary = mb_substr($content,$star,$lmt,"utf-8");
            }
            array_push($listArr,array("id"=>$val['id'],"addtime"=>$val['addtime'],"title"=>$val['title'],"summary"=>$summary,
            "type"=>$type));
        }
        $msg['code'] = 0;
        $msg['msg'] = "成功";
        $msg['data'] = $listArr;
        echo json_encode($msg);
    }
    public function actionDemo()
    {
//       $params = array(
//            'action' => 'commentlist',
//            'user_id' => '23',
//            'token'=>'7cb5f1867099ffab',
//            'news_id'=>'973',
//            'page' => '1',
//            'parent_id'=>'23',
//            'parent_user'=>"测试",
//
//        );

        $params = array(
            'action' => 'newsdesc',
            'type'=>0,
            'id'=>'9509',
            'password'=>md5('123456'.'xFl@&^852'),
            'verifycode'=>'9046'
        );

//        $params = array(
//            'action' => 'comment',
//            'user_id' => '23',
//            'news_id' => '286',
//            'content'=>1,
//            'token'=>'35963755137a0653'
//        );

        $salt = "xFlaSd!$&258";
        $data = json_encode($params);
        $sign = md5($data.$salt);
        $rtnList = array(
            "file"=>'@'."d:/bg_rain.png",
            "data"=>$data,
            "sign"=>$sign
        );
        $url = true?"http://120.24.234.19/api":"http://127.0.0.1";

        $arr = json_decode(RemoteCurl::getInstance()->post($url.'/jixiang/server/project/index.php',$rtnList),true);

        echo $arr['data']['html'];

    }

}
