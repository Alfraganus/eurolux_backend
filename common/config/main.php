<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cors' => [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => ['*'], // You can specify specific origins instead of '*'
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Max-Age' => 3600,
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'fileStorage' => [
            'class' => 'chulakov\filestorage\FileStorage',
            'storageBaseUrl' => '../../storage/web/',
            'storagePath' =>'../../storage/web/',
        ],
        'imageComponent' => [
            'class' => 'chulakov\filestorage\ImageComponent',
            'driver' => 'imagick'
        ],
        'flysystem' => [
            /*'class' => 'creocoder\flysystem\LocalFilesystem',
            'path' => '@api/web/upload',*/
            'class' => 'creocoder\flysystem\AwsS3Filesystem',
            'endpoint' =>'https://s3.timeweb.com',
            'key' =>'co21603',
            'secret' => '41fa3685ed08b15e59572e48eb64e3c1',
            'bucket' =>'co21603-bucket-project-time-to-exchange',
            'region' => 'ru-1',
//            'pathStyleEndpoint' => true,
        ],
        'apiResponse' => [
            'class' => 'common\components\ApiResponseComponent',
        ],
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => [
                'common\modules\users\migrations',
                'common\modules\category\migrations',
                'common\modules\publication\migrations',
            ],
        ],
    ],
];

