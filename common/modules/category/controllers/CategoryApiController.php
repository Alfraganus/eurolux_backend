<?php

namespace common\modules\category\controllers;

use common\modules\category\controllers\api\IndexAction;
use common\modules\category\controllers\api\SubCategoryAction;
use yii\base\Action;
use yii\filters\AccessRule;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class CategoryApiController extends Controller
{

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
            // Other behaviors...
        ];
    }
    /**
     * Фильтрация перед вызовом действия
     *
     * @param Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function beforeAction($action)
    {
        if (!isset($this->module->controllerMap[$action->controller->id])) {
            throw new NotFoundHttpException();
        }
        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => IndexAction::class,
            'sub' => SubCategoryAction::class,
        ];
    }


    /**
     * @inheritdoc
     */
    protected function authenticatorBehavior()
    {
        return false;
    }
}
