<?php

/**
 * This is the model class for table "rs_slide".
 *
 * The followings are the available columns in table 'rs_slide':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $img_url
 * @property string $redirect_url
 * @property integer $add_time
 * @property string $add_user
 * @property integer $status
 * @property integer $type
 */
class RsSlide extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rs_slide';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, img_url, add_time, add_user, status, type', 'required'),
			array('add_time, status, type', 'numerical', 'integerOnly'=>true),
			array('title, img_url, redirect_url', 'length', 'max'=>128),
			array('add_user', 'length', 'max'=>64),
			array('content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, content, img_url, redirect_url, add_time, add_user, status, type', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'content' => 'Content',
			'img_url' => 'Img Url',
			'redirect_url' => 'Redirect Url',
			'add_time' => 'Add Time',
			'add_user' => 'Add User',
			'status' => 'Status',
			'type' => 'Type',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('img_url',$this->img_url,true);
		$criteria->compare('redirect_url',$this->redirect_url,true);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('add_user',$this->add_user,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RsSlide the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
