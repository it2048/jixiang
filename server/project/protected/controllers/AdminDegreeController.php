<?php

class AdmindegreeController extends AdminSet
{
    /**
     * 新闻管理
     */
    public function actiondegreeManager()
    {
        $newsList = AppJxNews::model()->findAll();
        $userList = AppJxUser::model()->findAll();
        $newApp = array();
        $userApp = array();
        foreach($newsList as $val)
        {
            $newApp[$val->id] = $val->title;
        }
        foreach($userList as $val)
        {
            $userApp[$val->id] = $val->tel;
        }

        //先获取当前是否有页码信息
        $pages['pageNum'] = Yii::app()->getRequest()->getParam("pageNum", 1); //当前页
        $pages['countPage'] = Yii::app()->getRequest()->getParam("countPage", 0); //总共多少记录
        $pages['numPerPage'] = Yii::app()->getRequest()->getParam("numPerPage", 50); //每页多少条数据
        $criteria = new CDbCriteria;
        $pages['countPage'] = AppJxdegree::model()->count($criteria);
        $criteria->limit = $pages['numPerPage'];
        $criteria->offset = $pages['numPerPage'] * ($pages['pageNum'] - 1);
        $criteria->order = 'news_id DESC';
        $allList = AppJxdegree::model()->findAll($criteria);
        $this->renderPartial('degreemanager', array(
            'models' => $allList,
            'pages' => $pages,
            'newApp' => $newApp,
            'userApp' => $userApp,
        ),false,true);
    }

    /**
     * 删除评论
     */
    public function actiondegreeDel()
    {
        $msg = $this->msgcode();
        $user = Yii::app()->getRequest()->getParam("user_id", 0); //用户名
        $news = Yii::app()->getRequest()->getParam("news_id", 0); //用户名
        if($user!=0&&$news!=0)
        {
            if(AppJxdegree::model()->deleteAll("user_id=:uid and news_id=:nid",array(":uid"=>$user,":nid"=>$news)))
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