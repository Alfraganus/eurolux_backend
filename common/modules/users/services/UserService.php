<?php

namespace common\modules\users\services;

use common\models\User;
use common\modules\users\forms\ResetPasswordForm;
use common\modules\users\forms\SignupForm;
use common\modules\users\models\Users;
use yii\web\Request;

/**
 * Сервис обработки Пользователя
 */
class UserService
{
    /**
     * Регистрация нового пользователя
     *
     * @param SignupForm $form
     * @return User|null
     * @throws \yii\base\Exception
     */
    public function signup(SignupForm $form)
    {
        $user = new User();
        $user->username = $form->username;
        $user->email = $form->email;
        $user->setPassword($form->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }

    /**
     * Запрос на смену пароля
     *
     * @param User $user
     * @return bool
     */
    public function resetPassword(User $user)
    {
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Генерация токенов авторизации
     *
     * @param User $user
     * @param int $expire
     * @param Request|null $request
     * @return bool
     */
    public function login(User $user, $expire = 0, $request = null)
    {
        return $user->generateAuthKey(
            $expire, $request->getUserAgent(), $request->getUserIP()
        );
    }

    /**
     * Смена пароля для пользователя
     *
     * @param User $user
     * @param ResetPasswordForm|PasswordForm $form
     * @return bool
     * @throws \yii\base\Exception
     */
    public function changePassword(User $user, $form)
    {
        $user->setPassword($form->password);
        $user->removePasswordResetToken();
        return $user->save();
    }

    public static function getUserId()
    {
        return \Yii::$app->user->id;
    }

    public static function getUserInfo()
    {
        return Users::findOne(self::getUserId());
    }
}
