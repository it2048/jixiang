<?php

/**
 * This is the model class for table "rs_occupation".
 *
 * The followings are the available columns in table 'rs_occupation':
 * @property integer $id
 * @property integer $type
 * @property string $sx
 * @property string $wq
 * @property string $gj
 * @property string $td
 * @property string $img_url
 * @property string $jn1_url
 * @property string $jn2_url
 * @property string $jn3_url
 * @property string $jn4_url
 * @property string $jn5_url
 * @property string $jn6_url
 * @property string $jnt1
 * @property string $jnt2
 * @property string $jnt3
 * @property string $jnt4
 * @property string $jnt5
 * @property string $jnt6
 * @property string $jname1
 * @property string $jname2
 * @property string $jname3
 * @property string $jname4
 * @property string $jname5
 * @property string $jname6
 * @property string $description
 */
class RsOccupation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rs_occupation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, sx, wq, gj, img_url', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('sx, wq, gj, jname1, jname2, jname3, jname4, jname5, jname6', 'length', 'max'=>16),
			array('td, description', 'length', 'max'=>2048),
			array('img_url, jn1_url, jn2_url, jn3_url, jn4_url, jn5_url, jn6_url', 'length', 'max'=>128),
			array('jnt1, jnt2, jnt3, jnt4, jnt5, jnt6', 'length', 'max'=>1024),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, sx, wq, gj, td, img_url, jn1_url, jn2_url, jn3_url, jn4_url, jn5_url, jn6_url, jnt1, jnt2, jnt3, jnt4, jnt5, jnt6, jname1, jname2, jname3, jname4, jname5, jname6, description', 'safe', 'on'=>'search'),
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
			'sx' => 'Sx',
			'wq' => 'Wq',
			'gj' => 'Gj',
			'td' => 'Td',
			'img_url' => 'Img Url',
			'jn1_url' => 'Jn1 Url',
			'jn2_url' => 'Jn2 Url',
			'jn3_url' => 'Jn3 Url',
			'jn4_url' => 'Jn4 Url',
			'jn5_url' => 'Jn5 Url',
			'jn6_url' => 'Jn6 Url',
			'jnt1' => 'Jnt1',
			'jnt2' => 'Jnt2',
			'jnt3' => 'Jnt3',
			'jnt4' => 'Jnt4',
			'jnt5' => 'Jnt5',
			'jnt6' => 'Jnt6',
			'jname1' => 'Jname1',
			'jname2' => 'Jname2',
			'jname3' => 'Jname3',
			'jname4' => 'Jname4',
			'jname5' => 'Jname5',
			'jname6' => 'Jname6',
			'description' => 'Description',
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
		$criteria->compare('sx',$this->sx,true);
		$criteria->compare('wq',$this->wq,true);
		$criteria->compare('gj',$this->gj,true);
		$criteria->compare('td',$this->td,true);
		$criteria->compare('img_url',$this->img_url,true);
		$criteria->compare('jn1_url',$this->jn1_url,true);
		$criteria->compare('jn2_url',$this->jn2_url,true);
		$criteria->compare('jn3_url',$this->jn3_url,true);
		$criteria->compare('jn4_url',$this->jn4_url,true);
		$criteria->compare('jn5_url',$this->jn5_url,true);
		$criteria->compare('jn6_url',$this->jn6_url,true);
		$criteria->compare('jnt1',$this->jnt1,true);
		$criteria->compare('jnt2',$this->jnt2,true);
		$criteria->compare('jnt3',$this->jnt3,true);
		$criteria->compare('jnt4',$this->jnt4,true);
		$criteria->compare('jnt5',$this->jnt5,true);
		$criteria->compare('jnt6',$this->jnt6,true);
		$criteria->compare('jname1',$this->jname1,true);
		$criteria->compare('jname2',$this->jname2,true);
		$criteria->compare('jname3',$this->jname3,true);
		$criteria->compare('jname4',$this->jname4,true);
		$criteria->compare('jname5',$this->jname5,true);
		$criteria->compare('jname6',$this->jname6,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RsOccupation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
