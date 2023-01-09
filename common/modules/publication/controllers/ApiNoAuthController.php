<?php

namespace common\modules\publication\controllers;

use common\modules\publication\actions\GetAllPublicationAction;
use common\modules\publication\actions\GetAllPublicationByCategoryAction;
use common\modules\publication\actions\GetAllPublicationByUserIdAction;
use common\modules\publication\actions\GetAllPublicationNoAuthAction;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use common\modules\publication\actions\CreateAction;
use common\modules\publication\actions\TestAction;


/**
 * Default controller for the `auth` module
 */
class ApiNoAuthController extends Controller
{

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
            'get-publications-by-category-id'   => GetAllPublicationByCategoryAction::class,
            'get-publication-no-auth'           => GetAllPublicationNoAuthAction::class,
            'get-publications-by-userid'        => GetAllPublicationByUserIdAction::class,
        ];
    }

}
