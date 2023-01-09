<?php

namespace common\modules\category\models\providers;

use common\modules\category\models\SubCategory;
use yii\helpers\ArrayHelper;

class SubCategoryProvider
{
    /**
     * @param SubCategory[] $models
     * @return array
     *
     * @OA\Schema(
     *     schema="SubCategoryList",
     *     @OA\Property(property="id",type="integer"),
     *     @OA\Property(property="title",type="string",description="Название"),
     *     @OA\Property(property="description",type="string",description="Описание"),
     * )
     */
    public static function asList($category)
    {
        return ArrayHelper::toArray($category, [
            SubCategory::class => [
                'id',
                'title',
                'description'
            ]
        ]);
    }
}