<?php

namespace common\modules\users\behaviors;

use yii\web\User;
use yii\web\UserEvent;
use yii\base\Behavior;
use common\modules\users\models\UserToken;

/**
 * Поведение автоматизации обработки токенов пользователя
 */
class UserTokenBehavior extends Behavior
{
    /**
     * @var \common\models\User
     */
    public $owner;
    /**
     * @var UserToken
     */
    protected $assignToken;

    /**
     * Навешивается событие на выход из системы
     *
     * @inheritdoc
     */
    public function attach($owner)
    {
        parent::attach($owner);
        if ($user = \Yii::$app->get('user', false)) {
            $user->on(User::EVENT_BEFORE_LOGOUT, [$this, 'beforeLogout']);
        }
    }

    /**
     * Установка текущего токена
     *
     * @param UserToken $token
     */
    public function assignAccessToken(UserToken $token)
    {
        if ($token->isNewRecord) {
            $this->owner->link('tokens', $token);
        }
        $this->assignToken = $token;
    }

    /**
     * Текущий токен авторизации пользователя
     *
     * @return UserToken|null
     */
    public function getAccessToken()
    {
        if ($this->assignToken) {
            return $this->assignToken;
        }
        return null;
    }

    /**
     * Создание нового токена
     *
     * @param integer $expire
     * @param string $userAgent
     * @param string $ipAddress
     * @return UserToken
     * @throws \yii\base\Exception
     */
    public function createAccessToken($expire, $userAgent = '', $ipAddress = '')
    {
        $this->assignAccessToken(UserToken::create(
            $expire, $userAgent, $ipAddress
        ));
        return $this->assignToken;
    }

    /**
     * Удаление токена
     *
     * @return bool
     */
    public function resetAccessToken()
    {
        if ($this->assignToken) {
            try {
                return $this->assignToken->delete();
            }
            catch (\Exception $e) {}
            catch (\Throwable $e) {}
        }
        return false;
    }

    /**
     * Событие на выход из системы
     * При выходе удаляет текущий токен
     *
     * @param UserEvent $event
     * @return bool
     */
    public function beforeLogout(UserEvent $event)
    {
        if ($this->owner === $event->identity) {
            return $this->resetAccessToken();
        }
        return false;
    }
}
