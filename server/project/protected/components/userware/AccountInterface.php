<?php
/**
 * Created by PhpStorm.
 * User: xiongfanglei
 * Date: 14-11-25
 * Time: 下午9:18
 */
class AccountInterface
{
    protected function getUrl()
    {
        return   Yii::app()->params['account_url'];
    }

    /**
     * 帐号登录验证
     * @param type $username
     * @param type $password 需要sha1
     * @return type
     * @throws Exception
     */
    public function loginCheck($username,$password)
    {
        if($username===""||$password==="")
            throw new Exception("帐号接口缺少参数");
        $tmpArr = array(
            "event"=>1,
            "username"=>$username,
            "password"=>$password
        );
        return RemoteCurl::getInstance()->post($this->getUrl(), $tmpArr);
    }
    /**
     * 用户注册
     * @param type $username
     * @param type $password
     * @return type
     * @throws Exception
     */
    public function registration($username,$password)
    {
        if($username===""||$password==="")
            throw new Exception("帐号接口缺少参数");
        $tmpArr = array(
            "event"=>2,
            "username"=>$username,
            "password"=>$password
        );
        return RemoteCurl::getInstance()->post($this->getUrl(), $tmpArr);
    }
    /**
     * 邮箱找回密码
     * @param type $username
     * @return type
     * @throws Exception
     */
    public function emailGetPass($username)
    {
        if($username==="")
            throw new Exception("帐号接口缺少参数");
        $tmpArr = array(
            "event"=>3,
            "username"=>$username
        );
        return RemoteCurl::getInstance()->post($this->getUrl(), $tmpArr);
    }
    
    /**
     * 更新用户密码
     * @param type $username
     * @param type $password
     * @return type
     * @throws Exception
     */
    public function updatePass($username,$password,$type)
    {
        if($username===""||$password==="")
            throw new Exception("帐号接口缺少参数");
        $tmpArr = array(
            "event"=>$type, //$type 4,6,9  邮箱，电话，密保找回密码
            "username"=>$username,
            "password"=>$password
        );
        return RemoteCurl::getInstance()->post($this->getUrl(), $tmpArr);
    }
    /**
     * 手机找回密码
     * @param type $username
     * @param type $password
     * @return type
     * @throws Exception
     */
    public function telGetPass($username)
    {
        if($username==="")
            throw new Exception("帐号接口缺少参数");
        $tmpArr = array(
            "event"=>5,
            "username"=>$username
        );
        return RemoteCurl::getInstance()->post($this->getUrl(), $tmpArr);
    }
    
    //6重复了
    
    /**
     * 密保找回密码
     * @param type $username
     * @return type
     * @throws Exception
     */
    public function passGetPass($username)
    {
        if($username==="")
            throw new Exception("帐号接口缺少参数");
        $tmpArr = array(
            "event"=>7,
            "username"=>$username
        );
        return RemoteCurl::getInstance()->post($this->getUrl(), $tmpArr);
    }
    
    /**
     *  密保验证
     * @param type $username
     * @param array $questionID
     * @param array $answer 需要sha1加密
     * @return type
     * @throws Exception
     */
    public function checkAnswer($username,$questionID,$answer)
    {
        if($username===""||is_array($questionID)||is_array($answer))
            throw new Exception("帐号接口缺少参数");
        $tmpArr = array(
            "event"=>8,
            "username"=>$username
        );
        foreach ($questionID as $value) {
            $tmpArr['questions'] = ":".$value;
        }
        $tmpArr['questions'] = ltrim($tmpArr['questions'],":");
        foreach ($answer as $key=>$value) {
            $tmpArr['ans'.$key] = $value;
        }
        return RemoteCurl::getInstance()->post($this->getUrl(), $tmpArr);
    }
    
