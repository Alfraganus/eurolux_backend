<?php

namespace common\modules\auth\services;

use chulakov\model\services\Service;
use common\models\User;
use common\modules\users\forms\ResetPasswordForm;
use common\modules\users\forms\SignupForm;
use common\modules\users\models\repositories\UsersRepository;
use common\modules\users\models\Users;
use Yii;
use yii\web\Request;

/**
 * Сервис обработки Пользователя
 */
class AuthService extends Service
{
    CONST SMS_CODE_LIFE_TIME = "+60 second";
    CONST AUTH_SESSION_NAME = "user-sms-validation";

    public $userSession;

    public function __construct()
    {
        $this->userSession = Yii::$app->session->get(self::AUTH_SESSION_NAME);
    }

    public function createAuthSession($smsCode, $user)
    {
        $session = Yii::$app->session;
        $session[self::AUTH_SESSION_NAME] = [
            'sms-code' => $smsCode,
            'lifetime' => strtotime(self::SMS_CODE_LIFE_TIME),
            'user'=>$user
        ];

        return $session;
    }

    public function registerUserFirstTime($phone)
    {

        $user = new Users();
        $user->scenario = Users::SCENARIO_REGISTRATION;
        $user->phone = $phone;
        if ($user->validate() && $user->save()) {
            return [
                'result'=>true,
                'message'=>$user
            ];
        }
        return [
            'result'=>false,
            'message'=>$user->errors
        ];
    }

    public function checkAuthLife(): array
    {
        $session = $this->userSession;
        if (!empty($session)) {
            $result = [
                'sessionIsAlive' => true,
                'message' => 'Session is active',
                'smsCode'=>$session['sms-code']
            ];

            if ($session['lifetime'] < time()) {
                $result = [
                    'sessionIsAlive' => false,
                    'message' => 'Session\'s lifetime has been reached',
                    'session'=>$session
                ];
            }
            return $result;
        } else {
            return [
                'sessionIsAlive'=>false,
                'message'=>'Session does not exist'
            ];
        }
    }

    public function validateSmsCode($sms)
    {
        $sessionIsAlive = $this->checkAuthLife();

        if(!isset($this->userSession['sms-code'])) {
            return [
                'validate' => false,
                'message' => 'SMS code not found',
            ];
        }

        if ($this->userSession['sms-code'] != $sms) {
            return [
                'validate' => false,
                'message' => 'Code is incorrect!',
            ];
        }

        if ($sessionIsAlive['sessionIsAlive']) {
            return [
                'validate' => true,
                'message' => 'SMS code matches'
            ];
        } else {
            return [
                'validate' => false,
                'message' => 'Session lifetime has already been reached',
                'session' => $sessionIsAlive
            ];
        }

    }

    public function personalInfoExists() : bool
    {
        $user_id = $this->userSession['user']['message']['id'];
        $userPersonalInfo = Yii::createObject(UsersRepository::class)->get($user_id);
        if (!isset($userPersonalInfo['name']) && !isset($userPersonalInfo['email']) ) {
            return false;
        }
        return true;
    }

    public function updateUsersTable($id,$requestedData) : array
    {
        $users = Yii::createObject(UsersRepository::class)->get($id);
        $users->scenario = Users::SCENARIO_UPDATE;
        foreach ($requestedData as $dataKey => $dataValue) {
            $users->$dataKey = $dataValue;
        }
        if (!$users->save() && !$users->validate()) {
            return [
                'result'=>false,
                'errors'=>array_values($users->errors)
            ];
        }
        return [
            'result'=>true,
            'model'=>$users
        ];
    }

}
