<?php

/**
 * This is the model class for table "jx_slide".
 *
 * The followings are the available columns in table 'jx_slide':
 * @property integer $id
 * @property integer $type
 * @property string $img_url
 * @property string $link
 * @property integer $tm
 */
class JxSlide extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JxSlide the static model class
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
		return 'jx_slide';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, tm', 'required'),
			array('id, type, tm', 'numerical', 'integerOnly'=>true),
			array('img_url, link', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, img_url, link, tm', 'safe', 'on'=>'search'),
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
			'link' => 'Link',
			'tm' => 'Tm',
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
		$criteria->compare('type',$this->type);
		$criteria->compare('img_url',$this->img_url,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('tm',$this->tm);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}