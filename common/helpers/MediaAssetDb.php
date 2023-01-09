<?php

namespace common\helpers;

use common\models\MediaAsset;
use common\modules\category\services\CategoryService;
use common\modules\publication\models\repositories\PublicationRepository;
use common\modules\publication\services\PublicationService;
use common\solutions\exceptions\UnsaveModelException;
use Yii;
use yii\base\Exception;
use yii\web\UploadedFile;

class MediaAssetDb
{
    private function getModel($model,$isNewRecord)
    {
        if ($isNewRecord) {
            return new MediaAsset();
        }
        return MediaAsset::findOne(['object_id'=>$model->id]);
    }

    public function saveSingleAsset(UploadedFile $uploadedFile, $model, $source_table, $bucket_url, $bucket_name,$isNewRecord )
    {
        $imageName                       = $uploadedFile->baseName . time() . '.' . $uploadedFile->extension;
        $repository                      = Yii::createObject(PublicationRepository::class);
        $savingModel                     = $this->getModel($model,$isNewRecord);
        $savingModel->model_class        = get_class($model);
        $savingModel->source_table       = $source_table;
        $savingModel->object_id          = $model->id;
        $savingModel->asset_name         = $imageName;
        $savingModel->asset_extension    = $uploadedFile->extension;
        $savingModel->asset_path         = $bucket_url . $imageName;
        $savingModel->asset_mime         = $uploadedFile->type;
        $savingModel->asset_size        = $uploadedFile->size;
        if (!$savingModel->save()) {
            throw new UnsaveModelException(json_encode($savingModel->errors));
        }
        $repository->uploadToS3(
            $bucket_name . $imageName, $uploadedFile->tempName
        );
    }

}               