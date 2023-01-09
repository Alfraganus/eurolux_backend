<?php
namespace common\models;

use common\helpers\Password;
use common\models\scopes\UserQuery;
use common\modules\users\models\IdentityRecord;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Модель пользователя
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $last_active_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends IdentityRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * Модель запросов пользователя для поиска в базе данных
     *
     * @return UserQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::find()
            ->findById($id)
            ->one();
    }

    /**
     * Поиск пользователя по логину
     *
     * @param string $username
     * @return static|null|ActiveRecord
     */
    public static function findByUsername($username)
    {
        return static::find()
            ->findByUsername($username)
            ->one();
    }

    /**
     * Поиск по токену сброса пароля
     *
     * @param string $token
     * @return static|null|ActiveRecord
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::find()
            ->andWhere(['password_reset_token' => $token])
            ->one();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'last_active_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ]
            ]
        ]);
    }

    /**
     * Валидация пароля
     *
     * @param string $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Password::validate($password, $this->password_hash);
    }

    /**
     * Генерация хеша для нового пароля
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Password::hash($password);
    }

    /**
     * Валидность токена сброса пароля
     *
     * @param string $token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * Генерация валидного токена сброса пароля
     */
    public function generatePasswordResetToken()
    {
        try {
            $token = Yii::$app->security->generateRandomString();
        } catch (\Exception $e) {
            $token = md5(uniqid('password'));
        }
        $this->password_reset_token = $token . '_' . time();
    }

    /**
     * Очистка токена сброса пароля
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Роли
     *
     * @return array
     */
    public function getRoles()
    {
        return Yii::$app->authManager->getRolesByUser($this->id);
    }

    /**
     * Проверка доступа к роли
     *
     * @return boolean
     */
    public function hasRole($role)
    {
        return Yii::$app->authManager->checkAccess($this->id, $role);
    }

    /**
     * Устанавливает время последней активности пользователя на сайте
     */
    public function setLastActivity()
    {
        $this->updateAttributes([
            'last_active_at' => time()
        ]);
    }
}
