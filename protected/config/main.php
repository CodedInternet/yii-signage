<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Signage',
        'defaultController'=>'content',
        'language'=>'en_gb',

	// preloading 'log' component
	'preload'=>array('log'),

    // path aliases
    'aliases' => array(
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change this if necessary
    ),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.extensions.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'bootstrap.helpers.TbHtml',
	),

	'modules'=>array(
		/*'gii'=>array(
            'generatorPaths' => array('bootstrap.gii'),
			'class'=>'system.gii.GiiModule',
			'password'=>'omnibus',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>false,
		),*/
        'user'=>array(
            # encrypting method (php hash function)
            'hash' => 'sha512',

            # send activation email
            'sendActivationMail' => true,

            # allow access for non-activated users
            'loginNotActiv' => false,

            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => false,

            # automatically login from registration
            'autoLogin' => true,

            # registration path
            'registrationUrl' => array('/user/registration'),

            # recovery password path
            'recoveryUrl' => array('/user/recovery'),

            # login form path
            'loginUrl' => array('/user/login'),

            # page after login
            'returnUrl' => array('/user/profile'),

            # page after logout
            'returnLogoutUrl' => array('/user/login'),
        ),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
            'loginUrl'=>array('user/login'),
            // enable cookie-based authentication
            'class' => 'WebUser',
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
                        'showScriptName'=>false,
                        'caseSensitive'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*
                'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
                 */
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=signage',
			'emulatePrepare' => true,
			'username' => 'signage',
			'password' => 'mysuperpass',
			'charset' => 'utf8',
            'tablePrefix'=>'signage_',
            'schemaCachingDuration'=>3600,
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				///*
//				array(
//					'class'=>'CWebLogRoute',
//				),
				//*/
			),
		),
        'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
        'cdnUrl' => 'http://cdn.'.$_SERVER['SERVER_NAME'],
		// this is used in contact page
		'adminEmail'=>'webmaster@codedinternet.com',
            
                // PHPass configuration options
                'phpass'=>array(
                        'iteration_count_log2'=>8,
                        'portable_hashes'=>false,
                ),

                'screenhash'=>array(
                        'short'=>5,
                        'long'=>32,
                ),

                'mediaFormats'=>'gif,jpeg,jpg,png,bmp,tiff,mp4',
            
                // Clock and Weather Options
                'clock'=>array(
                    'hour'=>'short',
                    'min'=>'short',
                    'interval'=>10,
                ),
                'weather'=>array(
                        'location'=>'EUR|UK|UK001|STAFFORD',
                        'metric'=>true,
                        'interval'=>60*15,
                ),
	),
);
