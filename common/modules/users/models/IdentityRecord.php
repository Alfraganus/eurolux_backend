<?php

namespace common\modules\users\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Модель идентификации пользователя
 *
 * @property string $auth_key
 */
abstract class IdentityRecord extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()->andWhere(['auth_key' => $token])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
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
            return !!$this->updateAttributes([
                'auth_key' => \Yii::$app->security->generateRandomString(),
            ]);
        } catch (\Exception $e) {}
        return false;
    }
}
