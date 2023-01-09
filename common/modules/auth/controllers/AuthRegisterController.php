<?php

namespace common\modules\auth\controllers;

use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use common\modules\auth\actions\AuthProfileInfoAction;
use common\modules\auth\actions\ConfirmPhoneAction;
use common\modules\auth\actions\LoginAction;
use common\modules\auth\actions\VerifySmsAction;
use common\modules\auth\services\AuthService;
use common\modules\users\controllers\api\IndexAction;
use common\modules\users\controllers\api\ViewAction;

/**
 * Default controller for the `auth` module
 */
class AuthRegisterController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function behaviors() : array
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpBearerAuth::class,
            ],
        ];

        return $behaviors;
    }

    protected function verbs() : array
    {
        return [
            'auth-profile-info' => ['POST'],
        ];
    }

    public function actions() : array
    {
        return [
            'auth-profile-info' => AuthProfileInfoAction::class,
        ];
    }
}
