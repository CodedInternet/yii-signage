<?php
/* Messages to confirm the contents sumission and inform the user of the approval status
/* @var $this ContentController */
/* @var $model Content */

$this->pageTitle=Yii::t('signage','content_submitted');
?>

<p>
        <?php echo Yii::t('signage','content_submit_success',array(':user'=>Yii::app()->getModule('user')->user()->profile()->first_name)); ?>
</p>
<p>
        <?php
        if(isset($imgs)) {
                echo Yii::t('signage','content_submit_count',array(':imgs'=>$imgs));
        }
        ?>
</p>