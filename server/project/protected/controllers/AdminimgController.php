<?php

class AdminimgController extends AdminSet
{
    /**
     * 图片管理
     */
    public function actionImgManager()
    {
        //print_r(Yii::app()->user->getState('username'));
        //先获取当前是否有页码信息
        $pages['pageNum'] = Yii::app()->getRequest()->getParam("pageNum", 1); //当前页
        $pages['countPage'] = Yii::app()->getRequest()->getParam("countPage", 0); //总共多少记录
        $pages['numPerPage'] = Yii::app()->getRequest()->getParam("numPerPage", 50); //每页多少条数据
        $criteria = new CDbCriteria;
        $pages['countPage'] = AppJxNews::model()->count($criteria);
        $criteria->addCondition("type=2 and child_list is not null");
        $criteria->limit = $pages['numPerPage'];
        $criteria->offset = $pages['numPerPage'] * ($pages['pageNum'] - 1);
        $criteria->order = 'id DESC';
        $allList = AppJxNews::model()->findAll($criteria);
        $this->renderPartial('imgmanager', array(
            'models' => $allList,
            'pages' => $pages),false,true);
    }

    /**
     * 保存新闻
     */
    public function actionImgSave()
    {
        $msg = array(
            "statusCode"=>200,
            "message"=>"成功",
            "navTabId"=>"",
            "rel"=>"",
            "callbackType"=>"",
            "forwardUrl"=>"",
            "confirmMsg"=>"",
            "img"=>""
        );
        $inputName = "Filedata";
        $err = "";

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
            $dest_file_path = Yii::app()->basePath . '/../public/upload/'.$flname;
            $filepathh = dirname($dest_file_path);
            if (!file_exists($filepathh))
                $b_mkdir = mkdir($filepathh, 0777, true);
            else
                $b_mkdir = true;
            if ($b_mkdir && is_dir($filepathh)) {
                //转存文件到 $dest_file_path路径
                if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $dest_file_path)) {
                    $msg['img'] ='/public/upload'.$flname;
                    $msg['rel'] = base64_encode('/public/upload'.$flname);
                }
            }
        }
        if(!empty($err))
        {
            $msg['statusCode'] = 100;
            $msg['message'] = $err;
        }
        echo json_encode($msg);
    }

    /**
     * 添加新闻
     */
    public function actionNewsAdd()
    {
        $this->renderPartial('newsadd');
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
            $model = AppJxNews::model()->findByPk($id);
            $tst = $model->child_list==""?$id:$id.",".$model->child_list;
            
            if(AppJxNews::model()->deleteAll("id in({$tst})"))
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
     * 编辑新闻
     */
    public function actionImgdel()
    {
        $msg = $this->msgcode();
        $ph = Yii::app()->getRequest()->getParam("ph", 0); //用户名
        $ph = base64_decode($ph);
        $this->msgsucc($msg);
        @unlink(Yii::app()->basePath . '/..'.$ph);
        echo json_encode($msg);
    }
    /**
     * 编辑新闻
     */
    public function actionSave()
    {
        $msg = $this->msgcode();
        $title = Yii::app()->getRequest()->getParam("news_title", ""); //新闻标题
        $source = Yii::app()->getRequest()->getParam("news_source", ""); //新闻来源
        if($title=="") $msg['msg'] = "标题不能为空";
        else
        {
            $username = $this->getUserName(); //用户名
            $idArr = array();
            for($i=0;$i<30;$i++)
            {
                $url = Yii::app()->getRequest()->getParam("url{$i}", ""); //图片地址
                if($url=="")continue;
                $desc = Yii::app()->getRequest()->getParam("desc{$i}", ""); //图片描述
                $model = new AppJxNews();
                $model->title = $title;
                $model->type = 2;
                $model->status = 0;
                $model->content = $desc;
                $model->addtime = time();
                $model->adduser = $username;
                $model->img_url = $url;
                $model->source = $source;
                if($model->save())
                {
                    array_push($idArr,Yii::app()->db->getLastInsertID());
                }
            }
            if(count($idArr)>0)
            {
                $id = $idArr[0];
                $tst = implode(",",array_slice($idArr,2));
                $model = AppJxNews::model()->findByPk($id);
                $model->child_list = $tst;
                $model->save();
                $this->msgsucc($msg);
            }else
            {
                $msg['msg'] = "不存在图片";
            }
        }
         echo json_encode($msg);
    }


    /**
     * 编辑新闻
     */
    public function actionNewsEdit()
    {
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        $model = array();
        if($id!="")
        {
            $model = AppJxNews::model()->findByPk($id);
            $mdd = AppJxNews::model()->findAll("id in({$model->child_list})");
        }
        $this->renderPartial('newsedit',array("models"=>$model,"mdd"=>$mdd));
    }

}