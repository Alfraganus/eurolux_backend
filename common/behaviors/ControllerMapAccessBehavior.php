<?php

namespace common\behaviors;

use Yii;
use yii\base\Action;
use yii\base\Controller;
use yii\base\ActionFilter;
use yii\web\NotFoundHttpException;

/**
 * Поведение контроля доступа к контроллеру.
 * Обеспечивает контроль за обращением к контроллерам модуля,
 * обязуя составлять карту допустимых контроллеров модуля.
 *
 * @package common\behaviors
 */
class ControllerMapAccessBehavior extends ActionFilter
{
    /**
     * @var Controller
     */
    public $owner;

    /**
     * @var bool Разрешение на доступ к контроллера из Application
     */
    public $applicationExclude = false;

    /**
     * Проверка доступа к контроллеру
     *
     * @param Action $action
     * @return bool
     * @throws NotFoundHttpException
     */
    public function beforeAction($action)
    {
        // Проверка разрешения на использования контроллера в Application приложения
        if ($this->applicationExclude && $this->owner->module->id == \Yii::$app->id) {
            return true;
        }

        // Проверка разрешения на доступ к контроллера из модуля только через карту
        if (! isset($this->owner->module->controllerMap[$action->controller->id])) {
            throw new NotFoundHttpException();
        }

        return true;
    }
}
