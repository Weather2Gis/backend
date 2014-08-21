<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Погода',
    'defaultController'=>'weather',
    'language' => 'ru',
    'sourceLanguage' => 'en',

	'preload'=>array('log'),

	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1234',
			'ipFilters'=>array('*'),
		),

	),

	'components'=>array(
		'user'=>array(

			'allowAutoLogin'=>true,
            'loginUrl'=>array('weather/login'),
		),

        /*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),*/

        'cache'=>array(
//            'class'=>'system.caching.CDbCache',
//            'cacheTableName' => 'cache',
//            'autoCreateCacheTable' => true,
//            'connectionID' => 'db',

            'class'=>'system.caching.CMemCache',
            'servers'=>array(
                array('host'=>'localhost', 'port'=>11211, 'weight'=>64),
            ),
            'useMemcached' => true,
        ),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=weather',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'user',
			'charset' => 'utf8',
		),

        'coreMessages'=>array(
            'basePath'=>'protected/messages',
        ),

		'errorHandler'=>array(
			'errorAction'=>'weather/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),

	'params'=>array(
		'adminEmail'=>'pavlik.1@mail.ru',
	),
);