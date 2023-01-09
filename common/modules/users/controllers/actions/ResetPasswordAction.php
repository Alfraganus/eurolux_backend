<?php

namespace common\modules\users\controllers\actions;

use yii\base\Action;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\base\InvalidArgumentException;
use common\modules\users\services\UserService;
use common\modules\users\forms\ResetPasswordForm;

class ResetPasswordAction extends Action
{
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
     * Запуск действия выполнения смены пароля
     *
     * @param string $token
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
     */
    public function run($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $user = $model->getUser();
            if ($this->service->changePassword($user, $model)) {
                \Yii::$app->session->setFlash('success', 'Новый пароль успешно установлен.');
                return $this->controller->goHome();
            }
        }

        return $this->controller->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
