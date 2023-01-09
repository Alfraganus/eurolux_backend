<?php

namespace common\modules\publication\controllers;

use common\modules\publication\actions\GetAllPublicationAction;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use common\modules\publication\actions\CreateAction;
use common\modules\publication\actions\TestAction;


/**
 * Default controller for the `auth` module
 */
class ApiController extends Controller
{

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
    
    /**
     * Renders the index view for the module
     * @return string
     */
    protected function verbs() : array
    {
        return [
            'create' => ['POST'],
        ];
    }

    public function actions()
    {
        return [
            'create' => CreateAction::class,
            'get-publications'=>GetAllPublicationAction::class,
        ];
    }

}
