<?php
/* @var $this FeedController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::t('signage','feeds');
?>

<div class="pull-right">
        <?php echo CHtml::link(Yii::t('signage','create'), $this->createUrl('feed/create'), array('class'=>'button right')); ?>
</div>
<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'hover',
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        'idfeed',
        'feedname',
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'buttons'=>array(
                'update'=>array(
                    'visible'=>'false',
                ),
            ),
        ),
    ),
));
