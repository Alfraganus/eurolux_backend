<?php

namespace common\modules\auth\actions;

use Yii;
use yii\web\Controller;
use yii\base\Action;
use common\modules\auth\services\AuthService;
use common\modules\users\models\Users;

/**
 *  @OA\Post(
 *     path="/auth/default/confirm-phone",
 *     tags={"Authentification"},
 *     operationId="confirm-phone",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *              required={"phone"},
 *                 @OA\Property(property="phone",type="string",description="Phone number of the user"),
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

class ConfirmPhoneAction extends Action
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
        $user = Users::findByPhone($request['phone']);
        if (!isset($request['phone'])) {
            return $responseMessage->respond('Fail', 'Phone has not been provided!', '', '', 400);
        }

        if ($request && $user) {
//            $smsCode = rand(11111, 99999);
            $smsCode = '0000';
            $authSession = $this->authService->createAuthSession($smsCode,['message'=>$user]);
            $result = $responseMessage->respond(
                'Success',
                'Provided phone exists on db',
                $authSession[AuthService::AUTH_SESSION_NAME]
            );
        } else {
            $result = $responseMessage->respond('Fail', 'Unfortunately phone was not found in our database!', '', '', 400);
        }

        return $result;
    }
}
