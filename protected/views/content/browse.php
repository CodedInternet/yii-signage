<?php
/**
 * View all the content for a feed passed to it by the controller
 * @var ContentController $this
 * @var Content $model
 * @var CActiveDataProvider $feeds
 */
$this->pageTitle=Yii::t('signage','browsecontent');
?>

<?php
$this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider'=>$feeds,
    'itemView'=>'_feed',
));