<?php

namespace common\solutions\rest;

/**
 * Пагинатор с возможностью указывать смещение выборки
 *
 * @package api\classes
 */
class Pagination extends \yii\data\Pagination
{
    /**
     * @var integer
     */
    public $offset;

    /**
     * @inheritdoc
     */
    public function getOffset()
    {
        if (empty($this->offset)) {
            return parent::getOffset();
        }
        return $this->offset;
    }
}
