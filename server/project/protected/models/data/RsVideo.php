<?php

/**
 * This is the model class for table "rs_video".
 *
 * The followings are the available columns in table 'rs_video':
 * @property integer $id
 * @property integer $type
 * @property string $img_url
 * @property string $video_url
 * @property string $title
 * @property integer $add_time
 * @property string $add_user
 * @property integer $publish
 */
class RsVideo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rs_video';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, img_url, video_url, title, add_time, add_user', 'required'),
			array('type, add_time, publish', 'numerical', 'integerOnly'=>true),
			array('img_url, video_url, title', 'length', 'max'=>128),
			array('add_user', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, img_url, video_url, title, add_time, add_user, publish', 'safe', 'on'=>'search'),
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
			'type' => 'Type',
			'img_url' => 'Img Url',
			'video_url' => 'Video Url',
			'title' => 'Title',
			'add_time' => 'Add Time',
			'add_user' => 'Add User',
			'publish' => 'Publish',
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
		$criteria->compare('type',$this->type);
		$criteria->compare('img_url',$this->img_url,true);
		$criteria->compare('video_url',$this->video_url,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('add_user',$this->add_user,true);
		$criteria->compare('publish',$this->publish);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RsVideo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
