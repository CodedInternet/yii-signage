<?php
/* @var $this ScreenController */
/* @var $model Screen */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'layout'=>'horizontal',
        'id' => 'screen-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    )); ?>

    <div class="row-fluid">
        <div class="span8">

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($model); ?>

            <?php if ($model->isNewRecord /*!isset($model->hash)*/): ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'hash', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'hash', array('required' => 'required', 'placeholder' => $model->getAttributeLabel('hash'), 'maxlength' => '5')); ?>
                    <?php echo $form->error($model, 'hash'); ?>
                    </div>
                </div>
            <?php else: ?>
                <?php echo $form->hiddenField($model, 'hash'); ?>
            <?php endif; ?>

            <div class="control-group">
                <?php echo $form->labelEx($model, 'screenname', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'screenname', array('required' => 'required', 'placeholder' => Yii::t('screen', 'Screen Name'))); ?>
                <?php echo $form->error($model, 'screenname'); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model, 'location', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'location', array('required' => 'required', 'placeholder' => Yii::t('screen', 'Location'))); ?>
                <?php echo $form->error($model, 'location'); ?>
                </div>
            </div>



            <div class="control-group">
                <?php echo $form->labelEx($model, 'weatherlocation', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    if($model->getIsNewRecord()) {
                        $geoip = geoip_record_by_name($_SERVER['REMOTE_ADDR']);
                        $model->weatherlocation = WeatherLocation::model()->findByAttributes(array('city'=>$geoip['city'], 'country'=>$geoip['country_name']));
                    }
                    $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                        'model' => $model,
                        'attribute' => 'weatherlocation',
                        'sourceUrl' => '/weather/location',
                        'options' => array(
                            'minLength' => '3',
                        )
                    ));
                    ?>
                <?php echo $form->error($model, 'weatherlocation'); ?>
                </div>
            </div>
        </div>

        <?php
        $themes = Yii::app()->themeManager->getThemeNames();
        if($model->isNewRecord):
            $model->setAttribute('theme', $themes[array_rand($themes)]);
        else:
            $themeList = array();
            foreach($themes as $theme) {
                $themeList[$theme] = $theme;
            }
        ?>
            <div class="control-group span4 well">
                <div class="control-label">
                    <?php echo $form->labelEx($model, 'theme'); ?>
                </div>
                <div class="controls">
                    <?php echo $form->radioButtonList($model, 'theme', $themeList); ?>
                </div>
            </div>
        <?php
        endif;
        ?>

    </div>

    <div class="controls submit pull-right">
        <?php $submitLabel = $model->getIsNewRecord() ? "Register" : "Update"; ?>
        <?php echo CHtml::submitButton(Yii::t('screen', $submitLabel), array('class' => 'btn btn-primary')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->