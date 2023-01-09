<?php

namespace common\modules\publication;

use common\modules\publication\controllers\ApiController;

/**
 * auth module definition class
 */
class ApiModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\publication\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->controllerMap = [
            'default' => ApiController::class,
        ];
    }
}
