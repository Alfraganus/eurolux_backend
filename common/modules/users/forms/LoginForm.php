<?php
namespace common\modules\users\forms;

use chulakov\model\validators\ClearMultibyteValidator;
use common\models\enums\UserStatus;
use yii\base\Model;
use common\models\User;

/**
 * Форма авторизации
 */
class LoginForm extends Model
{
    /**
     * @var string Имя пользователя
     */
    public $username;
    /**
     * @var string Пароль
     */
    public $password;
    /**
     * @var bool Запомнить пользователя
     */
    public $rememberMe = true;

    /**
     * @var User
     */
    protected $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], ClearMultibyteValidator::class],
            [['username', 'password'], 'required'],
            ['username', 'validateUser'],
            [['rememberMe'], 'filter', 'filter' => function($value) {
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }],
            [['rememberMe'], 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => true],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @param $attribute
     * @param array $params
     */
    public function validateUser($attribute, $params = [])
    {
        $user = $this->getUser();
        if ($user && $user->status === UserStatus::STATUS_BLOCKED) {
            $this->addError($attribute, 'Аккаунт заблокирован');
        }
    }

    /**
     * Валидация пароля
     *
     * @param string $attribute
     * @param array $params
     */
    public function validatePassword($attribute, $params = [])
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->{$attribute})) {
                $this->addError($attribute, 'Неверное Имя пользователя или Пароль.');
            }
        }
    }

    /**
     * Поиск пользователя
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
