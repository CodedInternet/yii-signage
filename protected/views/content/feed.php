<?php
/**
 * Show a summary of the content with an update form to bulk update the content
 * @param CActiveForm $form
 */
?>

<div class="form">
    <?php
    $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
    'id'=>'content-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbGridView',array(
        'type' => TbHtml::GRID_TYPE_HOVER,
        'dataProvider'=>$dataProvider,
        'rowCssClassExpression' => '( $data->end < date("Y-m-d") ? "error" : " " ) .
                ( $data->start > date("Y-m-d") ? "warning" : " " )',
        'columns'=>array(
            array(
                'class'=>'CCheckBoxColumn',
                'id'=>'idcontent',
                'selectableRows'=>2,
            ),
            array(
                'name'=>'content_type',
                'value'=>'Yii::t(\'signage\',"content_{$data->content_type}")',
            ),
            array(
                'name'=>'content',
                'type'=>'raw',
                'value'=>'($data->content_type=="media")?$data->displayMedia("s"):CHtml::encode($data->content)',
            ),
            'duration',
            array(
                'name'=>'start',
                'type'=>'date',
            ),
            array(
                'name'=>'end',
                'type'=>'date',
            ),
            'rank',
            array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'template'=>'{update}{delete}',
            ),
        )
    )); ?>

    <?php $this->renderPartial('_options',array('form'=>$form,'model'=>Content::model(),'bulk'=>true)); ?>
    <?php $this->endWidget(); ?>
</div>