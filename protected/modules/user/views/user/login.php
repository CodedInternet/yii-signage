<?php
$this->pageTitle=UserModule::t("Login");
?>

<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="alert alert-success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>

<div class="row">

<div class="span5">
    <div class="controls text-center">
        <?php $this->widget('ext.hoauth.widgets.HOAuth'); ?>
    </div>
</div>

<div class="span7">
    <p><?php echo UserModule::t("Please fill out the following form with your login credentials:"); ?></p>

    <div class="form-horizontal">
    <?php echo CHtml::beginForm(); ?>

        <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

        <?php echo CHtml::errorSummary($model); ?>

        <div class="control-group">
            <?php echo CHtml::activeLabelEx($model,'username',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($model,'username',array('placeholder'=>UserModule::t('Username or email'))) ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::activeLabelEx($model,'password',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activePasswordField($model,'password',array('placeholder'=>UserModule::t('Password'))) ?>
            </div>
        </div>

        <div class="controls">
            <p class="hint">
            <?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
            </p>
        </div>

        <div class="controls rememberMe">
            <?php echo CHtml::activeCheckBox($model,'rememberMe',array('class'=>'checkbox')); ?>
            <?php echo CHtml::activeLabelEx($model,'rememberMe',array('class'=>'checkbox')); ?>
        </div>

        <div class="controls submit">
            <?php echo CHtml::submitButton(UserModule::t("Login"),array('class'=>'btn btn-primary')); ?>
        </div>

    <?php echo CHtml::endForm(); ?>
    </div><!-- form -->


    <?php
    $form = new CForm(array(
        'elements'=>array(
            'username'=>array(
                'type'=>'text',
                'maxlength'=>32,
            ),
            'password'=>array(
                'type'=>'password',
                'maxlength'=>32,
            ),
            'rememberMe'=>array(
                'type'=>'checkbox',
            )
        ),

        'buttons'=>array(
            'login'=>array(
                'type'=>'submit',
                'label'=>'Login',
            ),
        ),
    ), $model);
    ?>
</div>

</div>