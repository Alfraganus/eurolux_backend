<?php

namespace common\modules\users;

use common\modules\users\controllers\ApiController;
use yii\base\Module;

/**
 * Модуль апи
 *
 * @package common\modules\users
 */
class ApiModule extends Module
{
    /**
     * Инициализация доступных контроллеров
     */
    public function init()
    {

        parent::init();
        $this->controllerMap = [
            'default' => ApiController::class,
        ];
    }
}
