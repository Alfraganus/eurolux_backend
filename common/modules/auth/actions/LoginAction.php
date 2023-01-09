<?php

namespace common\modules\auth\actions;

use common\models\User;
use common\modules\users\behaviors\UserTokenBehavior;
use common\modules\users\forms\LoginForm;
use common\modules\users\models\UserToken;
use DeepCopyTest\Matcher\Y;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\base\Action;
use common\modules\users\services\UserService;

class LoginAction extends Action
{
    public function run()
    {
        $request = Yii::$app->request->post();
        $model = new LoginForm();
        $responseMessage = Yii::$app->apiResponse;

        if (empty($request['username']) || empty($request['password'])) {
            return $responseMessage->respond('Fail', 'Username or password has not been provided!', '', '', 401);
        }

        if ($request && $model->validate()) {
            $result = $responseMessage->respond(
                'Success',
                'User has been successfully signed in!',
                Yii::createObject(UserToken::class)
                ->upsertToken(User::findByUsername($request['username'])['id'], 86400)
            );
        } else {
            $result = $responseMessage->respond('Fail', 'Username or password is incorrect!', '', '', 401);
        }
        return $result;

    }
}
