<?php

namespace common\modules\users\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\modules\users\behaviors\UserTokenBehavior;

/**
 * Модель идентификации пользователя
 *
 * @property UserToken[] $tokens
 *
 * @method UserToken getAccessToken() see [[UserTokenBehavior::getAuthToken()]]
 * @method void assignAccessToken(UserToken $token) see [[UserTokenBehavior::assignAccessToken()]]
 * @method boolean resetAccessToken() see [[UserTokenBehavior::resetAccessToken()]]
 * @method UserToken createAccessToken(integer $expire, string $agent, string $ipAddress) see [[UserTokenBehavior::createAccessToken()]]
 */
abstract class IdentityTokensRecord extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /** @var UserToken $token */
        if ($token = UserToken::findByToken($token)->with('user')->one()) {
            if (!$token->isExpired()) {
                /** @var static $user */
                if ($user = $token->user) {
                    $user->assignAccessToken($token);
                    return $user;
                }
            }
            try {
                $token->delete();
            }
            catch (\Exception $e) {}
            catch (\Throwable $e) {}
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->getAccessToken()->token;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        if ($tokens = $this->tokens) {
            foreach ($tokens as $token) {
                if ($token->isExpired()) {
                    try {
                        $token->delete();
                    }
                    catch (\Exception $e) {}
                    catch (\Throwable $e) {}
                    continue;
                }
                if ($token->token === $authKey) {
                    $this->assignAccessToken($token);
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Генерация ключа авторизации
     *
     * @param integer $expire
     * @param string $userAgent
     * @param string $ipAddress
     * @return boolean
     */
    public function generateAuthKey($expire = 0, $userAgent = '', $ipAddress = '')
    {
        try {
            return !!$this->createAccessToken($expire, $userAgent, $ipAddress);
        } catch (\Exception $e) {}
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            UserTokenBehavior::class,
        ];
    }

    /**
     * Связь для получения токенов пользователя
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTokens()
    {
        return $this->hasMany(UserToken::class, ['user_id' => 'id'])
            ->inverseOf('user');
    }
}
