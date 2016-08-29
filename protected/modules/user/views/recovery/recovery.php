<?php $this->pageTitle=UserModule::t("Restore");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Restore"),
);
?>

<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
<div class="alert">
<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
</div>
<?php else: ?>

<div class="form well text-center">
<?php echo CHtml::beginForm(); ?>

	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="control-group">
		<?php echo CHtml::activeLabel($form,'login_or_email',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($form,'login_or_email') ?>
        </div>
		<p class="muted"><?php echo UserModule::t("Please enter your login or email addres."); ?></p>
	</div>
	
	<div class="control-group submit">
		<?php echo CHtml::submitButton(UserModule::t("Restore"),array('class'=>'btn btn-primary')); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
<?php endif; ?>