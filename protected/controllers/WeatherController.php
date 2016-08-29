<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ghost
 * Date: 02/09/13
 * Time: 13:15
 * To change this template use File | Settings | File Templates.
 */

class WeatherController extends Controller {
    function actionLocation() {
        if(isset($_GET['term'])) {
            $term = $_GET['term'];

            $locations = WeatherLocation::model()->findAll(
                'city LIKE :term OR location LIKE :term',
                array(':term' => "$term%")
            );

            $json = array();

            foreach($locations as $l) {
                $json[] = $l->location;
            }

            echo json_encode($json);
        } else
            throw new CHttpException(404);
    }
}