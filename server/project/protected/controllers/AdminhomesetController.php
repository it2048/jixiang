<?php

class AdminhomesetController extends AdminSet
{
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
        $pages['countPage'] = AppJxNews::model()->count($criteria);
        $criteria->limit = $pages['numPerPage'];
        $criteria->offset = $pages['numPerPage'] * ($pages['pageNum'] - 1);
        $criteria->order = 'id DESC';
        $allList = AppJxNews::model()->findAll($criteria);
        $this->renderPartial('newsmanager', array(
            'models' => $allList,
            'pages' => $pages),false,true);
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
        $source = Yii::app()->getRequest()->getParam("news_source", ""); //来源
        $child_list = Yii::app()->getRequest()->getParam("news_relationid", ""); //关联
        $username = $this->getUserName(); //用户名
        $img_url = "";
        if(!empty($_FILES['news_img']['name']))
        {
            $img = array("png","jpg");
            $_tmp_pathinfo = pathinfo($_FILES['news_img']['name']);
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
                    if (move_uploaded_file($_FILES['news_img']['tmp_name'], $dest_file_path)) {
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
            $model = new AppJxNews();
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
     * 编辑新闻
     */
    public function actionNewsEdit()
    {
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        $model = array();
        if($id!="")
            $model = AppJxNews::model()->findByPk($id);
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
                    $img_url ='http://it2048.cn/api/jixiang/server/project/public/'.$flname;
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
            $model = AppJxNews::model()->findByPk($id);
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
     * 删除新闻
     */
    public function actionNewsDel()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        if($id!=0)
        {
            if(AppJxNews::model()->deleteByPk($id))
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