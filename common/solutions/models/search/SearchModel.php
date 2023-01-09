<?php

namespace solutions\models\search;

use solutions\rest\Pagination;

/**
 * Поисковая модель для REST приложения с дополнительным указанием REST пагинатора.
 *
 * @package solutions\models\search
 */
abstract class SearchModel extends SearchForm
{
    /**
     * @var int
     */
    public $offset = 0;
    /**
     * @var int
     */
    public $total = 10;

    /**
     * Сборка массива пагинации
     *
     * @return array|boolean
     */
    protected function buildPagination()
    {
        return [
            'class' => Pagination::class,
            'offset' => $this->offset,
            'pageSize' => $this->total,
        ];
    }
}
