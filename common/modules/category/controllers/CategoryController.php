<?php

namespace common\modules\category\controllers;

use common\behaviors\ControllerMapAccessBehavior;
use common\modules\category\forms\CategoryForm;
use common\modules\category\models\Category;
use common\modules\category\models\search\CategorySearch;
use common\modules\category\services\CategoryService;
use common\modules\control\actions\create\CreateAjaxAction;
use common\modules\control\actions\DeleteAction;
use common\modules\control\actions\IndexAction;
use common\modules\control\actions\ToggleActivityAction;
use common\modules\control\actions\update\UpdateAjaxAction;
use common\solutions\rest\AccessRule;
use common\solutions\web\Controller;
use Yii;

class CategoryController extends Controller
{
    /**
     * @return bool|string
     */
    public function getViewPath()
    {
        return Yii::getAlias('@common/modules/category/views/category');
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
            'index' => [
                'class' => IndexAction::class,
                'searchModelClass' => CategorySearch::class,
            ],
            'update' => [
                'class' => UpdateAjaxAction::class,
                'service' => CategoryService::class,
                'formClass' => CategoryForm::class,
            ],
            'create' => [
                'class' => CreateAjaxAction::class,
                'service' => CategoryService::class,
                'formClass' => CategoryForm::class,
            ],
            'active' => [
                'class' => ToggleActivityAction::class,
                'modelClass' => Category::class
            ],
            'delete' => [
                'class' => DeleteAction::class,
                'service' => CategoryService::class,
                'modelClass' => Category::class
            ],
        ];
    }
}