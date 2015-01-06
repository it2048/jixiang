<?php

class AdminhomesetController extends AdminSet
{
    
    public $descArr = array(
        "android_download"=>"安卓下载链接地址",
        "iosyy_download"=>"IOS越狱下载地址",
        "ios_download"=>"IOS下载地址",
        "linevalue"=>"预约人数",
        "novice_package"=>"新手礼包链接地址",
        "novice_strategy"=>"新手指导链接地址",
        "recharge_url"=>"支付链接地址",
        "txweibo_url"=>"腾讯微博链接地址",
        "video_url"=>"CG动画链接地址",
        "weibo_url"=>"新浪微博链接地址",
        "wp_download"=>"WP下载地址",
        "keywords"=>"首页关键词",
        "title"=>"首页SEO标题",
        "import_news"=>"置顶最新新闻编号",
        "contact_us"=>"联系我们",
        "description"=>"首页SEO描述",
        "lbm"=>"礼包码"
    );
    /**
     * 生成首页
     *
     */
    public function actionIndex()
    {
        $allList = array();
        $model = AppRsConfig::model()->findAll();
        foreach ($model as $value) {
            array_push($allList, array("text"=>  $this->descArr[$value['name']],"value"=>$value['value'],"name"=>$value['name']));
        }
        $this->renderPartial('index',array("models"=>$allList));
    }
    
    public function actionSave() {
        $msg = $this->msgcode();
        $ln = strlen(Yii::app()->getRequest()->getParam("contact_us"));
        $i = 0;
        foreach ($this->descArr as $key => $value) {
            $i++;
            $model = AppRsConfig::model()->findByPk($key);
            $model->value = Yii::app()->getRequest()->getParam($key, "");
            $model->save(); 
        }
        if($i== count($this->descArr))
        {
            $this->msgsucc($msg);
        }
        echo json_encode($msg);
    }
    
    /**
     * 幻灯片管理
     */
    public function actionSlideManager()
    {
        //print_r(Yii::app()->user->getState('username'));
        //先获取当前是否有页码信息
        $pages['pageNum'] = Yii::app()->getRequest()->getParam("pageNum", 1); //当前页
        $pages['countPage'] = Yii::app()->getRequest()->getParam("countPage", 0); //总共多少记录
        $pages['numPerPage'] = Yii::app()->getRequest()->getParam("numPerPage", 50); //每页多少条数据

        $criteria = new CDbCriteria;
        $pages['countPage'] = AppRsSlide::model()->count($criteria);
        $criteria->limit = $pages['numPerPage'];
        $criteria->offset = $pages['numPerPage'] * ($pages['pageNum'] - 1);
        $criteria->order = 'id DESC';
        $allList = AppRsSlide::model()->findAll($criteria);
        $this->renderPartial('slidemanager', array(
            'models' => $allList,
            'pages' => $pages),false,true);
    }

    /**
     * 英雄卡牌管理
     */
    public function actionHeroManager()
    {
        //先获取当前是否有页码信息
        $pages['pageNum'] = Yii::app()->getRequest()->getParam("pageNum", 1); //当前页
        $pages['countPage'] = Yii::app()->getRequest()->getParam("countPage", 0); //总共多少记录
        $pages['numPerPage'] = Yii::app()->getRequest()->getParam("numPerPage", 8); //每页多少条数据

        $criteria = new CDbCriteria;
        $pages['countPage'] = AppRsHero::model()->count($criteria);
        $criteria->limit = $pages['numPerPage'];
        $criteria->offset = $pages['numPerPage'] * ($pages['pageNum'] - 1);
        $criteria->order = 'id DESC';
        $allList = AppRsHero::model()->findAll($criteria);
        $this->renderPartial('heromanager', array(
            'models' => $allList,
            'pages' => $pages),false,true);
    }

    /**
     * 图片视频管理
     */
    public function actionVideoManager()
    {
        //先获取当前是否有页码信息
        $pages['pageNum'] = Yii::app()->getRequest()->getParam("pageNum", 1); //当前页
        $pages['countPage'] = Yii::app()->getRequest()->getParam("countPage", 0); //总共多少记录
        $pages['numPerPage'] = Yii::app()->getRequest()->getParam("numPerPage", 50); //每页多少条数据

        $criteria = new CDbCriteria;
        $pages['countPage'] = AppRsVideo::model()->count($criteria);
        $criteria->limit = $pages['numPerPage'];
        $criteria->offset = $pages['numPerPage'] * ($pages['pageNum'] - 1);
        $criteria->order = 'id DESC';
        $allList = AppRsVideo::model()->findAll($criteria);
        $this->renderPartial('videomanager', array(
            'models' => $allList,
            'pages' => $pages),false,true);
    }

    /**
     * 链接管理
     */
    public function actionLinkManager()
    {
        //print_r(Yii::app()->user->getState('username'));
        //先获取当前是否有页码信息
        $pages['pageNum'] = Yii::app()->getRequest()->getParam("pageNum", 1); //当前页
        $pages['countPage'] = Yii::app()->getRequest()->getParam("countPage", 0); //总共多少记录
        $pages['numPerPage'] = Yii::app()->getRequest()->getParam("numPerPage", 50); //每页多少条数据

        $criteria = new CDbCriteria;
        $pages['countPage'] = AppRsLink::model()->count($criteria);
        $criteria->limit = $pages['numPerPage'];
        $criteria->offset = $pages['numPerPage'] * ($pages['pageNum'] - 1);
        $criteria->order = 'id DESC';
        $allList = AppRsLink::model()->findAll($criteria);
        $this->renderPartial('linkmanager', array(
            'models' => $allList,
            'pages' => $pages),false,true);
    }


