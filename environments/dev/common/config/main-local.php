<?php

# root of project folder
define('DOTENV_PATH', __DIR__. "/../../");
define('DOTENV_OVERLOAD', true);

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => getenv('DB_DSN'),
            'password' => getenv('DB_PASSWORD'),
            'username' => getenv('DB_USERNAME'),
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
