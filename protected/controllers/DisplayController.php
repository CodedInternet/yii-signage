<?php

class DisplayController extends Controller
{
    public $layout = false;

    /**
     * Checks if the display has a hash, if so update the expire date, else
     * create a new one based on a 32 char random string.
     * Send the code required to display content to the screen.
     */
    public function actionIndex()
    {
        $screenhash = Yii::app()->request->cookies->contains('screenhash') ?
                Yii::app()->request->cookies['screenhash']->value : false;

        if (!$screenhash) {
            $screenhash = Randomness::randomString(Yii::app()->params['screenhash']['short']);;
            $screen = new Screen;
            $screen->setScenario('hash');
            $screen->hash = $screenhash;
            $screen->save();
        }

        Yii::app()->request->cookies['screenhash'] = new CHttpCookie('screenhash', $screenhash, array(
            'expire' => strtotime('+ 5 years'),
        ));

        $screen = Screen::model()->find("hash='$screenhash'");

        if ($screen == null) {
            unset(Yii::app()->request->cookies['screenhash']);
            $this->refresh(true);
        }

        if ($screen->user_id == null) {
            $this->render('register', array('screenhash' => $screenhash));
        } else {
            if (strlen($screenhash) == Yii::app()->params['screenhash']['short']) {
                $screen->setScenario('hash');
                $screenhash = Randomness::randomString(Yii::app()->params['screenhash']['long']);
                $screen->hash = $screenhash;
                $screen->save();
                Yii::app()->request->cookies['screenhash'] = new CHttpCookie('screenhash', $screenhash, array(
                    'expire' => strtotime('+ 5 years'),
                ));
            }
            $this->setTheme($screen);
            $this->render('screen',array('screen'=>$screen));
        }
    }

    /**
     * Display content of a specific type for this screen
     * @param String $type The content type requested
     * @throws CHttpException If the screen isnt registered or it isnt AJAX
     */
    public function actionContent($type)
    {
        $hash = Yii::app()->request->cookies->contains('screenhash') ?
                Yii::app()->request->cookies['screenhash']->value : false;

        if (!$hash /*|| !Yii::app()->request->isAjaxRequest*/)
            throw new CHttpException(403, 'This action is only allowed via AJAX with a saved screen hash.');

        $screen = Screen::model()->findByAttributes(array('hash' => $hash));
        $this->setTheme($screen);
        $output = new stdClass();

        if($type == 'img') $type = 'media';

        // Specific non-database options
        switch ($type) {
            case 'time':
                date_default_timezone_set("UTC");
                echo time()*1000;
                return;
                break;

            case 'weather':
                if(empty($screen->weatherlocation)) {
                    $output->content = '';
                    $output->duration = 5;
                    break;
                }

                // Get weather from accuweather using forecastfox
                $location = $screen->weatherlocation;
                $metric = (int)Yii::app()->params['weather']['metric'];

                $url = "http://wwwa.accuweather.com/adcbin/forecastfox/weather_data.asp?location=$location&metric=$metric";

                $ch = curl_init();
                $timeout = 0;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $file_contents = curl_exec($ch);
                curl_close($ch);

                $xml = simplexml_load_string($file_contents);

                $output->content = $this->renderPartial('weather', array('xml' => $xml), true);
                $output->duration = Yii::app()->params['weather']['interval'];
                break;

            default:
                $feeds = $screen->screenFeeds;
                $idfeeds = array();
                foreach ($feeds as $feed) {
                    $idfeeds[] = $feed->idfeed;
                }

                $content = Content::model()->findAllByAttributes(
                    array(
                        'idfeed' => $idfeeds,
                        'content_type' => $type,
                    ),
                    array(
                        'condition' => '`start`<=:date AND `end`>=:date',
                        'params' => array(
                            ':date' => date('Y-m-d'),
                        ),
                    ));
		
                if (!empty($content)) {
                    // Calculate a default rank for all of the contnet to start from
                    $defaultRank = 0;
                    foreach ($content as $c) {
                        $defaultRank += $c->duration * $c->rank;
                    }

                    $weightings = array();
                    $contentDisplays = array();
                    foreach ($content as $c) {
                        $contentDisplay = ContentDisplay::model()->findByAttributes(
                            array(
                                'idcontent' => $c->idcontent,
                                'idscreen' => $screen->idscreen,
                            )
                        );

                        if (empty($contentDisplay)) {
                            // Apply the content rank to increase priority of certain bits of content
                            $weightings[$c->idcontent] = $c->rank * $defaultRank;
                        } else {
                            // If it has been shown, consider how long it has been instead
                            $weightings[$c->idcontent] = $c->rank * $contentDisplay->timeSinceLast();
                        }
                        $contentDisplays[$c->idcontent] = $contentDisplay;
                    }

                    $idcontent = Randomness::array_rand_weighted($weightings);

                    $toShow = Content::model()->findByAttributes(array(
                        'idcontent' => $idcontent,
                    ));

                    if (empty($contentDisplays[$idcontent])) {
                        $contentDisplay = new ContentDisplay;
                        $contentDisplay->idcontent = $idcontent;
                        $contentDisplay->idscreen = $screen->idscreen;
                        $contentDisplay->lastshown = time();
                        $contentDisplay->save();
                    } else {
                        $contentDisplay = $contentDisplays[$idcontent];
                        $contentDisplay->lastshown = time();
                        $contentDisplay->save();
                    }

                    if ($type == 'media') {
                        if(isset(Yii::app()->params['cdnUrl']))
                            Yii::app()->getAssetManager()->setBaseUrl(Yii::app()->params['cdnUrl']);
                        $src = Yii::app()->getAssetManager()->publish("protected/assets/content/media/{$toShow->content}");
                        if(fnmatch("video/*",mime_content_type("protected/assets/content/media/{$toShow->content}")))
                            $output->content = '<video src="' . $src . '" autoplay />';
                        else
                            $output->content = '<img src="' . $src . '" />';
                    } else {
                        $output->content = $toShow->content;
                    }
                    $output->duration = $toShow->duration;
                } else {
                    $content->content = '';
                    $output->duration = 5;
                }

//                                if(!empty($content)) {
//                                        shuffle($content);
//                                        $toShow = $content[0];
//                                        
//                                        if($type=='img') {
//                                                $output->content = '<img src="'.Yii::app()->getAssetManager()->publish("protected/assets/content/img/{$toShow->content}").'" />';
//                                        } else {
//                                                $output->content = $toShow->content;
//                                        }
//                                        $output->duration = $toShow->duration;
//                                } else {
//                                        $output->content = '';
//                                        $output->duration = 5;
//                                }
//                                break;
        }
        echo json_encode($output);
    }

    private function setTheme($screen) {
        $theme = $screen->theme;
        if(!isset($theme)) {
            $themes = Yii::app()->themeManager->getThemeNames();
            $theme = $themes[array_rand($themes, 1)];
            $screen->theme = $theme;
            $screen->save();
        }
        if(isset($_GET['theme'])) {
            $themes = Yii::app()->themeManager->getThemeNames();
            if(in_array($_GET['theme'], $themes)) {
                $theme = $_GET['theme'];
            }
        }
        Yii::app()->theme = $theme;
        return;
    }

    public function actionClean()
    {
        Screen::model()->deleteAll('`user_id` IS NULL');
    }
}

?>
