<?php
// Content display content
Yii::app()->clientScript->registerCoreScript('jquery.ui');
$appAssets=Yii::app()->getAssetManager()->publish('protected/assets', false, -1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($appAssets.'/scripts/jquery.aautoscroll.2.41.js');
Yii::app()->clientScript->registerScriptFile($appAssets.'/scripts/display.content.js');
Yii::app()->clientScript->registerCssFile($appAssets.'/css/bootstrap/bootstrap.css');
Yii::app()->clientScript->registerCssFile($appAssets.'/css/bootstrap/bootstrap-responsive.css');

$assets=Yii::app()->getAssetManager()->publish(Yii::app()->theme->basePath.'/assets', false, -1, YII_DEBUG);
Yii::app()->clientScript->registerCssFile($assets.'/css/display.css');
?>
<!DOCTYPE html>
<html>
    <head>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:700italic,400&subset=cyrillic-ext,latin-ext,greek-ext' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <!--<div id="left">
            <div id="ticker">
                <div class="content" data-type="ticker"></div>
            </div>
            <div id="bar">
                <div id="img">
                    <div class="content" data-type="img"></div>
                </div>
            </div>
        </div>
        <div id="right">
            <div id="clock">
                <div class="box">
                    <span id="date"></span>
                    <span id="time"></span>
                </div>
            </div>
            <div id="text">
                <div class="content" data-type="text"></div>
            </div>
            <div id="weather">
                <div class="content" data-type="weather"></div>
            </div>
        </div>-->

        <div class="wrapper row-fluid">
            <div class="span3 column">
                <div id="clock">
                    <div class="box">
                        <div id="date"></div>
                        <div id="time"></div>
                    </div>
                </div>

                <div id="text">
                    <div class="content" data-type="text"></div>
                </div>

                <div id="weather">
                    <div class="content" data-type="weather"></div>
                </div>

            </div>

            <div class="span9 column">
                <div id="ticker">
                    <div class="content" data-type="ticker"></div>
                </div>

                <div id="bar">
                    <div id="img">
                        <div class="content" data-type="media"></div>
                    </div>
                </div>

            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('.content').each(function() {
                    loadContent($(this));
                });

                startClock(
                    $('#time'),
                    $('#date')
                );
            });
        </script>
    </body>
</html>