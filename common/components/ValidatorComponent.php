<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class ValidatorComponent extends Component
{
    public function checkObligatoryData($requestedData) : array
    {
        $errors = [];
        foreach ($requestedData as $key => $value) {
            if(empty($value)) $errors[] =[
                "$key is not provided"
            ];
        }
        return $errors;
    }

}