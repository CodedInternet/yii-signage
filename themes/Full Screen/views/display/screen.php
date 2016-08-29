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
    <body>
        <div id="img">
            <div class="content" data-type="media"></div>
        </div>

        <div id="clock">
            <div id="date"></div>
            <div id="time"></div>
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