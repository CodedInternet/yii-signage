<?php

/**
 * This is the model class for table "{{screen}}".
 *
 * The followings are the available columns in table '{{screen}}':
 * @property integer $idscreen
 * @property integer $user_id
 * @property string $screenname
 * @property string $location
 * @property string $hash
 * @property string $weatherlocation
 * @property string $theme
 *
 * The followings are the available model relations:
 * @property ContentDisplay[] $contentDisplays
 * @property WeatherLocation $weatherlocation0
 * @property Users $user
 * @property ScreenFeed[] $screenFeeds
 */
class Screen extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Screen the static model class
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
		return '{{screen}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('hash', 'required'),
			array('screenname, location', 'required', 'on'=>'register, update'),
            array('hash', 'exist', 'except'=>'hash'),
            array('user_id', 'numerical', 'integerOnly'=>true),
			array('screenname, location', 'length', 'max'=>80),
			array('hash', 'length', 'max'=>32),
            array('weatherlocation', 'length', 'max'=>43),
            array('weatherlocation', 'exist', 'allowEmpty' => true, 'attributeName' => 'location', 'className' => 'WeatherLocation'),
            array('theme', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idscreen, user_id, screenname, location, hash, idweatherlocation, theme', 'safe', 'on'=>'search'),
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
            'user_id' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'contentDisplays' => array(self::HAS_MANY, 'ContentDisplay', 'idscreen'),
            'weatherlocation0' => array(self::BELONGS_TO, 'WeatherLocation', 'weatherlocation'),
			'screenFeeds' => array(self::HAS_MANY, 'ScreenFeed', 'idscreen'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idscreen' => Yii::t('signage','idscreen'),
			'screenname' => Yii::t('signage','screenname'),
			'location' => Yii::t('signage','screenlocation'),
			'hash' => Yii::t('signage','screenhash'),
            'weatherlocation' => Yii::t('signage','weatherlocation'),
            'theme' => Yii::t('signage','theme'),
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

		$criteria->compare('idscreen',$this->idscreen);
        $criteria->compare('user_id',$this->user_id);
		$criteria->compare('screenname',$this->screenname,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('hash',$this->hash,true);
        $criteria->compare('weatherlocation',$this->weatherlocation);
        $criteria->compare('theme',$this->theme);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}