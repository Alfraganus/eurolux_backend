<?php

namespace common\modules\category\controllers\api;

use common\modules\category\models\SubCategory;
use yii\base\Action;
use common\modules\category\models\providers\CategoryProvider;
use common\modules\category\models\Category;

/**
 * Получить список всех категорий
 * @OA\Get(
 *     path="/category/category",
 *     tags={"Категории"},
 *     operationId="category",
 *    @OA\Response(
 *        response=200,
 *        description="Список всех категорий",
 *        @OA\JsonContent(type="array",@OA\Items(ref="#/components/schemas/CategoryList")),
 *    ),
 * )
 */
class IndexAction extends Action
{
    /**
     * Вывод пользователей
     *
     * @return array
     */
    public function run()
    {
        $category = Category::find()
            ->active()
            ->all();
        return CategoryProvider::asList($category);
    }
}
