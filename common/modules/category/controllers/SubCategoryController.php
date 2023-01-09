<?php

namespace common\modules\category\controllers;

use common\behaviors\ControllerMapAccessBehavior;
use common\modules\category\controllers\subcategory\CreateAction;
use common\modules\category\controllers\subcategory\IndexAction;
use common\modules\category\controllers\subcategory\UpdateAction;
use common\modules\category\models\SubCategory;
use common\modules\category\services\SubCategoryService;
use common\modules\control\actions\DeleteAction;
use common\modules\control\actions\ToggleActivityAction;
use common\solutions\rest\AccessRule;
use common\solutions\web\Controller;
use Yii;

class SubCategoryController extends Controller
{
    /**
     * @return bool|string
     */
    public function getViewPath()
    {
        return Yii::getAlias('@common/modules/category/views/subcategory');
    }

    /**
     * Список правил доступа к экшенам контроллера.
     *
     * @return AccessRule[]
     */
    public function accessRules()
    {
        return [
            'index' => $this->createAccess('get, post', true, '@'),
            'create' => $this->createAccess('get, post', true, '@'),
            'update' => $this->createAccess('get, post, put, patch', true, '@'),
            'delete' => $this->createAccess('post', true, '@'),
            'active' => $this->createAccess('post', true, '@'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviours = parent::behaviors();
        $behaviours['controllerMap'] = [
            'class' => ControllerMapAccessBehavior::class
        ];

        return $behaviours;
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        if ($action->id == 'index') {
            Yii::$app->user->setReturnUrl(Yii::$app->request->url);
        }

        return parent::afterAction($action, $result);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => IndexAction::class,
            'create' => CreateAction::class,
            'update' => UpdateAction::class,
            'active' => [
                'class' => ToggleActivityAction::class,
                'modelClass' => SubCategory::class
            ],
            'delete' => [
                'class' => DeleteAction::class,
                'service' => SubCategoryService::class,
                'modelClass' => SubCategory::class
            ],
        ];
    }
}