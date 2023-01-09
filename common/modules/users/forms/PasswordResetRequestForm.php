<?php

namespace common\modules\users\forms;

use chulakov\model\validators\ClearMultibyteValidator;
use Yii;
use yii\base\Model;
use common\models\User;
use common\models\enums\UserStatus;

/**
 * Форма запроса на смену пароля
 */
class PasswordResetRequestForm extends Model
{
    /**
     * @var string E-mail адрес пользователя
     */
    public $email;

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
            ['email', ClearMultibyteValidator::class],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => UserStatus::STATUS_ACTIVE],
                'message' => 'Пользователь с данным e-mail не найден.'
            ],
        ];
    }

    /**
     * Получение пользователя
     *
     * @return User
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::find()
                ->findByStatus(UserStatus::STATUS_ACTIVE)
                ->andWhere(['email' => $this->email])
                ->one();
        }
        return $this->_user;
    }
}
