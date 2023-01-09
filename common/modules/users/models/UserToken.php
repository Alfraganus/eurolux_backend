<?php

namespace common\modules\users\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\modules\users\models\scopes\UserTokenQuery;
use common\models\User;
use yii\web\IdentityInterface;

/**
 * Ключи авторизации пользователя
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $auth_key
 * @property string $ip_address
 * @property string $user_agent
 * @property integer $expired_at
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class UserToken extends IdentityRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_token}}';
    }

    /**
     * Создание нового токена
     *
     * @param integer $expire
     * @param string $userAgent
     * @param string $ipAddress
     * @return static
     * @throws \yii\base\Exception
     */
    public function upsertToken($user_id, $expire, $userAgent = '', $ipAddress = '')
    {
        $model = new static();
        $userExists = static::find()->findByUserId($user_id)->one();
        if (!empty($userExists)) {
            $model =  $userExists;
        }
        $model->ip_address = $ipAddress;
        $model->user_agent = $userAgent;
        $model->updateExpire($expire);
        $model->updateToken();
        $model->user_id = $user_id;
        $model->save(false);

        return $model['auth_key'];
    }

    /**
     * Модель поиска токенов в базе
     *
     * @return UserTokenQuery
     */
    public static function find()
    {
        return new UserTokenQuery(get_called_class());
    }

    /**
     * Поиск идентификации по токену
     *
     * @param string $token
     * @return ActiveQuery
     */
    public static function findByToken($token)
    {
        return static::find()->findByToken($token);
    }


    public static function findByUserId($user_id)
    {
        return static::find()->findByUserId($user_id);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_key','user_id'], 'required'],
            [['user_id', 'expired_at'], 'number'],
            [['user_agent'], 'string', 'max' => 255],
            [['ip_address'], 'string', 'max' => 16],
            [['auth_key'], 'string', 'max' => 64],
        ];
    }

    /**
     * Проверка на истечение времени
     *
     * @return true|false
     */
    public function isExpired()
    {
        return $this->expired_at <= time();
    }

    /**
     * Получить владельца токена
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Обновление времени истечении токена
     *
     * @param integer $expire
     */
    public function updateExpire($expire)
    {
        $this->expired_at = time() + $expire;
    }

    /**
     * Обновление токена
     *
     * @param int $length
     * @throws \yii\base\Exception
     */
    public function updateToken($length = 32)
    {
        $this->auth_key = \Yii::$app->security->generateRandomString($length);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['user_id'=>$id]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }
}