    /**
     * 新闻管理
     */
    public function actionNewsManager()
    {
        //print_r(Yii::app()->user->getState('username'));
        //先获取当前是否有页码信息
        $pages['pageNum'] = Yii::app()->getRequest()->getParam("pageNum", 1); //当前页
        $pages['countPage'] = Yii::app()->getRequest()->getParam("countPage", 0); //总共多少记录
        $pages['numPerPage'] = Yii::app()->getRequest()->getParam("numPerPage", 50); //每页多少条数据
        $criteria = new CDbCriteria;
        $pages['countPage'] = AppRsNews::model()->count($criteria);
        $criteria->limit = $pages['numPerPage'];
        $criteria->offset = $pages['numPerPage'] * ($pages['pageNum'] - 1);
        $criteria->order = 'id DESC';
        $allList = AppRsNews::model()->findAll($criteria);
        $this->renderPartial('newsmanager', array(
            'models' => $allList,
            'pages' => $pages),false,true);
    }

    /**
     * 新闻管理
     */
    public function actionOccupManager()
    {
        //print_r(Yii::app()->user->getState('username'));
        //先获取当前是否有页码信息
        $pages['pageNum'] = Yii::app()->getRequest()->getParam("pageNum", 1); //当前页
        $pages['countPage'] = Yii::app()->getRequest()->getParam("countPage", 0); //总共多少记录
        $pages['numPerPage'] = Yii::app()->getRequest()->getParam("numPerPage", 50); //每页多少条数据
        $criteria = new CDbCriteria;
        $pages['countPage'] = AppRsOccupation::model()->count($criteria);
        $criteria->limit = $pages['numPerPage'];
        $criteria->offset = $pages['numPerPage'] * ($pages['pageNum'] - 1);
        $allList = AppRsOccupation::model()->findAll($criteria);
        $this->renderPartial('occupmanager', array(
            'models' => $allList,
            'pages' => $pages),false,true);
    }

    /**
     * 添加幻灯
     */
    public function actionSlideAdd()
    {
        $this->renderPartial('slideadd');
    }

    /**
     * 添加幻灯
     */
    public function actionOccupEdit()
    {
        $id = Yii::app()->getRequest()->getParam("id", 0); //编号
        $model = array();
        if($id!="")
            $model = AppRsOccupation::model()->findByPk($id);
        $this->renderPartial('occupedit',array("models"=>$model));
    }

    /**
     * 添加英雄卡牌
     */
    public function actionHeroAdd()
    {
        $this->renderPartial('heroadd');
    }

    /**
     * 添加图片视频
     */
    public function actionVideoAdd()
    {
        $this->renderPartial('videoadd');
    }
    /**
     * 添加链接
     */
    public function actionLinkAdd()
    {
        $this->renderPartial('linkadd');
    }

    /**
     * 添加新闻
     */
    public function actionNewsAdd()
    {
        $this->renderPartial('newsadd');
    }

    /**
     * 保存新闻
     */
    public function actionNewsSave()
    {
        $msg = $this->msgcode();
        $type = Yii::app()->getRequest()->getParam("news_type", 1); //类型
        $status = Yii::app()->getRequest()->getParam("news_status", 1); //状态
        $title = Yii::app()->getRequest()->getParam("news_title", ""); //用户名
        $content = Yii::app()->getRequest()->getParam("news_content", ""); //用户名
        $username = $this->getUserName(); //用户名

        if($username!=""&&$title!=""&&$content!="")
        {
            $model = new AppRsNews();
            $model->title = $title;
            $model->type = $type;
            $model->status = $status;
            $model->content = $content;
            $model->add_time = time();
            $model->add_user = $username;
            if($model->save())
            {
                $this->msgsucc($msg);
                $msg['msg'] = "添加成功";
            }else
            {
                $msg['msg'] = "存入数据库异常";
            }

        }else{
            $msg['msg'] = "必填项不能为空";
        }
        echo json_encode($msg);
    }


