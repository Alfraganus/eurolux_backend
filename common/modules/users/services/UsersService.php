<?php

namespace common\modules\users\services;

use chulakov\model\services\Service;
use common\modules\users\models\Users;
use common\modules\users\models\forms\UsersForm;
use common\modules\users\models\repositories\UsersRepository;
use common\solutions\exceptions\UnsaveModelException;

class UsersService extends Service
{
    /**
     * Конструктор сервиса
     *
     * @param UsersRepository $repository
     */
    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return array|Users|\yii\db\ActiveQuery|\yii\db\ActiveRecord|\yii\db\Query|null
     * @throws \chulakov\model\exceptions\NotFoundModelException
     */
    public function find($id)
    {
        return $this->repository->get($id);
    }

    /**
     * Создание нового объекта
     *
     * @param UsersForm $form
     * @return Users
     */
    public function create($form)
    {
        $model = new Users();
        if ($this->update($model, $form)) {
            return $model;
        }
        return null;
    }

    /**
     * Обновление информации в объекте
     *
     * @param Users $model
     * @param UsersForm $form
     * @return boolean
     */
    public function update($model, $form)
    {
        try {
            $this->fill($model, $form);
            if ($this->repository->save($model)) {
                return true;
            }
        } catch (UnsaveModelException $e) {
            $form->addErrors($model->getErrors());
            \Yii::error($e);
        }
        return false;
    }

    /**
     * Заполнение модели из формы
     *
     * @param Users $model
     * @param UsersForm $form
     */
    protected function fill($model, $form)
    {
        $model->setAttributes($form->getAttributes([
            'is_active', 'name', 'phone'
        ]));
    }
}