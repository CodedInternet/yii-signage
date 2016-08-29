<?php
/**
 * Displays a Grid View of the screens in the database
 * @var ScreenController $this
 * @var CActiveDataProvder $dataProvider
 */
$this->pageTitle=Yii::t('signage','screens');
?>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        'idscreen',
        'screenname',
        'location',
        array(
            'name'=>Yii::t("signage","feeds"),
            'value'=>'ScreenFeed::model()->countbyAttributes(array("idscreen"=>$data->idscreen))',
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{view}{delete}',
        ),
    ),
));