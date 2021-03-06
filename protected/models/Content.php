<?php

/**
 * This is the model class for table "{{content}}".
 *
 * The followings are the available columns in table '{{content}}':
 * @property integer $idcontent
 * @property integer $idfeed
 * @property string $content
 * @property string $content_type
 * @property integer $duration
 * @property string $start
 * @property string $end
 * @property integer $rank
 * @property integer $iduser
 *
 * The followings are the available model relations:
 * @property Feed $idfeed0
 * @property User $iduser0
 * @property ContentDisplay[] $contentDisplays
 */
class Content extends CActiveRecord
{
    public $media;
    public $files;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Content the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{content}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('idfeed, content_type, content, duration, user_id', 'required'),
            array('idfeed, duration, rank, user_id', 'numerical', 'integerOnly' => true),
            array('start, end', 'date', 'format' => array('yyyy-MM-dd')),
            array('end', 'compare', 'compareAttribute' => 'start', 'operator' => '>=', 'allowEmpty' => false, 'message' => '{attribute} must be greater than "{compareValue})".'),
            array('content_type', 'length', 'max' => 6),
            array('duration', 'numerical', 'min' => 1),
            array('rank', 'numerical', 'min' => 1, 'max' => 5),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('idcontent, idfeed, content, content_type, duration, start, end, rank, user_id', 'safe', 'on' => 'search'),
            // content type checks
            array('content', 'length', 'max' => 140, 'on' => 'ticker'),
            array('media', 'required', 'on' => 'media'),
            array('media', 'file', 'on' => 'media', 'types' => Yii::app()->params['mediaFormats']),
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
            'idfeed0' => array(self::BELONGS_TO, 'Feed', 'idfeed'),
            'iduser0' => array(self::BELONGS_TO, 'User', 'user_id'),
            'contentDisplays' => array(self::HAS_MANY, 'ContentDisplay', 'idcontent'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'idcontent' => Yii::t('signage', 'idcontent'),
            'idfeed' => Yii::t('signage', 'content_feed'),
            'content' => Yii::t('signage', 'content'),
            'content_type' => Yii::t('signage', 'content_type'),
            'duration' => Yii::t('signage', 'content_duration'),
            'start' => Yii::t('signage', 'content_start'),
            'end' => Yii::t('signage', 'content_end'),
            'rank' => Yii::t('signage', 'content_rank'),
            'user_id' => Yii::t('signage', 'content_iduser'),
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

        $criteria = new CDbCriteria;

        $criteria->compare('idcontent', $this->idcontent);
        $criteria->compare('idfeed', $this->idfeed);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('content_type', $this->content_type, true);
        $criteria->compare('start', $this->start, true);
        $criteria->compare('end', $this->end, true);
        $criteria->compare('rank', $this->rank);
        $criteria->compare('user_id', $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function displayMedia($size = null) {
        if($this->content_type != 'media')
            return $this->content;

        $dimen = null;

        if($size == "s") {
            $dimen = ' width="200"';
        }

        $src = null;
        if(isset(Yii::app()->params['cdnUrl'])) {
            $baseUrl = Yii::app()->getAssetManager()->baseUrl;
            Yii::app()->getAssetManager()->setBaseUrl(Yii::app()->params['cdnUrl']);
            $src = Yii::app()->getAssetManager()->publish("protected/assets/content/media/{$this->content}");
            Yii::app()->getAssetManager()->setBaseUrl($baseUrl);
        } else {
            $src = Yii::app()->getAssetManager()->publish("protected/assets/content/media/{$this->content}");
        }

        $baseUrl = Yii::app()->getAssetManager()->baseUrl;
        Yii::app()->getAssetManager()->setBaseUrl(Yii::app()->params['cdnUrl']);
        $src = Yii::app()->getAssetManager()->publish("protected/assets/content/media/{$this->content}");
        Yii::app()->getAssetManager()->setBaseUrl($baseUrl);
        if(fnmatch("video/*",mime_content_type("protected/assets/content/media/{$this->content}")))
            return '<video src="' . $src . '" ' . $dimen . ' controls />';
        else
            return '<img src="' . $src . '" ' . $dimen . ' />';
    }
}