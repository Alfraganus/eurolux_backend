<?php

namespace common\solutions\models\search;

use yii\base\Model;
use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;

/**
 * Поисковая форма для WEB приложения.
 * Предоставляет интерфейс для быстрого построения поиска.
 *
 * @package common\solutions\models\search
 */
abstract class SearchForm extends Model
{
    /**
     * Осуществление поиска в базе данных запрошенных моделей и выдача провайдера данных
     *
     * @param array $params
     * @param string $formName
     * @return ActiveDataProvider
     */
    public function search($params, $formName = '')
    {
        // Получение данных для фильтров
        $this->load($params, $formName);

        // Провайдер и запрос
        $query = $this->buildQuery();
        $provider = $this->buildProvider($query);

        // Валидация полученных данных
        if (!$this->validate()) {
            return $provider;
        }

        // Применение фильтров к модели поиска
        $this->applyFilter($query);

        // Итоговый фильтр
        return $provider;
    }

    /**
     * Применение фильтров к условию выборки
     *
     * @param ActiveQuery $query
     */
    protected function applyFilter(ActiveQuery $query)
    {
        // Заглушка. Не всегда требуется поиск по условиям, порой достаточно простой выборки
    }

    /**
     * Сборка провайдера данных
     *
     * @param ActiveQuery $query
     * @return ActiveDataProvider
     */
    protected function buildProvider($query)
    {
        return new ActiveDataProvider([
            'pagination' => $this->buildPagination(),
            'sort' => $this->buildSort(),
            'query' => $query,
        ]);
    }

    /**
     * Сборка массива пагинации
     *
     * @return array|boolean
     */
    protected function buildPagination()
    {
        return [];
    }

    /**
     * Сборка массива данных для сортировки
     *
     * @return array
     */
    protected function buildSort()
    {
        // Сортировка по умолчанию подготавливается как пустой массив.
        // В комментарии указан пример заполнения массива сортировки.
        return [
            //'defaultOrder' => [
            //    'id' => SORT_ASC
            //],
            //'attributes' => ['id']
        ];
    }

    /**
     * Сборка класса условий выборки из базы данных
     *
     * @return ActiveQuery
     */
    abstract protected function buildQuery();
}
