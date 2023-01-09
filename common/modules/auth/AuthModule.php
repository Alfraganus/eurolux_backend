<?php

namespace common\modules\auth;

use common\modules\auth\controllers\ApiController;

/**
 * auth module definition class
 */
class AuthModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\auth\controllers';

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
