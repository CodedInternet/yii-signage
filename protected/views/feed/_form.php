<?php
// Universal form
/* @var $this FeedController */
/* @var $model Feed */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout'=>'horizontal',
	'id'=>'feed-form',
	'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
));
?>

	<p class="muted controls">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="control-group">
        <div class="control-label">
		    <?php echo $form->labelEx($model,'feedname'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model,'feedname'); ?>
		<?php echo $form->error($model,'feedname'); ?>
        </div>
	</div>

	<div class="controls buttons">
		<?php echo CHtml::submitButton('Submit', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->