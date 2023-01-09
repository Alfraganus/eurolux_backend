<?php

namespace common\modules\users\mail;

use chulakov\base\mail\BaseMessage;
//use chulakov\components\mail\BaseMessage;

class ResetPasswordMessage extends BaseMessage
{
    /**
     * @var string Путь до html шаблона
     */
    protected $html = '@common/modules/user/mail/html/passwordResetToken';
    /**
     * @var string Путь до текстовой версии шаблона
     */
    protected $text = '@common/modules/user/mail/text/passwordResetToken';
    /**
     * @var string Тема сообщения
     */
    protected $subject = 'Информация для смена пароля';

    /**
     * Отправка сообщения
     *
     * @param string|array $email
     * @param array $params
     * @return boolean
     */
    public function send($email, $params = [])
    {
        return $this->compose($email, $params)->send();
    }
}
