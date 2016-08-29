<?php $this->pageTitle=UserModule::t("Registration");
?>

<?php if(Yii::app()->user->hasFlash('registration')): ?>
<div class="alert alert-success">
<?php echo Yii::app()->user->getFlash('registration'); ?>
</div>
<?php else: ?>

<div class="row">
    
<div class="span8">
    
</div>

<div class="form span4 well">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'registration-form',
	'enableAjaxValidation'=>true,
	'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
));
$model->password='';
$model->verifyPassword='';
    ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary(array($model,$profile)); ?>

	<div class="control-group">
        <?php echo $form->labelEx($model,'username',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'username',array('class'=>'input-block-level','required'=>'required','placeholder'=>UserModule::t('Username'))); ?>
        </div>
        <?php echo $form->error($model,'username'); ?>
	</div>

	<div class="control-group">
        <?php echo $form->labelEx($model,'password',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->passwordField($model,'password',array('class'=>'input-block-level','required'=>'required','placeholder'=>UserModule::t('Password'))); ?>
        </div>
        <?php echo $form->error($model,'password'); ?>
        <p class="muted">
            <?php echo UserModule::t("Minimal password length 4 symbols."); ?>
        </p>
	</div>

    <div class="control-group">
        <?php echo $form->labelEx($model,'verifyPassword',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->passwordField($model,'verifyPassword',array('class'=>'input-block-level','required'=>'required','placeholder'=>UserModule::t('Verify Password'))); ?>
        </div>
        <?php echo $form->error($model,'verifyPassword'); ?>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model,'email',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->emailField($model,'email',array('class'=>'input-block-level','required'=>'required','placeholder'=>UserModule::t('Email'))); ?>
        </div>
        <?php echo $form->error($model,'email'); ?>
    </div>

<?php
		$profileFields=Profile::getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
			?>
	<div class="control-group">
		<?php echo $form->labelEx($profile,$field->varname,array('class'=>'control-label')); ?>
        <div class="controls">
            <?php
            if ($widgetEdit = $field->widgetEdit($profile)) {
                echo $widgetEdit;
            } elseif ($field->range) {
                echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
            } elseif ($field->field_type=="TEXT") {
                echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
            } else {
                echo $form->textField($profile,$field->varname,array('class'=>'input-block-level','size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255),'placeholder'=>UserModule::t($field->title)));
            }
             ?>
        </div>
		<?php echo $form->error($profile,$field->varname); ?>
	</div>
			<?php
			}
		}
?>
	<?php if (UserModule::doCaptcha('registration')): ?>
	<div class="control-group">
		<?php echo $form->labelEx($model,'verifyCode',array('class'=>'control-label')); ?>

        <p><?php $this->widget('CCaptcha',array('clickableImage'=>true,'showRefreshButton'=>false,)); ?></p>
        <div class="controls">
            <?php echo $form->textField($model,'verifyCode',array('class'=>'input-block-level','required'=>'required')); ?>
        </div>
		<?php echo $form->error($model,'verifyCode'); ?>

		<p class="muted"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
		<br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
	</div>
	<?php endif; ?>

	<div class="controls submit">
		<?php echo CHtml::submitButton(UserModule::t("Register"),array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
</div><!-- row -->
<?php endif; ?>