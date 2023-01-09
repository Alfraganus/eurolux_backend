<?php

namespace common\solutions\validators;

use yii\validators\RegularExpressionValidator;

/**
 * Валидатор URL метки
 *
 * @package common\solutions\validators
 */
class SlugValidator extends RegularExpressionValidator
{
    /**
     * @var string Паттерн валидации url метки
     */
    public $pattern = '/^[0-9-_a-z]+$/i';
}
