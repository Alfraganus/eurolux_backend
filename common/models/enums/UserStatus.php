<?php

namespace common\models\enums;

/**
 * Перечисление статусов Пользователя
 */
class UserStatus
{
    /**
     * Статус - Заблокирован
     */
    const STATUS_BLOCKED = 0;
    /**
     * Статус - Активен
     */
    const STATUS_ACTIVE = 10;

    /**
     * @var array Расшифровка статусов
     */
    public static $labels = [
        self::STATUS_BLOCKED => 'Заблокирован',
        self::STATUS_ACTIVE => 'Активен',
    ];

    /**
     * @var string Дефолтное именование расшифроки статуса
     */
    public static $defaultLabel = 'Неизвестно';

    /**
     * Получение расшифровки статуса
     *
     * @param string $status
     * @return string
     */
    public static function getLabel($status)
    {
        return isset(self::$labels[$status])
            ? self::$labels[$status]
            : self::$defaultLabel;
    }

    /**
     * Разрешенные статусы для быстрой валидации
     *
     * @return array
     */
    public static function getRange()
    {
        return array_keys(static::$labels);
    }
}