    /**
     * 获取帐号状态
     * @param type $openid
     * @return type
     * @throws Exception
     */
    public function getAccountStatus($openid)
    {
        if($openid==="")
            throw new Exception("帐号接口缺少参数");
        $tmpArr = array(
            "event"=>10,
            "openid"=>$openid
        );
        return RemoteCurl::getInstance()->post($this->getUrl(), $tmpArr);
    }
    /**
     * 获取帐号信息
     * @param type $openid
     * @return type
     * @throws Exception
     */
    public function getAccountInfo($openid)
    {
        if($openid==="")
            throw new Exception("帐号接口缺少参数");
        $tmpArr = array(
            "event"=>11,
            "openid"=>$openid
        );
        return RemoteCurl::getInstance()->post($this->getUrl(), $tmpArr);
    }
    /**
     * 更新帐号基本信息
     * @param type $openid
     * @param type $name
     * @param type $qq
     * @param type $address_area
     * @param type $address_city
     * @param type $birthday_year
     * @param type $birthday_month
     * @param type $birthday_day
     * @return type
     * @throws Exception
     */
    public function updateAccount($openid,$email,$phone,$name,$qq,$address_area,$address_city,$birthday_year,$birthday_month,$birthday_day)
    {
        if($openid==="")
            throw new Exception("帐号接口缺少参数");
        $tmpArr = array(
            "event"=>12,
            "openid"=>$openid,
            "email"=>$email,
            "phone"=>$phone,
            "name"=>$name,
            "QQ"=>$qq,
            "address_area"=>$address_area,
            "address_city"=>$address_city,
            "birthday_year"=>$birthday_year,
            "birthday_month"=>$birthday_month,
            "birthday_day"=>$birthday_day
        );
        return RemoteCurl::getInstance()->post($this->getUrl(), $tmpArr);
    }
    
    /**
     * 设置密保Email
     * @param type $openid
     * @param type $email
     * @return type
     * @throws Exception
     */
    public function setEmail($openid,$email)
    {
        if($openid===""||$email==="")
            throw new Exception("帐号接口缺少参数");
        $tmpArr = array(
            "event"=>13,
            "openid"=>$openid,
            "email"=>$email
        );
        return RemoteCurl::getInstance()->post($this->getUrl(), $tmpArr);
    }
    
    /**
     * 设置密保电话
     * @param type $openid
     * @param type $phone
     * @return type
     * @throws Exception
     */
    public function setPhone($openid,$phone)
    {
        if($openid===""||$phone==="")
            throw new Exception("帐号接口缺少参数");
        $tmpArr = array(
            "event"=>14,
            "openid"=>$openid,
            "phone"=>$phone
        );
        return RemoteCurl::getInstance()->post($this->getUrl(), $tmpArr);
    }
    
    /**
     * 设置密保问题
     * @param type $openid
     * @param type $questionID
     * @param type $answer
     * @return type
     * @throws Exception
     */
    public function setAnswer($openid,$questionID,$answer)
    {
        if($openid===""||is_array($questionID)||is_array($answer))
            throw new Exception("帐号接口缺少参数");
        $tmpArr = array(
            "event"=>15,
            "openid"=>$openid
        );
        foreach ($questionID as $value) {
            $tmpArr['questions'] = ":".$value;
        }
        $tmpArr['questions'] = ltrim($tmpArr['questions'],":");
        foreach ($answer as $key=>$value) {
            $tmpArr['ans'.$key] = $value;
        }
        return RemoteCurl::getInstance()->post($this->getUrl(), $tmpArr);
    }

    /**
     * 通过旧密码改新密码
     * @param $openid
     * @param $password
     * @param $new_password
     * @return array
     * @throws Exception
     */
    public function newPassword($openid,$password,$new_password)
    {
        if($openid===""||$password===""||$new_password==="")
            throw new Exception("帐号接口缺少参数");
        $tmpArr = array(
            "event"=>16,
            "openid"=>$openid,
            "password"=>$password,
            "new_password"=>$new_password
        );
        return RemoteCurl::getInstance()->post($this->getUrl(), $tmpArr);
    }

    /**
     * 防沉迷验证
     * @param $openid
     * @param $id 身份证id
     * @return array
     * @throws Exception
     */
    public function setId($openid,$id)
    {
        if($openid===""||$id==="")
            throw new Exception("帐号接口缺少参数");
        $tmpArr = array(
            "event"=>17,
            "openid"=>$openid,
            "id"=>$id
        );
        return RemoteCurl::getInstance()->post($this->getUrl(), $tmpArr);
    }
}
