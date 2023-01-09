<?php

namespace common\modules\users;

use common\modules\users\controllers\DefaultController;

/**
 * user module definition class
 */
class BackendModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\users\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->controllerMap = [
            'default' => DefaultController::class,
        ];
    }
}
