<?php

namespace common\solutions\models\decorators;

use yii\base\Model;

/**
 * Базовый декоратор, реализующий логику обращения к вложенной сущности.
 * Декоратор должен применяться в финальной стадии обработки объекта перед его выводом.
 *
 * @package common\solutions\models\decorators
 */
abstract class Decorator
{
    /**
     * @var Model
     */
    protected $entity;

    /**
     * Декорирование модели
     *
     * @param Model $model
     * @return Decorator
     */
    public static function decorate($model)
    {
        return new static($model);
    }

    /**
     * Конструктор сущности
     *
     * @param $model
     */
    public function __construct($model)
    {
        $this->entity = $model;
    }

    /**
     * Поиска декорирующей функции для свойства вложенной сущности
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        $methodName = 'get' . ucfirst($name);
        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        }
        return $this->entity->{$name};
    }

    /**
     * Перенаправления вызова метода на вложенную сущность
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->entity->$name($arguments);
    }
}
