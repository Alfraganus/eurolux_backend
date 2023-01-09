<?php

namespace common\modules\users\controllers\actions;

use Yii;
use yii\base\Action;
use yii\web\Controller;
use common\modules\users\services\UserService;
use common\modules\users\forms\PasswordForm;

class PasswordAction extends Action
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
     * @return string|\yii\web\Response
     */
    public function run()
    {
        if (Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }

        $user = Yii::$app->user->getIdentity();

        $form = new PasswordForm($user);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $user->setPassword($form->password);
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Новый пароль успешно установлен.');
                Yii::$app->logger->save(
                    get_class($user), 
                    $user->id,
                    'password'
                );
                return $this->controller->redirect(['password']);
            }
        }

        return $this->controller->render('password', [
            'model' => $form,
        ]);
    }
}