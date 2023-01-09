<?php

namespace common\models\scopes;

//use chulakov\components\models\scopes\ActiveQuery;
use yii\db\ActiveQuery;

class UserQuery extends ActiveQuery
{
    /**
     * Поиск по логину
     *
     * @param string $username
     * @return static
     */
    public function findByUsername($username)
    {
        return $this->andWhere([$this->getPrimaryTableName() . '.[[username]]' => $username]);
    }

    /**
     * Поиск по токену авторизации
     *
     * @param string|integer $status
     * @return static
     */
    public function findByStatus($status)
    {
        return $this->andWhere([$this->getPrimaryTableName() . '.[[status]]' => $status]);
    }
}
