<?php

namespace common\modules\auth\controllers;

use common\modules\auth\actions\RegisterPhoneAction;
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
class ApiController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    protected function verbs() : array
    {
        return [
            'register-phone' => ['POST'],
            'verify-sms' => ['POST'],
            'confirm-phone' => ['POST'],
        ];
    }

    public function actions() : array
    {
        return [
            'register-phone' => RegisterPhoneAction::class,
            'confirm-phone' => ConfirmPhoneAction::class,
            'verify-sms' => VerifySmsAction::class,
        ];
    }

}
