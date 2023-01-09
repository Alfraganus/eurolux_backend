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
 *     path="/auth/default/verify-sms",
 *     tags={"Authentification"},
 *     operationId="verify-sms",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *              required={"sms"},
 *                 @OA\Property(property="sms",type="string",description="SMS that user recieves"),
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

class VerifySmsAction extends Action
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

        if (empty($request['sms'])) {
            return $responseMessage->respond('Fail', 'sms has not been provided!', '', '', 400);
        }
        $authValidation = $this->authService->validateSmsCode($request['sms']);

        if ($request && $authValidation['validate']) {
            $result = $responseMessage->respond(
                'Success',
                [
                    'message'       => $authValidation['message'],
                    'UserHasInfo'   => $this->authService->personalInfoExists(),
                    'token'         => Yii::createObject(UserToken::class)
                                      ->upsertToken($this->authService->userSession['user']['message']['id'], 86400)
                ]
            );
        } else {
            $result = $responseMessage->respond('Fail', $authValidation['message'], '', '', 400);
        }
        return $result;
    }
}
