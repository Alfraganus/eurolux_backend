<?php

namespace common\modules\category\models\repositories;

use common\modules\category\models\SubCategory;
use common\solutions\exceptions\NotFoundModelException;
use common\solutions\models\repositories\CrudRepository;

class SubCategoryRepository extends CrudRepository
{
    /**
     * Получение модели по ID
     *
     * @param int $id
     * @return \yii\db\ActiveRecord | SubCategory
     * @throws NotFoundModelException
     */
    public function get($id)
    {
        if ($model = SubCategory::find()->findById($id)->one()) {
            return $model;
        }

        throw new NotFoundModelException('Запрашиваемая категория не найдена или была удалена ранее!');
    }

    /**
     * Создание и заполнение модели обязательными полями
     *
     * @return SubCategory
     */
    public function create()
    {
        return new SubCategory();
    }
}
