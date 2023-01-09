<?php

namespace common\modules\users\controllers\actions;

use yii\base\Action;
use yii\base\Controller;
use common\modules\users\services\UserService;
use common\modules\users\forms\SignupForm;

/**
 * Действие регистрации нового пользователя
 */
class SignupAction extends Action
{
    /**
     * @var float|int Время истечения токена. Если 0 - автоавторизации не будет
     */
    public $expire = 0;

    /**
     * @var UserService
     */
    protected $service;

    /**
     * Конструктор с внедрением зависимости
     *
     * @param string $id
     * @param Controller $controller
     * @param UserService $service
     * @param array $config
     */
    public function __construct($id, Controller $controller, UserService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $controller, $config);
    }

    /**
     * Запуск действия регистрации
     *
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function run()
    {
        $model = new SignupForm();
        $request = \Yii::$app->request;

        if ($model->load($request->post()) && $model->validate()) {
            if ($user = $this->service->signup($model)) {
                if ($this->expire > 0 && $this->service->login($user, $this->expire, $request)) {
                    \Yii::$app->user->login($user, $this->expire);
                }
                return $this->controller->goHome();
            }
        }

        return $this->controller->render('signup', [
            'model' => $model,
        ]);
    }
}
