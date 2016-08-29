<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span12" id="content">
    <h2><?php echo CHtml::encode($this->pageTitle); ?></h2>
    <?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>
