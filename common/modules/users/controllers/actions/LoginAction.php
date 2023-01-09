<?php

namespace common\modules\users\controllers\actions;

use common\modules\users\forms\LoginForm;
use common\modules\users\services\UserService;
use yii\web\Controller;
use yii\base\Action;

class LoginAction extends Action
{
    /**
     * @var string Шаблон формы авторизации
     */
    public $layout;
    /**
     * @var float|int Время истечения токена
     */
    public $expire = 86400 * 30;
    /**
     * Время истечения токена если пользователь не хочет чтобы его запомнили.
     * Для множественных токенов установить минимальное время хранения токена и обновлять токен раз в минуту.
     *
     * @var int
     */
    public $expireNotRemember = 0;

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
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!empty($this->layout)) {
            $this->controller->layout = $this->layout;
        }
    }

    /**
     * Выполнение действия авторизации
     *
     * @return string|\yii\web\Response
     */
    public function run()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }

        $model = new LoginForm();
        $request = \Yii::$app->request;

        if ($model->load($request->post()) && $model->validate()) {
            $user = $model->getUser();
            if (!$model->rememberMe) {
                $this->expire = $this->expireNotRemember;
            }
            if ($this->service->login($user, $this->expire, $request)) {
                if (\Yii::$app->user->login($user, $this->expire)) {
                    return $this->controller->goHome();
                }
            }
        }

        $model->password = '';
        return $this->controller->render('login', [
            'model' => $model,
        ]);
    }
}
