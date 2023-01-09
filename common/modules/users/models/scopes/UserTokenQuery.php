<?php

namespace common\modules\users\models\scopes;

//use chulakov\components\models\scopes\ActiveQuery;
use yii\db\ActiveQuery;

class UserTokenQuery extends ActiveQuery
{
    /**
     * Поиск модели по идентификатору
     *
     * @param integer $id
     * @return static
     */
    public function findById($id)
    {
        return $this->andWhere([$this->getPrimaryTableName() . '.[[id]]' => $id]);
    }

    /**
     * Поиск по пользователю
     *
     * @param integer $userId
     * @return static
     */
    public function findByUserId($userId)
    {
        return $this->andWhere([$this->getPrimaryTableName() . '.[[user_id]]' => $userId]);
    }

    /**
     * Поиск модели токена через сам токен
     *
     * @param string $token
     * @return static
     */
    public function findByToken($token)
    {
        return $this->andWhere([$this->getPrimaryTableName() . '.[[token]]' => $token]);
    }
}
