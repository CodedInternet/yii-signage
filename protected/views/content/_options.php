<?php
/**
 * Universal inputs accross all content types
 * @var Content $model
 * @var CActiveForm $form
 */
$required=(isset($bulk) && $bulk == true)?null:'required';
?>

<div class="control-group">
    <div class="control-label">
        <?php echo $form->labelEx($model,'duration'); ?>
    </div>
    <div class="controls">
        <?php echo $form->numberField($model,'duration',array('required'=>$required,'min'=>'1')); ?>
        <?php echo $form->error($model,'duration'); ?>
    </div>
</div>

<div class="control-group">
    <div class="control-label">
        <?php echo $form->labelEx($model,'start'); ?>
    </div>
    <div class="controls">
        <?php echo $form->dateField($model,'start',array('required'=>$required)); ?>
        <?php echo $form->error($model,'start'); ?>
    </div>
</div>

<div class="control-group">
    <div class="control-label">
        <?php echo $form->labelEx($model,'end'); ?>
    </div>
    <div class="controls">
        <?php echo $form->dateField($model,'end',array('required'=>$required)); ?>
        <?php echo $form->error($model,'end'); ?>
    </div>
</div>

<div class="control-group">
    <div class="control-label">
		<?php echo $form->labelEx($model,'rank'); ?>
    </div>
    <div class="controls">
		<?php echo $form->numberField($model,'rank',array('required'=>$required,'min'=>'1','max'=>'5')); ?>
		<?php echo $form->error($model,'rank'); ?>
    </div>
</div>

<div class="control-group">
    <div class="control-label">
        <?php echo $form->labelEx($model,'idfeed'); ?>
    </div>
    <div class="controls">
        <?php echo $form->dropDownList($model,
                'idfeed',
                // Create a list from the appropriate model
                CHtml::listData(
                        Feed::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id)),
                        'idfeed',
                        'feedname'
        ),array('required'=>'required')); ?>
    </div>
</div>

<div class="controls buttons">
        <?php echo CHtml::submitButton('Submit',array('class'=>'btn btn-primary')); ?>
</div>