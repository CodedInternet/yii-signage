<?php
Yii::import('zii.widgets.CPortlet');

class LoginWidget extends CPortlet
{
    protected function renderContent()
    {
        Yii::app()->getModule('user');
        $this->render('loginWidget', array('model' => new UserLogin));
    }
}
?>