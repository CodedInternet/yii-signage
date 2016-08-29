<?php $this->pageTitle=UserModule::t("Change password");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Change password"),
);
?>

<div class="form">
<?php echo CHtml::beginForm(); ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="control-group">
        <?php echo CHtml::activeLabelEx($form,'password',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activePasswordField($form,'password'); ?>
        </div>
        <p class="muted">
            <?php echo UserModule::t("Minimal password length 4 symbols."); ?>
        </p>
	</div>
	
	<div class="control-group">
        <?php echo CHtml::activeLabelEx($form,'verifyPassword',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activePasswordField($form,'verifyPassword'); ?>
        </div>
	</div>
	
	
	<div class="control-group submit">
	<?php echo CHtml::submitButton(UserModule::t("Save"),array('class'=>'btn btn-primary')); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->