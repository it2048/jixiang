<?php

class V0Controller extends Controller
{
    /**
     * 生成首页
     *
     */
    public function actionIndex()
    {
        $sign =Yii::app()->getRequest()->getParam("sign");
        $data =Yii::app()->getRequest()->getParam("data");
        $salt = "xFlaSd!$&258";
        $arr = array("code"=>1,"msg"=>"Error","data"=>null);
        if($sign==md5($data.$salt))
        {
            $arr['code'] = 0;
            $arr['msg'] = "验证成功";
        }
        echo json_encode($arr);
    }

    public function actionDemo()
    {
        $params = array(
            'action' => 'searchPlayer1',
            'zoneId' => 1,
            'serverId' => 2,
            'playerId' => 3,
            'playerName' => 4
        );
        $salt = "xFlaSd!$&258";
        $data = json_encode($params);
        $sign = md5($data.$salt);
        $rtnList = array(
            "data"=>$data,
            "sign"=>$sign
        );
        print_r(RemoteCurl::getInstance()->post('http://127.0.0.1/jixiang/server/project/index.php', http_build_query($rtnList)));
    }
}