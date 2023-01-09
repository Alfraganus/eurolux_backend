<?php

namespace common\modules\users\controllers\actions;

use yii\base\Action;

/**
 * Действие выхода из системы
 */
class LogoutAction extends Action
{
    /**
     * Выполнение действия
     *
     * @return \yii\web\Response
     */
    public function run()
    {
        \Yii::$app->user->logout();
        return $this->controller->goHome();
    }
}
