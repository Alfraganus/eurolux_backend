<?php

namespace common\modules\users\forms;

use chulakov\model\validators\ClearMultibyteValidator;
use yii\base\Model;
use common\helpers\Password;

/**
 * Форма регистрации
 */
class SignupForm extends Model
{
    /**
     * @var string Имя пользователя
     */
    public $username;
    /**
     * @var string E-mail адрес
     */
    public $email;
    /**
     * @var string Пароль
     */
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], ClearMultibyteValidator::class],
            [['username', 'email', 'password'], 'required'],

            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким именем уже зарегестрирован.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким e-mail адресом уже зарегестрирован.'],

            ['password', 'string', 'min' => Password::DEFAULT_STRENGTH],
        ];
    }
}
