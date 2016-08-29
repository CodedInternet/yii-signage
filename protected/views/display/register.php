<?php
/* @var $this DisplayController */
/* @var String $screenhash Hash to be registered */

$this->pageTitle = Yii::t('display','This display requires activation');

Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerCssFile(
    Yii::app()->clientScript->getCoreScriptUrl() .
        '/jui/css/base/jquery-ui.css'
);

$cssdir = Yii::app()->getAssetManager()->publish('protected/assets/css', false, -1, YII_DEBUG);
$imgdir = Yii::app()->getAssetManager()->publish('protected/assets/img', false, -1, YII_DEBUG);
$scriptsdir = Yii::app()->getAssetManager()->publish('protected/assets/scripts', false, -1, YII_DEBUG);

Yii::app()->clientScript->registerCssFile($cssdir.'/styles.css');
Yii::app()->clientScript->registerScriptFile($scriptsdir.'/bootstrap-collapse.js');
Yii::app()->clientScript->registerScriptFile($scriptsdir.'/bootstrap-dropdown.js');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo $cssdir; ?>/styles.css" />

    <title><?php echo CHtml::encode("{$this->pageTitle} | " . Yii::app()->name); ?></title>
</head>

<body>
<div id="wrap">
    <div class="no-nav">
        <div class="container container-fluid">
            <div class="row-fluid">
                <div class="span12" id="content">
                    <div class="row-fluid">
                        <img src="<?php echo $imgdir; ?>/Coded-Internet.png" class="logo" />
                    </div>
                    <div class="row-fluid">
                        <h1><?php echo $this->pageTitle; ?></h1>
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="well">
                                <p><?php echo Yii::t('display','To activate this screen, please visit ') . Yii::app()->baseUrl . Yii::t('display',' and use the screen registration form.'); ?></p>
                                <b><?php echo Yii::t('display','Screen Activation Code');?></b>
                                <div class="text-center">
                                    <span class="btn btn-large"><b><?php echo $screenhash; ?></b></span>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="well">
                                <p><?php echo Yii::t('display','You can also activate this screen by scanning the following QR code with a smartphone.'); ?></p>
                                <div class="text-center">
                                    <?php $this->widget('application.extensions.qrcode.QRCodeGenerator',array(
                                        'data' => $this->createAbsoluteUrl("screen/register/h/$screenhash"),
                                        'filename' => "screen/register/$screenhash.png",
                                        'matrixPointSize' => 3,
                                        'displayImage' => true,
                                    )); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="push"></div>
    </div>
</div>

<div id="footer">
    <div class="text-center">&copy; <?php echo date('Y'); ?> Coded Internet</div>
    <?php if (YII_DEBUG): ?>
        <div class="text-center">
            Page generated in: <?php echo round(Yii::getLogger()->getExecutionTime(), 3); ?>s
            Memory Usage: <?php echo Yii::getLogger()->getMemoryUsage(); ?>
            <?php if(isset($_GET['mac'])) echo "MAC: {$_GET['mac']}"; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>