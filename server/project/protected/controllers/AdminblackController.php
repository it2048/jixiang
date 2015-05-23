<?php

class AdminblackController extends AdminSet
{
    /**
     * 新闻管理
     */
    public function actionIndex()
    {
        $tm = time()-86400;
        //先获取当前是否有页码信息
        $pages['pageNum'] = Yii::app()->getRequest()->getParam("pageNum", 1); //当前页
        $pages['countPage'] = Yii::app()->getRequest()->getParam("countPage", 0); //总共多少记录
        $pages['numPerPage'] = Yii::app()->getRequest()->getParam("numPerPage", 50); //每页多少条数据
        $criteria = new CDbCriteria;
        $criteria->addCondition("ctn=10 and ftime>{$tm}");
        $pages['countPage'] = AppSmsNotice::model()->count($criteria);
        $criteria->limit = $pages['numPerPage'];
        $criteria->offset = $pages['numPerPage'] * ($pages['pageNum'] - 1);
        $allList = AppSmsNotice::model()->findAll($criteria);
        $this->renderPartial('index', array(
            'models' => $allList,
            'pages' => $pages),false,true);
    }

    /**
     * 删除黑名单
     */
    public function actionDel()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("tel", ""); //用户名
        if($id!="")
        {
            if(AppSmsNotice::model()->deleteByPk($id))
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