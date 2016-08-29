<?php
/* @var $this Controller */
/* @var User $user Current user */

Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerCssFile(
    Yii::app()->clientScript->getCoreScriptUrl() .
        '/jui/css/base/jquery-ui.css'
);

$cssdir = Yii::app()->getAssetManager()->publish('protected/assets/css', false, -1, YII_DEBUG);
$imgdir = Yii::app()->getAssetManager()->publish('protected/assets/img', false, -1, YII_DEBUG);
$scriptsdir = Yii::app()->getAssetManager()->publish('protected/assets/scripts', false, -1, YII_DEBUG);

Yii::app()->bootstrap->register();
Yii::app()->clientScript->registerCssFile($cssdir.'/styles.css');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <!-- mobile meta -->
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo $cssdir; ?>/styles.css" />

    <title><?php echo CHtml::encode("{$this->pageTitle} | " . Yii::app()->name); ?></title>
</head>

<body>
<div id="wrap">
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <a href="<?php echo Yii::app()->homeUrl; ?>" class="brand">
                    <img src="<?php echo $imgdir; ?>/Coded-Internet.png" />
                </a>

                <div class="nav-collapse">
                    <?php $this->widget('zii.widgets.CMenu', array(
                        'encodeLabel' => false,
                        'htmlOptions' => array(
                            'class' => 'nav',
                        ),
                        'items' => array(
                            array('label' => Yii::t('signage','Home'), 'url' => Yii::app()->homeUrl),
                            array('label' => Yii::t('content','My Content').'<b class="caret"></b>',
                                'url' => array('/content/ '),
                                'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
                                'itemOptions' => array('class' => 'dropdown'),
                                'submenuOptions' => array('class' => 'dropdown-menu'),
                                'items' => array(
                                    array('label' => Yii::t('content','Add Content'), 'url' => array('/content/add')),
                                    array('label' => Yii::t('content','Browse Content'), 'url' => array('/content/browse')),
                                ),
                            ),
                            array('label' => Yii::t('feed','My Feeds'), 'url' => array('/feed/ ')),
                            array('label' => Yii::t('screen','My Screens').'<b class="caret"></b>',
                                    'url' => array('/screen/ '),
                                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
                                    'itemOptions' => array('class' => 'dropdown'),
                                    'submenuOptions' => array('class' => 'dropdown-menu'),
                                    'items' => array(
                                            array('label' => Yii::t('screen','Manage Screens'), 'url' => array('/screen/ ')),
                                            array('label' => Yii::t('screen','Register Screen'), 'url' => array('/screen/register')),
                                    ),
                            ),
                        ),
                    )); ?>

                    <ul class="nav pull-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="icon-user"></span>
                                <?php echo Yii::t('signage', 'Hi'); ?>
                                <?php if(Yii::app()->user->isGuest) {
                                    echo Yii::app()->user->guestName;
                                } else {
                                    echo Yii::app()->user->first_name;
                                } ?>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu user">
                                <?php
                                if(Yii::app()->user->isGuest):
                                    $this->widget('application.modules.user.components.LoginWidget');
                                else:
                                    $user = Yii::app()->getModule('user')->user();
                                    $profile = $user->profile;
                                    ?>
                                        <li class="media">
                                            <span class="pull-left">
                                                <img src="http://www.gravatar.com/avatar/<?php echo md5(trim($user->email)); ?>?d=identicon&s=64"
                                                        class="media-object" />
                                            </span>
                                            <div class="media-body">
                                                <b><?php echo $profile->first_name.' '.$profile->last_name; ?></b>
                                                <p class="muted"><?php echo $user->email; ?></p>
                                                <?php $this->widget('zii.widgets.CMenu', array(
                                                    'encodeLabel' => false,
                                                    'htmlOptions' => array(
                                                        'class' => 'inline',
                                                    ),
                                                    'items'=>array(
                                                        array(
                                                            'url'=>Yii::app()->getModule('user')->profileUrl,
                                                            'label'=>Yii::app()->getModule('user')->t('Profile'),
                                                        ),
                                                    )
                                                )); ?>
                                            </div>
                                        </li>
                                        <li class="divider"></li>
                                        <li class="row-fluid">
                                            <div>
                                                <?php echo CHtml::link(Yii::app()->getModule('user')->t("Logout"),
                                                    Yii::app()->getModule('user')->logoutUrl,
                                                    array('class'=>'btn btn-primary pull-right')
                                                ); ?>
                                            </div>
                                        </li>
                                    <?php
                                endif;
                                ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="container container-fluid">
        <div class="row-fluid">
            <?php echo $content; ?>
        </div>
    </div>
    <div id="push"></div>
    <!--#wrap-->
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
