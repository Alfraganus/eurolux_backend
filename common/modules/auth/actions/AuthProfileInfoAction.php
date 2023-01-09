<?php

namespace common\modules\auth\actions;

use Yii;
use common\modules\auth\services\AuthService;
use yii\web\Controller;
use yii\base\Action;

/**
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   in="header",
 *   name="Authorization",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT",
 * ),
 *  @OA\Post(
 *     path="/auth/auth-register/auth-profile-info",
 *     tags={"Authentification"},
 *     operationId="auth-profile-info",
 *   security={
 *     {"bearerAuth": {}}
 *   },
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 @OA\Property(property="city_id",type="string",description="city_id"),
 *                 @OA\Property(property="name",type="string",description="name"),
 *                 @OA\Property(property="email",type="string",description="email"),
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

class AuthProfileInfoAction extends Action
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
        $user_id = Yii::$app->user->id;
        $requestedData = [
            'city_id'      =>   $request['city_id']         ?? null,
            'name'         =>   $request['name']            ?? null,
            'email'        =>   $request['email']           ?? null,
            'latitude'     =>   $request['latitude']        ?? null,
            'longitude'    =>   $request['longitude']       ?? null,
            'search_radius'=>   $request['search_radius']   ?? null,
        ];
        $errors = [];
        foreach ($requestedData as $key => $value) {
            if(empty($value)) $errors[] =[
                "$key is not provided"
            ];
        }
        if ($errors)  return $responseMessage->respond('Fail',  $errors, '', '', 400);

        if ($request) {
           $updateInfo = $this->authService->updateUsersTable($user_id,$requestedData);
           if(!$updateInfo['result']) {
               return $responseMessage->respond('fail', '',  '',$updateInfo['errors'],400 );
           }
            $result = $responseMessage->respond(
                'Success',
                'Users personal info has been updated',
                $updateInfo
            );
        } else {
            $result = $responseMessage->respond('Fail',  'Error occured, please try again later', '', '', 400);
        }

        return $result;
    }
}
