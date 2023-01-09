<?php

namespace common\modules\users\controllers\api;

use yii\base\Action;
use common\modules\users\models\providers\UsersProvider;
use common\modules\users\models\Users;

/**
 * Получить список всех пользователей
 * @OA\Get(
 *     path="/users/default",
 *     tags={"Пользователи"},
 *     operationId="index",
 *    @OA\Response(
 *        response=200,
 *        description="Список всех пользователей",
 *        @OA\JsonContent(type="array",@OA\Items(ref="#/components/schemas/CustomerList")),
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
        $models = Users::find()->all();
        return UsersProvider::asList($models);
    }
}
