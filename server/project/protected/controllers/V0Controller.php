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
        $sql = 'select * from(select * from jixiang.jx_news where status=0 order by id desc )a group by type';

        $sql1 = 'select * from(select * from jixiang.jx_news where img_url is not null and type in(0,2,3) and status=1 order by id desc )a group by type';
        $row1 =  $connection->createCommand($sql1)->query();
        foreach($row1 as $v)
        {
            if($v['type']==2)
                $typ = 1;
            else
                $typ = 0;
            array_push($slide,array('id'=>$v['type'],"title"=>$v['title'],"img_url"=>"http://it2048.cn".Yii::app()->request->baseUrl.$v['img_url'],"type"=>$typ,"news_id"=>$v['id']));
        }

        $rows = $connection->createCommand($sql)->query();
        foreach ($rows as $v ){
            $pass = empty($v['img_url'])?"":"http://it2048.cn".Yii::app()->request->baseUrl.$v['img_url'];
            $ayy[$v['type']]["title"] = $v['title'];
            $ayy[$v['type']]["news_id"] = $v['id'];
            $ayy[$v['type']]["img_url"] = $this->getSlt($pass);
        }
        $this->msgsucc($msg);
        $msg['data'] = array("slide"=>$slide,"list"=>$ayy);
        echo json_encode($msg);
    }

    protected function getSlt($url,$sta=1)
    {
        $utl = $url;
        if($sta!==2&&strpos($url,"/slt")!==false)
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
        $slide = AppJxNews::model()->findAll("type=:tp and img_url is not null and status=1 order by id desc limit 0,6",array(":tp"=>$type));
        $list = AppJxNews::model()->findAll("type=:tp and status=0 order by id desc limit 0,20",array(":tp"=>$type));
        $sta = $type==2?1:0;
        if(empty($slide))
        {
            $i = 0;
            foreach($list as $val)
            {
                $ct = substr_count($val['child_list'],',')+2;
                if($ct==2) $ct=1;
                $summary = mb_substr(trim(strip_tags($val['content'])),0,40,"utf-8");
                $pass = empty($val['img_url'])?"":"http://it2048.cn".Yii::app()->request->baseUrl.$val['img_url'];
                $listArr[$i] = array("id"=>$val['id'],"title"=>$val['title'],"img_url"=>$this->getSlt($pass,
                        $sta),"type"=>$sta,
                    "time"=>$val['addtime'],"summary"=>$summary,"imgcount"=>$ct);
                $i++;
            }
        }else{
            foreach($slide as $val)
            {
                $pass = empty($val['img_url'])?"":"http://it2048.cn".Yii::app()->request->baseUrl.$val['img_url'];
                $summary = mb_substr(trim(strip_tags($val['content'])),0,40,"utf-8");
                array_push($slideArr,array("id"=>$val['id'],"title"=>$val['title'],"img_url"=>$pass,"type"=>$sta,"time"=>$val['addtime'],"summary"=>$summary));
            }
            $i = 0;
            foreach($list as $val)
            {
                $ct = substr_count($val['child_list'],',')+2;
                if($ct==2) $ct=1;
                $summary = mb_substr(trim(strip_tags($val['content'])),0,40,"utf-8");
                $pass = empty($val['img_url'])?"":"http://it2048.cn".Yii::app()->request->baseUrl.$val['img_url'];
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
        $list = AppJxNews::model()->findAll("type=:tp and child_list!='' order by id desc limit {$lmt},20",array(":tp"=>$type));
        $sta = 1;
        $i = 0;
        foreach($list as $val)
        {
            $ct = substr_count($val['child_list'],',');
            if($ct==0) $ct = 2;
            else $ct += 2;
            $summary = mb_substr(trim(strip_tags($val['content'])),0,40,"utf-8");
            $listArr[$i] = array("id"=>$val['id'],"title"=>$val['title'],"img_url"=>$this->getSlt("http://it2048.cn".Yii::app()->request->baseUrl.$val['img_url'],$sta),
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
        $list = AppJxNews::model()->findAll("type=:tp and child_list!='' order by id desc limit {$lmt},20",array(":tp"=>$type));
        $sta = 1;
        $i = 0;
        foreach($list as $val)
        {
            $ct = substr_count($val['child_list'],',');
            if($ct==0) $ct = 2;
            else $ct += 2;
            $summary = mb_substr(trim(strip_tags($val['content'])),0,40,"utf-8");
            $listArr[$i] = array("id"=>$val['id'],"title"=>$val['title'],"img_url"=>$this->getSlt("http://it2048.cn".Yii::app()->request->baseUrl.$val['img_url'],$sta),
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
        $list = AppJxNews::model()->findAll("type=:tp order by id desc limit {$cnt},20",array(":tp"=>$type));
        $sta = $type==3?1:0;
        foreach($list as $val)
        {
            $summary = mb_substr(trim(strip_tags($val['content'])),0,40,"utf-8");
            $ct = substr_count($val['child_list'],',')+2;
            $pass = empty($val['img_url'])?"":"http://it2048.cn".Yii::app()->request->baseUrl.$val['img_url'];
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
            return "http://it2048.cn".Yii::app()->request->baseUrl.$str;
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
            $src = ltrim($row['source'],"《");
            $src = rtrim($src,"》");
            $this->msgsucc($msg);
            if($type==0)
            {
                $msg['data'] = array("id"=>$row['id'],"addtime"=>$row['addtime'],"title"=>$row['title']
                ,"content"=>$row['content']
                ,"img_url"=>$this->img_revert($row['img_url'])
                ,"comment"=>$row['comment']
                ,"like"=>$row['like']
                ,"han"=>$row['han']
                ,"hate"=>$row['hate']
                ,"source"=>$src
                ,"comtype"=>$row['comtype']
                );
            }else
            {
                $tmp = array();
                array_push($tmp,array("id"=>$row['id'],"addtime"=>$row['addtime'],"title"=>$row['title']
                ,"content"=>$row['content']
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
                        $sou = ltrim($val['source'],"《");
                        $sou = rtrim($sou,"》");
                        array_push($tmp,array("id"=>$val['id'],"addtime"=>$val['addtime'],"title"=>$val['title']
                        ,"content"=>$val['content']
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
                    $this->msgsucc($msg);
            }
        }
        echo json_encode($msg);
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
            $userList = AppJxUser::model()->findAll();
            $userApp = array();
            $userNc = array();
            $userImg = array();
            foreach($userList as $val)
            {
                $userApp[$val->id] = $val->tel;
                $userNc[$val->id] = $val->uname;
                $userImg[$val->id] = $val->img_url;
            }
            $page = $arr['page'];
            if($page<1)$page=1;
            $star = 20*($page-1);
            $comm = AppJxComment::model()->findAll("news_id={$news_id} order by id desc limit {$star},20");
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
                    "user_account"=>$userApp[$val->user_id],
                    "user_nic"=>$userNc[$val->user_id],
                    "addtime"=>$val->addtime,
                    "user_img"=>"http://it2048.cn".Yii::app()->request->baseUrl.$userImg[$val->user_id]
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
            $msg['msg'] = "该文章静止评论";
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
        if($tel==""||$password=="")
        {
            $msg['msg'] = "存在必填项为空，请确定参数满足条件";
            echo json_encode($msg);die();
        }
        $mod = AppJxUser::model()->find("tel=:tl",array("tl"=>$tel));
        if(empty($mod))
        {
            $model = new AppJxUser();
            $model->tel = $tel;
            $model->password = md5($password.$salt);
            $model->fhtime = time();
            $model->ctime = time();
            //注册用户默认是被封号的
            $model->type = 1;
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
        }else
        {
            $msg['msg'] = "电话已经存在";
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
            $sql = "SELECT * FROM jx_collect left join jx_news on jx_collect.news_id = jx_news.id where jx_collect.user_id={$user_id} order by time desc limit {$cnt},20"; //构造SQL
            $sqlCom = $connection->createCommand($sql);
            $lst = $sqlCom->queryAll();
            $data = array();
            $this->msgsucc($msg);
            foreach ($lst as $value) {
                $pass = empty($value['img_url'])?"":"http://it2048.cn".Yii::app()->request->baseUrl.$value['img_url'];
                $sta = $value['type']==2?1:0;
                array_push($data,array(
                    "id"=>$value['id'], //新闻编号
                    "title"=>$value['title'],"time"=>$value['addtime'],
                    "img_url"=>$this->getSlt($pass),
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
        $umode = AppJxUser::model()->find("tel=:tl",array(":tl"=>$tel));
        if(empty($umode))
        {
            $msg['msg'] = "用户不存在";
        }else
        {
            list($msec, $sec) = explode(' ', microtime());
            $code = substr($msec,4,4);
            $umode->check = $code;
            if($umode->save())
            {
                $this->msgsucc($msg);
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
            if($umode->check != $vcode)
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
            array_push($listArr,array("id"=>$val['id'],"category"=>$val['type'],"title"=>$val['title'],"summary"=>$summary,
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
//            'action' => 'comment',
//            'user_id' => '23',
//            'token'=>'7cb5f1867099ffab',
//            'news_id'=>'41',
//            'content' => '123',
//            'parent_id'=>'23',
//            'parent_user'=>"测试",
//
//        );

        $params = array(
            'action' => 'search',
            'words' => "实习生",
            'page'=>1
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
        print_r(RemoteCurl::getInstance()->post('http://127.0.0.1/jixiang/server/project/index.php',$rtnList));
    }

}