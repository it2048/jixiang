<?php

class AdminuserController extends AdminSet
{
    /**
     * 新闻管理
     */
    public function actionUserManager()
    {
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