<?php

/**
 * This is the model class for table "jx_user".
 *
 * The followings are the available columns in table 'jx_user':
 * @property integer $id
 * @property string $tel
 * @property string $password
 * @property string $uname
 * @property string $img_url
 * @property integer $type
 * @property integer $fhtime
 * @property integer $ctime
 * @property string $check
 * @property string $key
 * @property integer $login_time
 */
class JxUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JxUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jx_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tel, password, type, ctime', 'required'),
			array('type, fhtime, ctime, login_time', 'numerical', 'integerOnly'=>true),
			array('tel, password, uname, img_url, key', 'length', 'max'=>45),
			array('check', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tel, password, uname, img_url, type, fhtime, ctime, check, key, login_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tel' => 'Tel',
			'password' => 'Password',
			'uname' => 'Uname',
			'img_url' => 'Img Url',
			'type' => 'Type',
			'fhtime' => 'Fhtime',
			'ctime' => 'Ctime',
			'check' => 'Check',
			'key' => 'Key',
			'login_time' => 'Login Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('uname',$this->uname,true);
		$criteria->compare('img_url',$this->img_url,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('fhtime',$this->fhtime);
		$criteria->compare('ctime',$this->ctime);
		$criteria->compare('check',$this->check,true);
		$criteria->compare('key',$this->key,true);
		$criteria->compare('login_time',$this->login_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}