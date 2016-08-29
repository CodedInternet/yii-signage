<?php

/**
 * This is the model class for table "{{feed}}".
 *
 * The followings are the available columns in table '{{feed}}':
 * @property integer $idfeed
 * @property integer $user_id
 * @property string $feedname
 *
 * The followings are the available model relations:
 * @property Content[] $contents
 * @property Users $user
 * @property ScreenFeed[] $screenFeeds
 */
class Feed extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Feed the static model class
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
		return '{{feed}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, feedname', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('feedname', 'length', 'max'=>80),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idfeed, feedname, user_id', 'safe', 'on'=>'search'),
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
			'contents' => array(self::HAS_MANY, 'Content', 'idfeed'),
            'user_id' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'screenFeeds' => array(self::HAS_MANY, 'ScreenFeed', 'idfeed'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idfeed' => Yii::t('signage','idfeed'),
			'feedname' =>  Yii::t('signage','feedname'),
			'user_id' =>  Yii::t('signage','user_id'),
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

		$criteria->compare('idfeed',$this->idfeed);
		$criteria->compare('feedname',$this->feedname,true);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function authorise($idfeed) {
        $model = Feed::model()->findByAttributes(array('idfeed'=>$idfeed));
        if($model->user_id!==Yii::app()->user->id)
            throw new CHttpException(403,Yii::t('signage','access_denied'));
    }
}