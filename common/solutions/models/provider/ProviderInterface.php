<?php

namespace common\solutions\models\provider;

use yii\base\Model;
use yii\db\ActiveQuery;

interface ProviderInterface
{
    /**
     * Получение форматированного массива данных об одном объекте
     *
     * @param integer $id
     * @return array
     */
    public static function get($id);

    /**
     * Выборка списка моделей и вывод массива информации о каждом в списке
     *
     * @param ActiveQuery $query
     * @return array
     */
    public static function getAll(ActiveQuery $query);

    /**
     * Форматирование и вывод массива информации об объекте(ах)
     *
     * @param Model|Model[] $model
     * @return array
     */
    public static function format($model);
}
