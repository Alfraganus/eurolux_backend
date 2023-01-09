<?php

namespace common\modules\users\forms;

use yii\base\Model;
use yii\base\InvalidArgumentException;
use common\helpers\Password;
use common\models\User;

/**
 * Форма изменения пароля
 */
class PasswordForm extends Model
{
    /**
     * @var string
     */
    public $old;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $confirm;

    /**
     * @var User
     */
    protected $model;

    /**
     * Конструктор формы смены пароля
     *
     * @param User $config
     * @param array $config
     */
    public function __construct(User $model, $config = [])
    {
        $this->model = $model;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old', 'password', 'confirm'], 'required'],
            ['old', 'validateOldPassword'],
            [['password'], 'string', 'min' => Password::DEFAULT_STRENGTH],
            ['password', 'validatePassword'],
            ['confirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Введенные пароли не совпадают'],
        ];
    }

    /**
     * Проверка старого пароля
     * 
     * @param string $attribute 
     * @param mixed $params 
     */
    public function validateOldPassword($attribute, $params)
    {
        if (! $this->model->validatePassword($this->{$attribute})) {
            $this->addError($attribute, 'Старый пароль задан неверно.');
        }
    }

    /**
     * Проверка нового пароля
     * 
     * @param string $attribute 
     * @param mixed $params 
     */
    public function validatePassword($attribute, $params)
    {
        if ($this->model->validatePassword($this->{$attribute})) {
            $this->addError($attribute, 'Новый пароль совпадает с текущим.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'old' => 'Старый пароль',
            'password' => 'Новый пароль',
            'confirm' => 'Повторите пароль',
        ];
    }
}
