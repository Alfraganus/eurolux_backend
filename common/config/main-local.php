<?php

define('DOTENV_PATH', __DIR__. "/../../");
define('DOTENV_OVERLOAD', true);
include '_db.php';
$db_name = $db['db_name'];
$username = $db['username'];
$password = $db['password'];
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => "mysql:host=localhost;dbname=$db_name",
            'username' => $username,
            'password' => $password,
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
