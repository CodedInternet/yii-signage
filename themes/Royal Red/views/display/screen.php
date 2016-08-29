<?php
// Content display content
Yii::app()->clientScript->registerCoreScript('jquery.ui');
$appAssets=Yii::app()->getAssetManager()->publish('protected/assets', false, -1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($appAssets.'/scripts/jquery.aautoscroll.2.41.js');
Yii::app()->clientScript->registerScriptFile($appAssets.'/scripts/display.content.js');

$assets=Yii::app()->getAssetManager()->publish(Yii::app()->theme->basePath.'/assets', false, -1, YII_DEBUG);
Yii::app()->clientScript->registerCssFile($assets.'/css/display.css');
?>
<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <div id="left">
            <div id="ticker">
                <div class="content" data-type="ticker"></div>
            </div>
            <div id="bar">
                <div id="img">
                    <div class="content" data-type="media"></div>
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