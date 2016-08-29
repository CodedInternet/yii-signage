<?php
/**
 * Displays a Grid View of the screens in the database
 * @var ScreenController $this
 * @var Screen $model
 * @var CActiveDataProvder $membership
 */
$this->pageTitle = Yii::t('signage','editscreen',array('idscreen'=>$model->idscreen));
?>

<?php $this->renderPartial('_form',array('model'=>$model)); ?>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'striped',
    'dataProvider'=>$membership,
    'columns'=>array(
        'idfeed',
        array(
            'name'=>Yii::t("signage","feedname"),
            'value'=>'$data->idfeed0->feedname',
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{delete}',
        ),
    ),
));
?>

<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'=>"/screen/feedadd",
	'id'=>'screen-feed-add',
	'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
));

$screenFeed=  ScreenFeed::model();
$screenFeed->idscreen = $model->idscreen;
echo $form->hiddenField($screenFeed,'idscreen');

$feeds = Feed::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id));
$memberships = $membership->getData();
$members = array();
$nonmembers = array();

foreach($memberships as $member) {
        $members[]=$member->idfeed;
}

foreach($feeds as $feed) {
        if(!in_array($feed->idfeed, $members))
                $nonmembers[$feed->idfeed]=$feed->feedname;
}
?>

        <div class="row">
        <div class="pull-right">
                <?php echo $form->dropDownList(ScreenFeed::model(),
                        'idfeed',
                        $nonmembers
                );
                ?>
        </div>
        </div>

        <div class="row">
                <div class="buttons pull-right">
                        <?php echo CHtml::submitButton(Yii::t('signage','addfeed'), array('class'=>'btn btn-primary')); ?>
                </div>
        </div>
<?php $this->endWidget(); ?>