<?php

namespace common\solutions\models\repositories;

use yii\db\ActiveRecord;
use common\solutions\exceptions\UnsaveModelException;
use common\solutions\exceptions\NotFoundModelException;

abstract class CrudRepository
{
    /**
     * Поиск модели
     *
     * @param integer $id
     * @return ActiveRecord
     * @throws NotFoundModelException
     */
    abstract public function get($id);

    /**
     * Сохранение модели с проверкой успешности сохранения
     *
     * @param ActiveRecord $model
     * @return bool
     * @throws UnsaveModelException
     */
    public function save(ActiveRecord $model)
    {
        if (!$model->save()) {
            throw new UnsaveModelException();
        }
        return true;
    }

    /**
     * Удаление модели по ее id
     *
     * @param integer $id
     * @return false|int
     * @throws NotFoundModelException
     * @throws \Exception
     * @throws \Throwable
     */
    public function delete($id)
    {
        return $this->get($id)->delete();
    }
}
