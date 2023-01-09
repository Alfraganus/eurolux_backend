<?php

namespace common\modules\users\models\providers;

use yii\helpers\ArrayHelper;
use common\modules\users\models\Users;

class UsersProvider
{
    /**
     * @param Users[] $models
     * @return array
     *
     * @OA\Schema(
     *     schema="CustomerList",
     *     @OA\Property(property="id",type="integer"),
     *     @OA\Property(property="is_active",type="string",description="Активность"),
     *     @OA\Property(property="name",type="string",description="Имя"),
     *     @OA\Property(property="phone",type="string",description="Телефон"),
     * )
     */
    public static function asList($models)
    {
        return ArrayHelper::toArray($models, [
            Users::class => [
                'id',
                'is_active',
                'name',
                'phone',
            ],
        ]);
    }
}
