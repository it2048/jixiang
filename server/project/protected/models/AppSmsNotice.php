<?php
/**
 * Created by PhpStorm.
 * User: xfl
 * Date: 2015/4/1
 * Time: 23:45
 */
class AppSmsNotice extends SmsNotice{
    /**
     * 实例化模型
     * @param string $classname
     * @return Authitem|void
     */
    public static function model($classname=__CLASS__)
    {
        return parent::model($classname);
    }
}