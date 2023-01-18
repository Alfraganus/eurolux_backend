<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php',
    require __DIR__ . '/../../api/config/modules.php'
);

return [
    'id' => 'app-api',
    'name' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'controllerMap' => [],
    'bootstrap' => ['log'],
    'modules' => $modules,
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-ch-api',
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'parsers' => [
//                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'format' => \yii\web\Response::FORMAT_JSON,
        ],
        'user' => [
            'identityClass' => 'common\modules\users\models\UserToken',
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'advancedqwd-api',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
    ],
    'params' => $params,
];
