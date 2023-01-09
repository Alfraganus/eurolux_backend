<?php

namespace common\modules\users\controllers\actions;

use yii\base\Action;
use yii\web\Controller;
use common\modules\users\services\UserService;
use common\modules\users\forms\PasswordResetRequestForm;
use common\modules\users\mail\ResetPasswordMessage;

class RequestResetPasswordAction extends Action
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
     * Выполнение действия
     *
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $user = $model->getUser();
            if ($this->service->resetPassword($user)) {
                ResetPasswordMessage::create()->send($user->email, [
                    'user' => $user,
                ]);
                \Yii::$app->session->setFlash('success', 'Письма с информацией для восстановленя пароля отправлено Вам на почту.');
                return $this->controller->goHome();
            } else {
                \Yii::$app->session->setFlash('error', 'Не удалось выслать письмо с информацией для восстановления пароля.');
            }
        }

        return $this->controller->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }
}
