<?php

namespace common\modules\users\forms;

use yii\base\Model;
use yii\base\InvalidArgumentException;
use common\helpers\Password;
use common\models\User;

/**
 * Форма сброса пароля
 */
class ResetPasswordForm extends Model
{
    /**
     * @var string Новый пароль
     */
    public $password;
    /**
     * @var string Подтверждение нового пароля
     */
    public $confirm;

    /**
     * @var string Токен запроса на смену пароля
     */
    protected $token;
    /**
     * @var User
     */
    protected $_user;

    /**
     * Конструктор формы смены пароля
     *
     * @param string $token
     * @param array $config
     */
    public function __construct($token, $config = [])
    {
        $this->token = $token;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'confirm'], 'required'],
            [['password'], 'string', 'min' => Password::DEFAULT_STRENGTH],
            [['password'], 'compare', 'compareAttribute' => 'confirm'],
        ];
    }

    /**
     * Получение пользователя
     *
     * @return User
     */
    public function getUser()
    {
        return $this->_user;
    }
}
