<?php

namespace common\modules\publication\models\repositories;

use chulakov\model\exceptions\NotFoundModelException;
use chulakov\model\repositories\Repository;
use common\modules\publication\models\Publication;
use common\modules\publication\models\PublicationExchangeCategory;
use common\modules\publication\models\PublicationImages;
use common\modules\publication\models\PublicationTag;
use common\modules\publication\models\Tag;
use Yii;
use yii\db\Exception;

class PublicationRepository extends Repository
{

    public function query()
    {
        return Publication::find();
    }

    public function savePublication($requestedData, $publication_id)
    {
        $publication = new PublicationExchangeCategory();
        $publication->publication_id = $publication_id;
        $publication->category_id = $requestedData['category_id'];
        $publication->sub_category_id = $requestedData['sub_category_id'];
        $this->validateModelSave($publication);
    }

    public function uploadToS3($image, $tmpName)
    {
        try {
            Yii::$app->flysystem->write($image, file_get_contents($tmpName));
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function uploadToDB($image, $publication_id)
    {
        $publicationImage = new PublicationImages();
        $publicationImage->publication_id = $publication_id;
        $publicationImage->image = $image;
        $this->validateModelSave($publicationImage);
    }


    public function get($id)
    {
        if ($model = $this->findOne($id)->one())
            return $model;
        throw new NotFoundModelException("Запрашиваемый  пользователь не найден");
    }

    public function checkTagExist($tag)
    {
        $tagModel = Tag::findOne(['name'=>$tag]);
        if ($tagModel) {
            return $tagModel->id;
        }
        $newTag = new Tag();
        $newTag->name = $tag;
        $newTag->save(false);
        return $newTag->id;
    }

    public function assignPublicationTag($publication_id, $tag_id)
    {
        $publicationTag = new PublicationTag();
        $publicationTag->publication_id = $publication_id;
        $publicationTag->tag_id = $tag_id;
        $this->validateModelSave($publicationTag);
    }

    private function validateModelSave($model)
    {
        if (!$model->save() || !$model->validate()) {
            throw new \Exception(json_encode(array_values($model->errors)));
        }
    }

    public static function getSqlDistanceFormula($lat,$lng)
    {
        return "ROUND((((acos(sin((" . $lat . "*pi() / 180)) * sin((`latitude`*pi() / 180)) + cos((". $lat."*pi() / 180)) * cos((`latitude`*pi() / 180)) * cos(((". $lng." - `longitude`)*pi() / 180))))*180 / pi())*60*1.1515*1.609344), 2)";
    }


}