<?php

namespace common\modules\category\models\providers;

use common\modules\category\models\Category;
use common\modules\category\models\SubCategory;
use common\modules\category\services\CategoryService;
use yii\helpers\ArrayHelper;

class CategoryProvider
{
    /**
     * @param Category[] $models
     * @return array
     *
     * @OA\Schema(
     *     schema="CategoryList",
     *     @OA\Property(property="id",type="integer"),
     *     @OA\Property(property="title",type="string",description="Название"),
     *     @OA\Property(property="description",type="string",description="Описание"),
     *     @OA\Property(property="icon",type="string",description="Иконка"),
     *     @OA\Property(property="sub-category",ref="#/components/schemas/SubCategoryList"),
     * )
     */
    public static function asList($category)
    {
        return ArrayHelper::toArray($category, [
            Category::class => [
                'id',
                'title',
                'description',
                'icon' => function (Category $category) {
                   $image = $category->image ? $category->image->asset_name : 'no-image.png';
                    return "https://api.spector77.uz/storage/web/upload/$image";
                },
                'sub-category' => function (Category $category) {
                    return $category->categories ? SubCategoryProvider::asList($category->categories) : null;
                },
            ]
        ]);
    }
}