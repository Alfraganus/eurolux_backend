<?php

namespace common\solutions\models\scopes;

use yii\db\ActiveRecord;
use yii\db\Connection;

/**
 * Базовый построитель запросов
 *
 * @package common\solutions\models\scope
 */
class ActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * @var bool Использовать ли лимит при выборке через one()
     */
    protected $useLimitInOne = true;

    /**
     * Поиск по ID
     *
     * @param int $id
     * @return static
     */
    public function findById($id)
    {
        return $this->andWhere([$this->getPrimaryTableName() . '.[[id]]' => $id]);
    }

    /**
     * Получение единственной модели с добавление лимита в запрос.
     *
     * @param Connection|null $db
     * @return ActiveRecord
     */
    public function one($db = null)
    {
        if ($this->useLimitInOne) {
            $this->limit(1);
        }
        return parent::one($db);
    }
}
