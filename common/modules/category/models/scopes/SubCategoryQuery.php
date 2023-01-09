<?php

namespace common\modules\category\models\scopes;

use common\solutions\models\scopes\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\modules\category\models\SubCategory]].
 *
 * @see \common\modules\category\models\SubCategory
 */
class SubCategoryQuery extends ActiveQuery
{
    /**
     * Выборка только активных записей
     * @return $this
     */
    public function active()
    {
        return $this->innerJoinWith('category')
            ->andWhere([
                '{{%sub_category}}.is_active' => true
        ]);
    }
}