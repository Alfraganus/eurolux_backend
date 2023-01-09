<?php

namespace common\models;

use Yii;


class S3Manager
{
     public function deleteFromS3($source_table,$object_id,$bucket_name)
     {
       $media = MediaAsset::findOne([
           'source_table' => $source_table,
           'object_id'    => $object_id
       ]);
       if ($media) {
           Yii::$app->flysystem->delete($bucket_name . $media->asset_name);
       }
     }
}
