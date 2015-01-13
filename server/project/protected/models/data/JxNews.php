<?php

/**
 * This is the model class for table "jx_news".
 *
 * The followings are the available columns in table 'jx_news':
 * @property integer $id
 * @property integer $addtime
 * @property string $adduser
 * @property string $title
 * @property string $content
 * @property string $img_url
 * @property integer $type
 * @property string $child_list
 * @property integer $comment
 * @property integer $like
 * @property integer $han
 * @property integer $hate
 * @property string $source
 * @property integer $status
 * @property integer $comtype
 */
class JxNews extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JxNews the static model class
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
		return 'jx_news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('addtime, adduser, title, content, img_url, type', 'required'),
			array('addtime, type, comment, like, han, hate, status, comtype', 'numerical', 'integerOnly'=>true),
			array('adduser', 'length', 'max'=>32),
			array('title, img_url, child_list, source', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, addtime, adduser, title, content, img_url, type, child_list, comment, like, han, hate, source, status, comtype', 'safe', 'on'=>'search'),
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
			'addtime' => 'Addtime',
			'adduser' => 'Adduser',
			'title' => 'Title',
			'content' => 'Content',
			'img_url' => 'Img Url',
			'type' => 'Type',
			'child_list' => 'Child List',
			'comment' => 'Comment',
			'like' => 'Like',
			'han' => 'Han',
			'hate' => 'Hate',
			'source' => 'Source',
			'status' => 'Status',
			'comtype' => 'Comtype',
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
		$criteria->compare('addtime',$this->addtime);
		$criteria->compare('adduser',$this->adduser,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('img_url',$this->img_url,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('child_list',$this->child_list,true);
		$criteria->compare('comment',$this->comment);
		$criteria->compare('like',$this->like);
		$criteria->compare('han',$this->han);
		$criteria->compare('hate',$this->hate);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('comtype',$this->comtype);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}