<?php echo CHtml::beginForm(array('/user/login'));

$link = '//' .
    Yii::app()->controller->uniqueid .
    '/' . Yii::app()->controller->action->id;
echo CHtml::hiddenField('quicklogin', $link);
?>

    <li class="controls">
        <?php $this->widget('ext.hoauth.widgets.HOAuth',array(
            'route'=>'user/login',
        )); ?>
    </li>

    <li class="divider"></li>

    <li class="control-group">
        <?php echo CHtml::activeLabelEx($model,'username',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($model,'username',array('placeholder'=>UserModule::t('Username or email'))) ?>
        </div>
    </li>

    <li class="control-group">
        <?php echo CHtml::activeLabelEx($model,'password',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activePasswordField($model,'password',array('placeholder'=>UserModule::t('Password'))) ?>
        </div>
    </li>

    <li class="controls">
        <p class="hint">
            <?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
        </p>
    </li>

    <li class="controls rememberMe">
        <?php echo CHtml::activeCheckBox($model,'rememberMe',array('class'=>'checkbox')); ?>
        <?php echo CHtml::activeLabelEx($model,'rememberMe',array('class'=>'checkbox')); ?>
    </li>

    <li class="row submit">
        <?php echo CHtml::submitButton('Login',array('class'=>'btn btn-primary pull-right')); ?>
    </li>

<?php echo CHtml::endForm(); ?>