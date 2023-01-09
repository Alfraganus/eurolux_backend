<?php

namespace common\modules\category\models\repositories;

use common\modules\category\models\Category;
use common\solutions\exceptions\NotFoundModelException;
use common\solutions\models\repositories\CrudRepository;

class CategoryRepository extends CrudRepository
{
    /**
     * Получение модели по ID
     *
     * @param int $id
     * @return \yii\db\ActiveRecord | Category
     * @throws NotFoundModelException
     */
    public function get($id)
    {
        if ($model = Category::find()->findById($id)->one()) {
            return $model;
        }

        throw new NotFoundModelException('Запрашиваемая категория не найдена или была удалена ранее!');
    }

    /**
     * Создание и заполнение модели обязательными полями
     *
     * @return Category
     */
    public function create()
    {
        return new Category();
    }
}