    /**
     * 保存幻灯
     */
    public function actionSlideSave()
    {
        $msg = $this->msgcode();
        $type = Yii::app()->getRequest()->getParam("slide_type", 1); //用户名
        $title = Yii::app()->getRequest()->getParam("slide_title", ""); //用户名
        $img_url = Yii::app()->getRequest()->getParam("slide_img", ""); //用户名
        $redirect = Yii::app()->getRequest()->getParam("slide_redirect", ""); //用户名
        $content = Yii::app()->getRequest()->getParam("content", ""); //用户名
        $username = $this->getUserName(); //用户名
        if($img_url=="")
        {
            if(!empty($_FILES['slide_up']['name']))
            {
                $img = array("png","jpg");
                $_tmp_pathinfo = pathinfo($_FILES['slide_up']['name']);
                if (in_array(strtolower($_tmp_pathinfo['extension']),$img)) {
                    //设置图片路径
                    $flname = Yii::app()->params['filetmpcache'].'/'.time().".".md5($username).".".$_tmp_pathinfo['extension'];
                    $dest_file_path = Yii::app()->basePath . '/../public/'.$flname;
                    $filepathh = dirname($dest_file_path);
                    if (!file_exists($filepathh))
                        $b_mkdir = mkdir($filepathh, 0777, true);
                    else
                        $b_mkdir = true;
                    if ($b_mkdir && is_dir($filepathh)) {
                        //转存文件到 $dest_file_path路径
                        if (move_uploaded_file($_FILES['slide_up']['tmp_name'], $dest_file_path)) {
                            $img_url ='/public/'.$flname;
                        }
                    }
                } else {
                    $msg["msg"] = '上传的文件格式只能为jpg,png';
                    $msg["code"] = 3;
                }
            }
        }
        if($username!=""&&$title!=""&&$img_url!="")
        {
            $model = new AppRsSlide();
            $model->title = $title;
            $model->type = $type;
            $model->status = 0;
            $model->img_url = $img_url;
            $model->redirect_url = $redirect;
            $model->content = $content;
            $model->add_time = time();
            $model->add_user = $username;
            if($model->save())
            {
                $this->msgsucc($msg);
                $msg['msg'] = "添加成功";
            }else
            {
                $msg['msg'] = "存入数据库异常";
            }
            
        }else{
            if($msg["code"]!=3)
                $msg['msg'] = "必填项不能为空";
        }
        echo json_encode($msg);
    }

    /**
     * 保存英雄
     */
    public function actionHeroSave()
    {
        $msg = $this->msgcode();
        $type = Yii::app()->getRequest()->getParam("hero_type", 1); //类型0，1，2 力量，敏捷，智力
        $name = Yii::app()->getRequest()->getParam("hero_name", ""); //英雄名

        $strong = Yii::app()->getRequest()->getParam("hero_strong", ""); //力量
        $agile = Yii::app()->getRequest()->getParam("hero_agile", ""); //敏捷
        $intelligence = Yii::app()->getRequest()->getParam("hero_intelligence", ""); //智力
        $star = Yii::app()->getRequest()->getParam("hero_star", ""); //星级
        $virtue = Yii::app()->getRequest()->getParam("hero_virtue", ""); //属性

        $model = new AppRsHero();
        if(!empty($_FILES['hero_img']['name']))
        {
            $model["img_url"] = $this->storeImg($_FILES['hero_img']['name'],$_FILES['hero_img']['tmp_name'],"","her99");
        }
        $jnt = array();
        $jn = array();
        for($i=1;$i<7;$i++)
        {
            $jnt[$i] = Yii::app()->getRequest()->getParam("hero_jnt{$i}", "");
            if(!empty($_FILES['hero_jn'.$i]['name']))
            {
                $jn[$i] = $this->storeImg($_FILES['hero_jn'.$i]['name'],$_FILES['hero_jn'.$i]['tmp_name'],"",$i);
                $model["jn{$i}_url"] = $jn[$i];
            }
            $model['jnt'.$i] = $jnt[$i];
        }

        if($name!=""&&$strong!=""&&$agile!=""&&$intelligence!=""&&$star!=""&&$virtue!="")
        {
            $model->name = $name;
            $model->type = $type;
            $model->strong = $strong;
            $model->agile = $agile;
            $model->intelligence = $intelligence;
            $model->star = $star;
            $model->virtue = $virtue;
            if($model->save())
            {
                $this->msgsucc($msg);
                $msg['msg'] = "添加成功";
            }else
            {
                $msg['msg'] = "存入数据库异常";
            }

        }else{
            if($msg["code"]!=3)
                $msg['msg'] = "必填项不能为空";
        }
        echo json_encode($msg);
    }


    /**
     * 保存资料
     */
    public function actionVideoSave()
    {
        $msg = $this->msgcode();
        $type = Yii::app()->getRequest()->getParam("video_type", 0); //类型0，1 图片,视频
        $title = Yii::app()->getRequest()->getParam("video_title", ""); //资料标题
        $video_img = Yii::app()->getRequest()->getParam("video_img", ""); //封面图片
        $vedio_path = Yii::app()->getRequest()->getParam("vedio_path", ""); //资料地址

        $username = $this->getUserName(); //用户名
        if($video_img=="")
        {
            if(!empty($_FILES['video_up']['name']))
            {
                $img = array("png","jpg");
                $_tmp_pathinfo = pathinfo($_FILES['video_up']['name']);
                if (in_array(strtolower($_tmp_pathinfo['extension']),$img)) {
                    //设置图片路径
                    $flname = Yii::app()->params['filetmpcache'].'/'.time().".".md5($username).".".$_tmp_pathinfo['extension'];
                    $dest_file_path = Yii::app()->basePath . '/../public/'.$flname;
                    $filepathh = dirname($dest_file_path);
                    if (!file_exists($filepathh))
                        $b_mkdir = mkdir($filepathh, 0777, true);
                    else
                        $b_mkdir = true;
                    if ($b_mkdir && is_dir($filepathh)) {
                        //转存文件到 $dest_file_path路径
                        if (move_uploaded_file($_FILES['video_up']['tmp_name'], $dest_file_path)) {
                            $video_img ='/public/'.$flname;
                        }
                    }
                } else {
                    $msg["msg"] = '上传的文件格式只能为jpg,png';
                    $msg["code"] = 3;
                }
            }
        }
        if($vedio_path=="")
        {
            if(!empty($_FILES['video_url']['name']))
            {
                $img = array("png","jpg");
                $_tmp_pathinfo = pathinfo($_FILES['video_url']['name']);
                if (in_array(strtolower($_tmp_pathinfo['extension']),$img)) {
                    //设置图片路径
                    $flname = Yii::app()->params['filetmpcache'].'/'.time().".".md5($username).".".$_tmp_pathinfo['extension'];
                    $dest_file_path = Yii::app()->basePath . '/../public/'.$flname;
                    $filepathh = dirname($dest_file_path);
                    if (!file_exists($filepathh))
                        $b_mkdir = mkdir($filepathh, 0777, true);
                    else
                        $b_mkdir = true;
                    if ($b_mkdir && is_dir($filepathh)) {
                        //转存文件到 $dest_file_path路径
                        if (move_uploaded_file($_FILES['video_url']['tmp_name'], $dest_file_path)) {
                            $vedio_path ='/public/'.$flname;
                        }
                    }
                } else {
                    $msg["msg"] = '上传的文件格式只能为jpg,png';
                    $msg["code"] = 3;
                }
            }
        }

        if($username!=""&&$title!=""&&$video_img!=""&&$vedio_path!="")
        {
            $model = new AppRsVideo();
            $model->title = $title;
            $model->type = $type;
            $model->video_url = $vedio_path;
            $model->img_url = $video_img;
            $model->add_time = time();
            $model->add_user = $username;
            if($model->save())
            {
                $this->msgsucc($msg);
                $msg['msg'] = "添加成功";
            }else
            {
                $msg['msg'] = "存入数据库异常";
            }

        }else{
            if($msg["code"]!=3)
                $msg['msg'] = "必填项不能为空";
        }
        echo json_encode($msg);
    }

