<?php

namespace common\solutions\services;

use yii\base\Model;
use common\solutions\exceptions\NotFoundModelException;
use common\solutions\models\repositories\CrudRepository;

abstract class CrudService
{
    /**
     * @var CrudRepository
     */
    protected $repository;

    /**
     * Поиск объекта по ее ID
     *
     * @param integer $id
     * @return \yii\db\ActiveRecord
     * @throws NotFoundModelException
     */
    public function find($id)
    {
        return $this->repository->get($id);
    }

    /**
     * Создание нового объекта
     *
     * @param Model $form
     * @return Model
     */
    abstract public function create($form);

    /**
     * Обновление информации в объекте
     *
     * @param Model $model
     * @param Model $form
     * @return boolean
     */
    abstract public function update($model, $form);

    /**
     * Удаление объекта
     *
     * @param integer $id
     * @return false|integer
     * @throws NotFoundModelException
     * @throws \Exception
     * @throws \Throwable
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
