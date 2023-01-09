<?php

namespace common\modules\category\services;

use common\solutions\services\CrudService;
use common\solutions\exceptions\UnsaveModelException;
use common\modules\category\forms\SubCategoryForm;
use common\modules\category\models\SubCategory;
use common\modules\category\models\repositories\SubCategoryRepository;

class SubCategoryService extends CrudService
{
    /**
     * Конструктор с внедрением зависимости
     *
     * @param SubCategoryRepository $repository
     */
    public function __construct(SubCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Создание нового объекта
     *
     * @param SubCategoryForm $form
     * @return SubCategory
     * @throws \yii\db\Exception
     */
    public function create($form)
    {
        $model = $this->repository->create();

        $this->fill($model, $form);
        try {
            if ($this->repository->save($model)) {
                return $model;
            }
        } catch (UnsaveModelException $e) {
            $form->addErrors($model->getErrors());
        }

        return null;
    }

    /**
     * Заполнение данными модели из формы
     *
     * @param SubCategory $model
     * @param SubCategoryForm $form
     */
    protected function fill(SubCategory $model, SubCategoryForm $form)
    {
        $model->setAttributes($form->getAttributes([
            'category_id',
            'slug',
            'title',
            'description',
            'is_active',
        ]));
    }

    /**
     * Обновление информации в объекте
     *
     * @param SubCategory $model
     * @param SubCategoryForm $form
     * @return bool
     */
    public function update($model, $form)
    {
        $this->fill($model, $form);

        try {
            if ($this->repository->save($model)) {
                return true;
            }
        } catch (UnsaveModelException $e) {
            $form->addErrors($model->getErrors());
        }

        return false;
    }
}
