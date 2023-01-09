<?php

namespace common\modules\category\models\scopes;

use common\modules\category\models\Category;
use common\modules\category\models\SubCategory;
use common\solutions\models\scopes\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\modules\category\models\Category]].
 *
 * @see \common\modules\category\models\Category
 */
class CategoryQuery extends ActiveQuery
{
    /**
     * Выборка только активных записей
     * @return $this
     */
    public function active()
    {
        $categories = Category::find()->with([
            'categories' => function ($query) {
                $query->andWhere(['is_active' => SubCategory::STATUS_ACTIVE]);
            },
        ])->andWhere([
            $this->getPrimaryTableName() . '.[[is_active]]' => true]);

        return $categories;
    }
}