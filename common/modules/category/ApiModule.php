<?php

namespace common\modules\category;

use common\modules\category\controllers\CategoryApiController;
use yii\base\Module;

/**
 * Модуль апи
 *
 * @package common\modules\category
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
            'category' => CategoryApiController::class,
        ];
    }
}
