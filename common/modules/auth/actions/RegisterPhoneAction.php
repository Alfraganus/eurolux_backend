<?php

namespace common\modules\auth\actions;

use common\models\User;
use common\modules\auth\services\AuthService;
use common\modules\users\behaviors\UserTokenBehavior;
use common\modules\users\forms\LoginForm;
use common\modules\users\models\Users;
use common\modules\users\models\UserToken;
use DeepCopyTest\Matcher\Y;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\base\Action;
use common\modules\users\services\UserService;

/**
 *  @OA\Post(
 *     path="/auth/default/register-phone",
 *     tags={"Authentification"},
 *     operationId="register-phone",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *              required={"phone"},
 *                 @OA\Property(property="phone",type="string",description="SMS that user recieves"),
 *             )
 *          )
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="OK",
 *          @OA\JsonContent(
 *             @OA\Schema(type="boolean")
 *          )
 *     ),
 *     @OA\Response(
 *          response=400,
 *          description="Неправильный запрос"
 *     )
 * )
 */

class RegisterPhoneAction extends Action
{
    private $authService;

    public function __construct($id,Controller $controller, AuthService $service,  $config = [])
    {
        $this->authService = $service;
        parent::__construct($id, $controller, $config);
    }


    public function run()
    {
        $request = Yii::$app->request->post();
        $responseMessage = Yii::$app->apiResponse;
        if (empty($request['phone'])) {
            return $responseMessage->respond('Fail', 'Phone has not been provided!', '', '', 400);
        }

        if ($request) {
//            $smsCode     =  rand(11111, 99999);
            $smsCode       =  '0000';
            $user        =  $this->authService->registerUserFirstTime($request['phone']);
            $authSession =  $this->authService->createAuthSession($smsCode,$user);
            if(!$user['result']) {
                return $responseMessage->respond('fail',$user['message'],'', '',400);
            }
            $data = [
                'token'         => Yii::createObject(UserToken::class)->upsertToken($user['message']['id'], 86400),
                'sms-validation'=> $authSession[AuthService::AUTH_SESSION_NAME]
            ];

            $result = $responseMessage->respond(
                'Success',
                'The user has successfully been registered!',
                $data
            );
        } else {
            $result = $responseMessage->respond('Fail', 'Unfortunately phone was not found in our database!', '', '', 400);
        }

        return $result;
    }
}
