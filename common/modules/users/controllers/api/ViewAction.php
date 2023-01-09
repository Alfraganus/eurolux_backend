<?php

namespace common\modules\users\controllers\api;

use yii\base\Action;
use common\modules\users\models\providers\UsersProvider;
use common\modules\users\models\Users;

/**
 * Получить информацию о пользователе
 * @OA\Get(
 *     path="/users/default/view",
 *     tags={"Пользователи"},
 *     operationId="view",
 *    @OA\Response(
 *        response=200,
 *        description="Информация о пользователе",
 *        @OA\JsonContent(type="array",@OA\Items(ref="#/components/schemas/CustomerList")),
 *    ),
 * )
 */
class ViewAction extends Action
{
    /**
     * Вывод пользователей
     *
     * @return array
     */
    public function run()
    {
        $models = Users::find()
            ->all();
        return UsersProvider::asList($models);
    }
}
