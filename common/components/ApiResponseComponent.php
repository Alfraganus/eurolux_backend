<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class ApiResponseComponent extends Component
{
    public function respond($status = 0, $message = null, $data = null, $errors = null, $responseStatusCode = null)
    {
        if (is_null($message)) {
            $message = 'An error occurred while processing your request.';
        } elseif ($message === true) {
            $message = 'Success';
        } elseif ($message === false) {
            $message = 'Results not found.';
        }

        if (is_numeric($responseStatusCode)) {
            Yii::$app->response->statusCode = $responseStatusCode;
        }

        $response = [
            'status' => $status,
            'message' => $message,
        ];

        if ($data) $response['data'] = $data;
        if ($errors) $response['errors'] = $errors;

        return $response;
    }

}