    /**
     * 更新资料
     */
    public function actionVideoUpdate()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", 0); //编号
        $type = Yii::app()->getRequest()->getParam("video_type", 0); //类型0，1 图片,视频
        $title = Yii::app()->getRequest()->getParam("video_title", ""); //资料标题
        $video_img = Yii::app()->getRequest()->getParam("video_img", ""); //封面图片
        $vedio_path = Yii::app()->getRequest()->getParam("vedio_path", ""); //资料地址

        $username = $this->getUserName(); //用户名
        $model = AppRsVideo::model()->findByPk($id);
        if($video_img=="")
        {
            if(!empty($_FILES['video_up']['name']))
            {
                $img = array("png","jpg");
                $_tmp_pathinfo = pathinfo($_FILES['video_up']['name']);
                if (in_array(strtolower($_tmp_pathinfo['extension']),$img)) {
                    //设置图片路径
                    $flname = Yii::app()->params['filetmpcache'].'/'.time().".".md5($username).".".$_tmp_pathinfo['extension'];
                    $dest_file_path = Yii::app()->basePath . '/../public/'.$flname;
                    $filepathh = dirname($dest_file_path);
                    if (!file_exists($filepathh))
                        $b_mkdir = mkdir($filepathh, 0777, true);
                    else
                        $b_mkdir = true;
                    if ($b_mkdir && is_dir($filepathh)) {
                        //转存文件到 $dest_file_path路径
                        if (move_uploaded_file($_FILES['video_up']['tmp_name'], $dest_file_path)) {
                            $video_img ='/public/'.$flname;
                            if(strpos($model->img_url,"http://")===false)
                                unlink(Yii::app()->basePath . '/..'.$model->img_url);
                        }
                    }
                } else {
                    $msg["msg"] = '上传的文件格式只能为jpg,png';
                    $msg["code"] = 3;
                }
            }
        }
        if($vedio_path=="")
        {
            if(!empty($_FILES['video_url']['name']))
            {
                $img = array("png","jpg");
                $_tmp_pathinfo = pathinfo($_FILES['video_url']['name']);
                if (in_array(strtolower($_tmp_pathinfo['extension']),$img)) {
                    //设置图片路径
                    $flname = Yii::app()->params['filetmpcache'].'/'.time().".".md5($username).".".$_tmp_pathinfo['extension'];
                    $dest_file_path = Yii::app()->basePath . '/../public/'.$flname;
                    $filepathh = dirname($dest_file_path);
                    if (!file_exists($filepathh))
                        $b_mkdir = mkdir($filepathh, 0777, true);
                    else
                        $b_mkdir = true;
                    if ($b_mkdir && is_dir($filepathh)) {
                        //转存文件到 $dest_file_path路径
                        if (move_uploaded_file($_FILES['video_url']['tmp_name'], $dest_file_path)) {
                            $vedio_path ='/public/'.$flname;
                            if(strpos($model->img_url,"http://")===false)
                                unlink(Yii::app()->basePath . '/..'.$model->video_url);
                        }
                    }
                } else {
                    $msg["msg"] = '上传的文件格式只能为jpg,png';
                    $msg["code"] = 3;
                }
            }
        }

