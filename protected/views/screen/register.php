<?php
/*
 * @var $this ScreensController
 * @var $model Screen
 */
$this->pageTitle = Yii::t('screen','Register new display');
?>

<div class="well">
        <?php $this->renderPartial('_form',array('model'=>$model)); ?>
</div>