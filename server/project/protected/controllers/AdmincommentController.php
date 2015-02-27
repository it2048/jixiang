<?php

class AdmincommentController extends AdminSet
{
    /**
     * 新闻管理
     */
    public function actioncommentManager()
    {
        //先获取当前是否有页码信息
        $pages['pageNum'] = Yii::app()->getRequest()->getParam("pageNum", 1); //当前页
        $pages['countPage'] = Yii::app()->getRequest()->getParam("countPage", 0); //总共多少记录
        $pages['numPerPage'] = Yii::app()->getRequest()->getParam("numPerPage", 50); //每页多少条数据
        $criteria = new CDbCriteria;
        $pages['countPage'] = AppJxComment::model()->count($criteria);
        $criteria->limit = $pages['numPerPage'];
        $criteria->offset = $pages['numPerPage'] * ($pages['pageNum'] - 1);
        $criteria->order = 'id DESC';
        $allList = AppJxComment::model()->findAll($criteria);

        $strNew = "";
        $strUser = "";
        foreach($allList as $val)
        {
            $strNew .= $val->news_id.",";
            $strUser .= $val->user_id.",";
        }
        $newApp = array();
        $userApp = array();
        $strNew = rtrim($strNew,",");
        $strUser = rtrim($strUser,",");
        if($strNew != "")
        {
            $newsList = AppJxNews::model()->findAll("id in ({$strNew})");
            foreach($newsList as $val)
            {
                $newApp[$val->id] = $val->title;
            }
        }
        if($strUser != "")
        {
            $userList = AppJxUser::model()->findAll("id in ({$strUser})");
            foreach($userList as $val)
            {
                $userApp[$val->id] = $val->tel;
            }

        }


        $this->renderPartial('commentmanager', array(
            'models' => $allList,
            'pages' => $pages,
            'newApp' => $newApp,
            'userApp' => $userApp,
        ),false,true);
    }

    /**
     * 删除评论
     */
    public function actioncommentDel()
    {
        $msg = $this->msgcode();
        $id = Yii::app()->getRequest()->getParam("id", 0); //用户名
        if($id!=0)
        {
            $comm = AppJxComment::model()->findByPk($id);
            $news = AppJxNews::model()->findByPk($comm->news_id);
            if(!empty($news))
            {
                $news->comment = $news->comment-1;
                $news->save();
            }
            if($comm->delete())
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