<?php

namespace common\modules\users\models\scopes;

//use chulakov\model\models\scopes\ActiveQuery;
use yii\db\ActiveQuery;

/**
 * Класс запроса для модели [[\common\modules\users\models\Users]].
 *
 * @see \common\modules\users\models\Users
 */
class UsersQuery extends ActiveQuery
{
    /**
     * Выборка по активности
     *
     * @param bool $active
     * @return static
     */
    public function active($active = true)
    {
        return $this->andWhere(['{{%users}}.is_active' => $active]);
    }

    /**
     *
     * @param $id
     * @return CustomerQuery
     */
    public function findById($id)
    {
        return $this->andWhere(['{{%users}}.id' => $id]);
    }

    /**
     *
     * @param $phone
     * @return CustomerQuery
     */

    public function findByPhone($phone)
    {
        return $this->andWhere([$this->getPrimaryTableName() . '.[[phone]]' => $phone]);
    }
}
