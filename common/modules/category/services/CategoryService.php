<?php

namespace common\modules\category\services;

use chulakov\filestorage\behaviors\FileUploadBehavior;
use chulakov\filestorage\params\UploadParams;
use common\helpers\MediaAssetDb;
use common\modules\publication\models\repositories\PublicationRepository;
use common\solutions\services\CrudService;
use common\solutions\exceptions\UnsaveModelException;
use chulakov\filestorage\uploaders\UploadInterface;
use common\modules\category\forms\CategoryForm;
use common\modules\category\models\Category;
use common\modules\category\models\repositories\CategoryRepository;
use DeepCopyTest\Matcher\Y;
use Yii;
use yii\web\UploadedFile;

class CategoryService extends CrudService
{
    /**
     * Конструктор с внедрением зависимости
     *
     * @param CategoryRepository $repository
     */

    const INNER_BACKEND_IMAGE_PATH = 'upload/';
    CONST S3_BUCKET_NAME= "category-images/";
    CONST S3_BUCKET_URL = "https://s3.timeweb.com/co21603-bucket-project-time-to-exchange/category-images/";

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public static function getImagePath($model)
    {
        if ($model->model && $model->model->image) {
                return  $model->model->image->asset_path;
        }
        return null;
    }

    /**
     * Создание нового объекта
     *
     * @param CategoryForm $form
     * @return Category
     * @throws \yii\db\Exception
     */
    public function create($form)
    {
        $model = $this->repository->create();
        $this->fill($model, $form);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($this->repository->save($model)) {
                $this->upload($model, $form);
                $transaction->commit();

                return $model;
            }
        } catch (UnsaveModelException $e) {
            $transaction->rollBack();
            $form->addErrors($model->getErrors());
        }

        return null;
    }

    /**
     * Заполнение данными модели из формы
     *
     * @param Category $model
     * @param CategoryForm $form
     */
    protected function fill(Category $model, CategoryForm $form)
    {
        $model->setAttributes($form->getAttributes([
            'slug',
            'title',
            'description',
            'is_active',
        ]));
    }

    /**
     * Загрузка файла
     *
     * @param Category $model
     * @param CategoryForm $form
     */

    protected function upload(Category $model, CategoryForm $form, $isNewRecord = true)
    {
        Yii::createObject(MediaAssetDb::class)->saveSingleAsset(
            UploadedFile::getInstance($form, 'iconFile'),
            $model,
            'category',
            CategoryService::S3_BUCKET_URL,
            CategoryService::S3_BUCKET_NAME,
            $isNewRecord
        );
    }


    /**
     * Обновление информации в объекте
     *
     * @param Category $model
     * @param CategoryForm $form
     * @return Category|null
     * @throws \Throwable
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function update($model, $form)
    {
        $this->fill($model, $form);

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($this->repository->save($model)) {
                $this->upload($model, $form,false);
                $transaction->commit();

                return $model;
            }

        } catch (UnsaveModelException $e) {
            $transaction->rollBack();
            $form->addErrors($model->getErrors());
        }

        return null;
    }

    /**
     * Удаление файлов, если они существуют
     *
     * @param Category $model
     * @param CategoryForm $form
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    protected function deleteOldFileIfExists(Category $model, CategoryForm $form)
    {
        if (($form->iconFile instanceof UploadInterface) && !is_null($model->icon)) {
            $model->icon->delete();
        }
    }
}
