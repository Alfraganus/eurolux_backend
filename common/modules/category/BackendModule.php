<?php

namespace common\modules\category;

use common\modules\category\controllers\CategoryController;
use common\modules\category\controllers\SubCategoryController;

/**
 * user module definition class
 */
class BackendModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\category\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->controllerMap = [
            'category' => CategoryController::class,
            'sub-category' => SubCategoryController::class,
        ];
    }
}
