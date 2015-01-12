<?php

class AdminUserController extends AdminSet
{
    /**
     * 新闻管理
     */
    public function actionUserManager()
    {
        //print_r(Yii::app()->user->getState('username'));
        //先获取当前是否有页码信息
        $pages['pageNum'] = Yii::app()->getRequest()->getParam("pageNum", 1); //当前页
        $pages['countPage'] = Yii::app()->getRequest()->getParam("countPage", 0); //总共多少记录
        $pages['numPerPage'] = Yii::app()->getRequest()->getParam("numPerPage", 50); //每页多少条数据
        $criteria = new CDbCriteria;
        $pages['countPage'] = AppJxUser::model()->count($criteria);
        $criteria->limit = $pages['numPerPage'];
        $criteria->offset = $pages['numPerPage'] * ($pages['pageNum'] - 1);
        $criteria->order = 'id DESC';
        $allList = AppJxUser::model()->findAll($criteria);
        $this->renderPartial('usermanager', array(
            'models' => $allList,
            'pages' => $pages),false,true);
    }
    
    /**
     * 重置密码
     */
    public function actionUsermm()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        $model = array();
        if($id!="")
        {
            $model = AppJxUser::model()->findByPk($id);
            $model->password = md5("123456");
            if($model->save())
                $this->msgsucc($msg);
        }else
        {
            $msg['msg'] = "帐号不能为空";
        }
        echo json_encode($msg);
    }
    /**
     * 封号
     */
    public function actionUserfh()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        $model = array();
        if($id!="")
        {
            $model = AppJxUser::model()->findByPk($id);
            $model->type = 1;
            $model->fhtime = time();
            if($model->save())
                $this->msgsucc($msg);
        }else
        {
            $msg['msg'] = "帐号不能为空";
        }
        echo json_encode($msg);
    }
    /**
     * 解封
     */
    public function actionUserjf()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        $model = array();
        if($id!="")
        {
            $model = AppJxUser::model()->findByPk($id);
            $model->type = 0;
            $model->fhtime = time();
            if($model->save())
                $this->msgsucc($msg);
        }else
        {
            $msg['msg'] = "帐号不能为空";
        }
        echo json_encode($msg);
    }

    /**
     * 添加新闻
     */
    public function actionUserAdd()
    {
        $this->renderPartial('useradd');
    }

    /**
     * 保存新闻
     */
    public function actionUserSave()
    {
        $msg = $this->msgcode();
        $type = Yii::app()->getRequest()->getParam("user_type", 1); //类型
        $status = Yii::app()->getRequest()->getParam("user_status", 1); //状态
        $title = Yii::app()->getRequest()->getParam("user_title", ""); //用户名
        $content = Yii::app()->getRequest()->getParam("user_content", ""); //用户名
        $source = Yii::app()->getRequest()->getParam("user_source", ""); //来源
        $child_list = Yii::app()->getRequest()->getParam("user_relationid", ""); //关联
        $username = $this->getUserName(); //用户名
        $img_url = "";
        if(!empty($_FILES['user_img']['name']))
        {
            $img = array("png","jpg");
            $_tmp_pathinfo = pathinfo($_FILES['user_img']['name']);
            if (in_array(strtolower($_tmp_pathinfo['extension']),$img)) {
                //设置图片路径
                $flname = Yii::app()->params['filetmpcache'].'/'.time().".".md5($username).".".$_tmp_pathinfo['extension'];
                $dest_file_path = Yii::app()->basePath . '/../public/upload'.$flname;
                $filepathh = dirname($dest_file_path);
                if (!file_exists($filepathh))
                    $b_mkdir = mkdir($filepathh, 0777, true);
                else
                    $b_mkdir = true;
                if ($b_mkdir && is_dir($filepathh)) {
                    //转存文件到 $dest_file_path路径
                    if (move_uploaded_file($_FILES['user_img']['tmp_name'], $dest_file_path)) {
                        $img_url ='/public/upload'.$flname;
                    }
                }
            } else {
                $msg["msg"] = '上传的文件格式只能为jpg,png';
                $msg["code"] = 3;
            }
        }

        if($username!=""&&$title!="")
        {
            $model = new AppJxUser();
            $model->title = $title;
            $model->type = $type;
            $model->status = $status;
            $model->content = $content;
            $model->addtime = time();
            $model->adduser = $username;
            $model->img_url = $img_url;
            $model->source = $source;
            $model->child_list = $child_list;
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
     * 编辑新闻
     */
    public function actionUserEdit()
    {
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        $model = array();
        if($id!="")
            $model = AppJxUser::model()->findByPk($id);
        $this->renderPartial('useredit',array("models"=>$model));
    }
    
        /**
     * 保存新闻
     */
    public function actionUserUpdate()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", ""); //编号
        $type = Yii::app()->getRequest()->getParam("user_type", 1); //类型
        $status = Yii::app()->getRequest()->getParam("user_status", 1); //状态
        $title = Yii::app()->getRequest()->getParam("user_title", ""); //用户名
        $content = Yii::app()->getRequest()->getParam("user_content", ""); //用户名
        $source = Yii::app()->getRequest()->getParam("user_source", ""); //来源
        $child_list = Yii::app()->getRequest()->getParam("user_relationid", ""); //关联

        $comment = Yii::app()->getRequest()->getParam("user_comment", ""); //关联
        $han = Yii::app()->getRequest()->getParam("user_han", ""); //关联
        $like = Yii::app()->getRequest()->getParam("user_like", ""); //关联
        $hate = Yii::app()->getRequest()->getParam("user_hate", ""); //关联

        $img_url = Yii::app()->getRequest()->getParam("user_img", "");
        $username = $this->getUserName(); //用户名

        $model = AppJxUser::model()->findByPk($id);
        if($img_url=="")
        {
            if(!empty($_FILES['user_up']['name']))
            {
                $img = array("png","jpg");
                $_tmp_pathinfo = pathinfo($_FILES['user_up']['name']);
                if (in_array(strtolower($_tmp_pathinfo['extension']),$img)) {
                    //设置图片路径
                    $flname = Yii::app()->params['filetmpcache'].'/'.time().".".md5($username).".".$_tmp_pathinfo['extension'];
                    $dest_file_path = Yii::app()->basePath . '/../public/upload'.$flname;
                    $filepathh = dirname($dest_file_path);
                    if (!file_exists($filepathh))
                        $b_mkdir = mkdir($filepathh, 0777, true);
                    else
                        $b_mkdir = true;
                    if ($b_mkdir && is_dir($filepathh)) {
                        //转存文件到 $dest_file_path路径
                        if (move_uploaded_file($_FILES['user_up']['tmp_name'], $dest_file_path)) {
                            $img_url ='/public/upload'.$flname;
                            if(strpos($model->img_url,"http://")===false)
                                @unlink(Yii::app()->basePath . '/..'.$model->img_url);
                        }
                    }
                } else {
                    $msg["msg"] = '上传的文件格式只能为jpg,png';
                    $msg["code"] = 3;
                }
            }
        }

        if($id!==""&&$username!=""&&$img_url!="")
        {
            $model->title = $title;
            $model->type = $type;
            $model->status = $status;
            $model->content = $content;
            $model->addtime = time();
            $model->source = $source;
            $model->child_list = $child_list;
            $model->comment = $comment;
            $model->han = $han;
            $model->like = $like;
            $model->hate = $hate;
            $model->img_url= $img_url;


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
     * 删除新闻
     */
    public function actionUserDel()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        if($id!=0)
        {
            if(AppJxUser::model()->deleteByPk($id))
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
}