        if($username!=""&&$title!=""&&$video_img!=""&&$vedio_path!="")
        {
            $model->title = $title;
            $model->type = $type;
            $model->video_url = $vedio_path;
            $model->img_url = $video_img;
            $model->add_time = time();
            $model->add_user = $username;
            if($model->save())
            {
                $this->msgsucc($msg);
                $msg['msg'] = "修改成功";
            }else
            {
                $msg['msg'] = "存入数据库异常";
            }

        }else{
            if($msg["code"]!=3)
                $msg['msg'] = "必填项不能为空";
        }
        echo json_encode($msg);
    }



    /**
     * 保存英雄
     */
    public function actionHeroUpdate()
    {

        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", -1); //类型0，1，2 力量，敏捷，智力
        $type = Yii::app()->getRequest()->getParam("hero_type", 1); //类型0，1，2 力量，敏捷，智力
        $name = Yii::app()->getRequest()->getParam("hero_name", ""); //英雄名

        $strong = Yii::app()->getRequest()->getParam("hero_strong", ""); //力量
        $agile = Yii::app()->getRequest()->getParam("hero_agile", ""); //敏捷
        $intelligence = Yii::app()->getRequest()->getParam("hero_intelligence", ""); //智力
        $star = Yii::app()->getRequest()->getParam("hero_star", ""); //星级
        $virtue = Yii::app()->getRequest()->getParam("hero_virtue", ""); //属性

        $model = AppRsHero::model()->findByPk($id);
        if(!empty($_FILES['hero_img']['name']))
        {
            $model["img_url"] = $this->storeImg($_FILES['hero_img']['name'],$_FILES['hero_img']['tmp_name'],$model["img_url"],"her99");
        }
        $jnt = array();
        $jn = array();
        for($i=1;$i<7;$i++)
        {
            $jnt[$i] = Yii::app()->getRequest()->getParam("hero_jnt{$i}", "");
            if(!empty($_FILES['hero_jn'.$i]['name']))
            {
                $jn[$i] = $this->storeImg($_FILES['hero_jn'.$i]['name'],$_FILES['hero_jn'.$i]['tmp_name'],$model["jn{$i}_url"],$i);
                $model["jn{$i}_url"] = $jn[$i];
            }
            $model['jnt'.$i] = $jnt[$i];
        }

        if($name!=""&&$strong!=""&&$agile!=""&&$intelligence!=""&&$star!=""&&$virtue!="")
        {
            $model->name = $name;
            $model->type = $type;
            $model->strong = $strong;
            $model->agile = $agile;
            $model->intelligence = $intelligence;
            $model->star = $star;
            $model->virtue = $virtue;
            if($model->save())
            {
                $this->msgsucc($msg);
                $msg['msg'] = "更新成功";
            }else
            {
                $msg['msg'] = "存入数据库异常";
            }

        }else{
            if($msg["code"]!=3)
                $msg['msg'] = "必填项不能为空";
        }
        echo json_encode($msg);
    }

    protected function storeImg($fname,$ftmp,$img_url,$t="0")
    {
        $img = array("png","jpg","gif");
        $_tmp_pathinfo = pathinfo($fname);
        $tmg = "";
        if (in_array(strtolower($_tmp_pathinfo['extension']),$img)) {
            //设置图片路径
            $flname = 'hero/'.time()."{$t}.".$_tmp_pathinfo['extension'];
            $dest_file_path = Yii::app()->basePath . '/../public/'.$flname;
            $filepathh = dirname($dest_file_path);
            if (!file_exists($filepathh))
                $b_mkdir = mkdir($filepathh, 0777, true);
            else
                $b_mkdir = true;
            if ($b_mkdir && is_dir($filepathh)) {
                //转存文件到 $dest_file_path路径
                if (move_uploaded_file($ftmp, $dest_file_path)) {
                    $tmg ='/public/'.$flname;
                    if($img_url!=""&&strpos($img_url,"http://")===false)
                        @unlink(Yii::app()->basePath . '/..'.$img_url);
                }
            }
        }
        return $tmg;
    }

    /**
     * 更新职业
     */
    public function actionOccupUpdate()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", -1);
        $desc = Yii::app()->getRequest()->getParam("occup_desc", "");
        $sx = Yii::app()->getRequest()->getParam("occup_sx", "");
        $wq = Yii::app()->getRequest()->getParam("occup_wq", "");
        $gj = Yii::app()->getRequest()->getParam("occup_gj", "");
        $td = Yii::app()->getRequest()->getParam("occup_td", "");

        $model = AppRsOccupation::model()->findByPk($id);
        if(!empty($_FILES['occup_img']['name']))
        {
            $model["img_url"] = $this->storeImg($_FILES['occup_img']['name'],$_FILES['occup_img']['tmp_name'],$model["img_url"],"ocu99");
        }
        $jnt = array();
        $jn = array();
        for($i=1;$i<7;$i++)
        {
            $jnt[$i] = Yii::app()->getRequest()->getParam("occup_jnt{$i}", "");
            $jname[$i] = Yii::app()->getRequest()->getParam("occup_jname{$i}", "");
            if(!empty($_FILES['occup_jn'.$i]['name']))
            {
                $jn[$i] = $this->storeImg($_FILES['occup_jn'.$i]['name'],$_FILES['occup_jn'.$i]['tmp_name'],$model["jn{$i}_url"],$i);
                $model["jn{$i}_url"] = $jn[$i];
            }
            $model['jnt'.$i] = $jnt[$i];
            $model['jname'.$i] = $jname[$i];
        }

        if($id!=-1&&$desc!=""&&$sx!=""&&$wq!=""&&$gj!="")
        {
            $model->description = $desc;
            $model->sx = $sx;
            $model->wq = $wq;
            $model->gj = $gj;
            $model->td = $td;
            if($model->save())
            {
                $this->msgsucc($msg);
                $msg['msg'] = "修改成功";
            }else
            {
                $msg['msg'] = "存入数据库异常";
            }

        }else{
            if($msg["code"]!=3)
                $msg['msg'] = "必填项不能为空";
        }
        echo json_encode($msg);
    }



    /**
     * 编辑英雄
     */
    public function actionHeroEdit()
    {
        $id = Yii::app()->getRequest()->getParam("id", 0); //编号
        $model = array();
        if($id!="")
            $model = AppRsHero::model()->findByPk($id);
        $this->renderPartial('heroedit',array("models"=>$model));
    }


    /**
     * 编辑资料
     */
    public function actionVideoEdit()
    {
        $id = Yii::app()->getRequest()->getParam("id", 0); //编号
        $model = array();
        if($id!="")
            $model = AppRsVideo::model()->findByPk($id);
        $this->renderPartial('videoedit',array("models"=>$model));
    }
    /**
     * 编辑幻灯
     */
    public function actionSlideEdit()
    {
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        $model = array();
        if($id!="")
            $model = AppRsSlide::model()->findByPk($id);
        $this->renderPartial('slideedit',array("models"=>$model));
    }


    /**
     * 保存链接
     */
    public function actionLinkSave()
    {
        $msg = $this->msgcode();
        $type = Yii::app()->getRequest()->getParam("link_type", 0); //0游戏专区，1合作媒体
        $title = Yii::app()->getRequest()->getParam("link_title", ""); //标题
        $img_url = Yii::app()->getRequest()->getParam("link_img", ""); //图片地址
        $redirect = Yii::app()->getRequest()->getParam("link_redirect", ""); //跳转地址
        $username = $this->getUserName(); //用户名
        if($img_url=="")
        {
            if(!empty($_FILES['link_up']['name']))
            {
                $img = array("png","jpg");
                $_tmp_pathinfo = pathinfo($_FILES['link_up']['name']);
                if (in_array(strtolower($_tmp_pathinfo['extension']),$img)) {
                    //设置图片路径
                    $flname = Yii::app()->params['filetmpcache'].'/'.time().".".md5($username).".".$_tmp_pathinfo['extension'];
                    $dest_file_path = Yii::app()->basePath . '/../public/'.$flname;
                    $filepathh = dirname($dest_file_path);
                    if (!file_exists($filepathh))
                        $b_mkdir = mkdir($filepathh, 0777, true);
                    else
                        $b_mkdir = true;
                    if ($b_mkdir && is_dir($filepathh)) {
                        //转存文件到 $dest_file_path路径
                        if (move_uploaded_file($_FILES['link_up']['tmp_name'], $dest_file_path)) {
                            $img_url ='/public/'.$flname;
                        }
                    }
                } else {
                    $msg["msg"] = '上传的文件格式只能为jpg,png';
                    $msg["code"] = 3;
                }
            }
        }
        if($username!=""&&$title!=""&&$img_url!="")
        {
            $model = new AppRsLink();
            $model->title = $title;
            $model->type = $type;
            $model->img_url = $img_url;
            $model->link_url = $redirect;
            $model->add_time = time();
            $model->add_user = $username;
            if($model->save())
            {
                $this->msgsucc($msg);
                $msg['msg'] = "添加成功";
            }else
            {
                $msg['msg'] = "存入数据库异常";
            }

        }else{
            if($msg["code"]!=3)
                $msg['msg'] = "必填项不能为空";
        }
        echo json_encode($msg);
    }
    /**
     * 编辑链接
     */
    public function actionLinkEdit()
    {
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        $model = array();
        if($id!="")
            $model = AppRsLink::model()->findByPk($id);
        $this->renderPartial('linkedit',array("models"=>$model));
    }

    /**
     * 编辑新闻
     */
    public function actionNewsEdit()
    {
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        $model = array();
        if($id!="")
            $model = AppRsNews::model()->findByPk($id);
        $this->renderPartial('newsedit',array("models"=>$model));
    }
    
    /**
     * 上传文件到服务器
     */
    public function actionImgUpload() {
        
        $localName = "";
        $inputName = "filedata";
        $upExt='rar,zip,jpg,jpeg,gif,png,swf';//上传扩展名
        $err = "";
        $msg = "";

        $upfile = @$_FILES[$inputName];
        if (!isset($upfile))
            $err = '文件域的name错误';
        elseif (!empty($upfile['error'])) {
            switch ($upfile['error']) {
                case '1':
                    $err = '文件大小超过了php.ini定义的upload_max_filesize值';
                    break;
                case '2':
                    $err = '文件大小超过了HTML定义的MAX_FILE_SIZE值';
                    break;
                case '3':
                    $err = '文件上传不完全';
                    break;
                case '4':
                    $err = '无文件上传';
                    break;
                case '6':
                    $err = '缺少临时文件夹';
                    break;
                case '7':
                    $err = '写文件失败';
                    break;
                case '8':
                    $err = '上传被其它扩展中断';
                    break;
                case '999':
                default:
                    $err = '无有效错误代码';
            }
        } elseif (empty($upfile['tmp_name']) || $upfile['tmp_name'] == 'none')
            $err = '无文件上传';
        else {
            $username = md5($this->getUserName()); //用户名
            $_tmp_pathinfo = pathinfo($_FILES[$inputName]['name']);
            //设置图片路径
            $flname = Yii::app()->params['filetmpcache'].'/'.time().".".$username.".".$_tmp_pathinfo['extension'];
            $dest_file_path = Yii::app()->basePath . '/../public/'.$flname;
            $filepathh = dirname($dest_file_path);
            if (!file_exists($filepathh))
                $b_mkdir = mkdir($filepathh, 0777, true);
            else
                $b_mkdir = true;
            if ($b_mkdir && is_dir($filepathh)) {
                //转存文件到 $dest_file_path路径
                if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $dest_file_path)) {
                    $img_url ='http://rs.windplay.cn/public/'.$flname;
                    $msg="{'url':'".$img_url."','localname':'".$this->jsonString($localName)."','id':1}";
                }
            } 
        }
        echo "{'err':'".$this->jsonString($err)."','msg':".$msg."}";
       
    }
    private function jsonString($str)
    {
        return preg_replace("/([\\\\\/'])/",'\\\$1',$str);
    }
    
    /**
     * 更新幻灯
     */
    public function actionSlideUpdate()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", 1); //用户名
        $type = Yii::app()->getRequest()->getParam("slide_type", 1); //用户名
        $status = Yii::app()->getRequest()->getParam("slide_status", 0); //用户名
        $title = Yii::app()->getRequest()->getParam("slide_title", ""); //用户名
        $img_url = Yii::app()->getRequest()->getParam("slide_img", ""); //用户名
        $redirect = Yii::app()->getRequest()->getParam("slide_redirect", ""); //用户名
        
        $content = Yii::app()->getRequest()->getParam("content", ""); //用户名
        $username = $this->getUserName(); //用户名
        $model = AppRsSlide::model()->findByPk($id);
        if($img_url=="")
        {
            if(!empty($_FILES['slide_up']['name']))
            {
                $img = array("png","jpg");
                $_tmp_pathinfo = pathinfo($_FILES['slide_up']['name']);
                if (in_array(strtolower($_tmp_pathinfo['extension']),$img)) {
                    //设置图片路径
                    $flname = Yii::app()->params['filetmpcache'].'/'.time().".".md5($username).".".$_tmp_pathinfo['extension'];
                    $dest_file_path = Yii::app()->basePath . '/../public/'.$flname;
                    $filepathh = dirname($dest_file_path);
                    if (!file_exists($filepathh))
                        $b_mkdir = mkdir($filepathh, 0777, true);
                    else
                        $b_mkdir = true;
                    if ($b_mkdir && is_dir($filepathh)) {
                        //转存文件到 $dest_file_path路径
                        if (move_uploaded_file($_FILES['slide_up']['tmp_name'], $dest_file_path)) {
                            $img_url ='/public/'.$flname;
                            if(strpos($model->img_url,"http://")===false)
                                unlink(Yii::app()->basePath . '/..'.$model->img_url);
                        }
                    }
                } else {
                    $msg["msg"] = '上传的文件格式只能为jpg,png';
                    $msg["code"] = 3;
                }
            }
        }

        if($username!=""&&$title!=""&&$img_url!=""&&$id!="")
        {
            $model->title = $title;
            $model->type = $type;
            $model->status = $status;
            $model->img_url = $img_url;
            $model->redirect_url = $redirect;
            $model->content = $content;
            $model->add_time = time();
            $model->add_user = $username;
            if($model->save())
            {
                $this->msgsucc($msg);
                $msg['msg'] = "更新成功";
            }else
            {
                $msg['msg'] = "存入数据库异常";
            }
            
        }else
        {
            if($msg["code"]!=3)
                $msg['msg'] = "必填项不能为空";
        }
        echo json_encode($msg);
    }

    /**
     * 更新链接
     */
    public function actionLinkUpdate()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", 1); //用户名
        $type = Yii::app()->getRequest()->getParam("link_type", 0); //0游戏专区，1合作媒体
        $title = Yii::app()->getRequest()->getParam("link_title", ""); //标题
        $img_url = Yii::app()->getRequest()->getParam("link_img", ""); //图片地址
        $redirect = Yii::app()->getRequest()->getParam("link_redirect", ""); //跳转地址
        $username = $this->getUserName(); //用户名
        $model = AppRsLink::model()->findByPk($id);
        if($img_url=="")
        {
            if(!empty($_FILES['link_up']['name']))
            {
                $img = array("png","jpg");
                $_tmp_pathinfo = pathinfo($_FILES['link_up']['name']);
                if (in_array(strtolower($_tmp_pathinfo['extension']),$img)) {
                    //设置图片路径
                    $flname = Yii::app()->params['filetmpcache'].'/'.time().".".md5($username).".".$_tmp_pathinfo['extension'];
                    $dest_file_path = Yii::app()->basePath . '/../public/'.$flname;
                    $filepathh = dirname($dest_file_path);
                    if (!file_exists($filepathh))
                        $b_mkdir = mkdir($filepathh, 0777, true);
                    else
                        $b_mkdir = true;
                    if ($b_mkdir && is_dir($filepathh)) {
                        //转存文件到 $dest_file_path路径
                        if (move_uploaded_file($_FILES['link_up']['tmp_name'], $dest_file_path)) {
                            $img_url ='/public/'.$flname;
                            if(strpos($model->img_url,"http://")===false)
                                unlink(Yii::app()->basePath . '/..'.$model->img_url);
                        }
                    }
                } else {
                    $msg["msg"] = '上传的文件格式只能为jpg,png';
                    $msg["code"] = 3;
                }
            }
        }
        if($username!=""&&$title!=""&&$img_url!="")
        {
            $model->title = $title;
            $model->type = $type;
            $model->img_url = $img_url;
            $model->link_url = $redirect;
            $model->add_time = time();
            $model->add_user = $username;
            if($model->save())
            {
                $this->msgsucc($msg);
                $msg['msg'] = "添加成功";
            }else
            {
                $msg['msg'] = "存入数据库异常";
            }

        }else{
            if($msg["code"]!=3)
                $msg['msg'] = "必填项不能为空";
        }
        echo json_encode($msg);
    }
    
        /**
     * 保存新闻
     */
    public function actionNewsUpdate()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", ""); //编号
        $type = Yii::app()->getRequest()->getParam("news_type", 1); //类型
        $status = Yii::app()->getRequest()->getParam("news_status", 1); //状态
        $title = Yii::app()->getRequest()->getParam("news_title", ""); //标题
        $content = Yii::app()->getRequest()->getParam("news_content", ""); //内容
        $username = $this->getUserName(); //用户名

        if($id!==""&&$username!=""&&$title!=""&&$content!="")
        {
            $model = AppRsNews::model()->findByPk($id);
            $model->title = $title;
            $model->type = $type;
            $model->status = $status;
            $model->content = $content;
            $model->add_time = time();
            $model->add_user = $username;
            if($model->save())
            {
                $this->msgsucc($msg);
                $msg['msg'] = "更新成功";
            }else
            {
                $msg['msg'] = "存入数据库异常";
            }

        }else{
            $msg['msg'] = "必填项不能为空";
        }
        echo json_encode($msg);
    }
    
    /**
     * 删除幻灯
     */
    public function actionSlideDel()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        if($id!=0)
        {
            //图片需要一起删除
            $img = AppRsSlide::model()->findByPk($id);
            if(AppRsSlide::model()->deleteByPk($id))
            {
                if(strpos($img->img_url,"http://")===false)
                    unlink(Yii::app()->basePath . '/..'.$img->img_url);
                $this->msgsucc($msg);
            }
            else
                $msg['msg'] = "数据删除失败";
        }else
        {
            $msg['msg'] = "id不能为空";
        }
        echo json_encode($msg);
    }

    /**
     * 删除链接
     */
    public function actionLinkDel()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        if($id!=0)
        {
            //图片需要一起删除
            $img = AppRsLink::model()->findByPk($id);
            if(AppRsLink::model()->deleteByPk($id))
            {
                if(strpos($img->img_url,"http://")===false)
                    unlink(Yii::app()->basePath . '/..'.$img->img_url);
                $this->msgsucc($msg);
            }
            else
                $msg['msg'] = "数据删除失败";
        }else
        {
            $msg['msg'] = "id不能为空";
        }
        echo json_encode($msg);
    }
    
    /**
     * 删除新闻
     */
    public function actionNewsDel()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        if($id!=0)
        {
            if(AppRsNews::model()->deleteByPk($id))
            {
                $this->msgsucc($msg);
            }
            else
                $msg['msg'] = "数据删除失败";
        }else
        {
            $msg['msg'] = "id不能为空";
        }
        echo json_encode($msg);
    }

    /**
     * 发布新闻
     */
    public function actionPublish()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        if($id!=0)
        {
            $model = AppRsNews::model()->findByPk($id);
            if($model->publish==0)
                $model->publish = 1;
            else
                $model->publish = 0;
            $model->add_time = time();
            if($model->save())
            {
                $this->msgsucc($msg);
            }
            else
            $msg['msg'] = "失败";
        }else
        {
            $msg['msg'] = "id不能为空";
        }
        echo json_encode($msg);
    }
    
        /**
     * 发布英雄
     */
    public function actionHeropublish()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        if($id!=0)
        {
            $model = AppRsHero::model()->findByPk($id);
            if($model->publish==0)
                $model->publish = 1;
            else
                $model->publish = 0;
            if($model->save())
            {
                $this->msgsucc($msg);
            }
            else
            $msg['msg'] = "失败";
        }else
        {
            $msg['msg'] = "id不能为空";
        }
        echo json_encode($msg);
    }
    
            /**
     * 发布视频
     */
    public function actionVideopublish()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        if($id!=0)
        {
            $model = AppRsVideo::model()->findByPk($id);
            if($model->publish==0)
                $model->publish = 1;
            else
                $model->publish = 0;
            $model->add_time = time();
            if($model->save())
            {
                $this->msgsucc($msg);
            }
            else
            $msg['msg'] = "失败";
        }else
        {
            $msg['msg'] = "id不能为空";
        }
        echo json_encode($msg);
    }

    /**
     * 删除英雄
     */
    public function actionHeroDel()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        if($id!=0)
        {
            //图片需要一起删除
            $img = AppRsHero::model()->findByPk($id);
            if(AppRsHero::model()->deleteByPk($id))
            {
                if(!empty($img->img_url))
                    @unlink(Yii::app()->basePath . '/..'.$img->img_url);
                for($i=1;$i<7;$i++)
                {
                    if(!empty($img["jn{$i}_url"]))
                    @unlink(Yii::app()->basePath . '/..'.$img["jn{$i}_url"]);
                }


                $this->msgsucc($msg);
            }
            else
                $msg['msg'] = "数据删除失败";
        }else
        {
            $msg['msg'] = "id不能为空";
        }
        echo json_encode($msg);
    }
}