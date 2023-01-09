<?php

namespace common\modules\publication\services;

use chulakov\model\services\Service;
use common\modules\publication\models\PublicationExchangeCategory;
use common\modules\publication\models\repositories\PublicationRepository;
use Exception;
use Yii;
use yii\web\UploadedFile;

/**
 * Сервис обработки Пользователя
 */
class PublicationService extends Service
{

    CONST S3_BUCKET_URL = "https://s3.timeweb.com/co21603-bucket-project-time-to-exchange/publication-images/";
    CONST S3_BUCKET_NAME= "publication-images/";

    private $publicationRepasotory;

    public function __construct()
    {
        $this->publicationRepasotory = new PublicationRepository();
    }


    public function fillExchangeCategory($categories, $publication_id)
    {
        foreach ($categories as $category) {
            $this->publicationRepasotory->savePublication($category, $publication_id);
        }
    }

    public function fillImages($images,$publication_id)
    {
        foreach ($images as $image) {
            $imageName = $image->baseName.time() . '.' . $image->extension;
            $this->publicationRepasotory->uploadToDB(self::S3_BUCKET_URL.$imageName,$publication_id);
            $this->publicationRepasotory->uploadToS3(self::S3_BUCKET_NAME . $imageName,$image->tempName);
        }
    }

    public function fillTags($tags,$publication_id)
    {
        foreach ($tags as $tag) {
           $tag_id =  $this->publicationRepasotory->checkTagExist($tag);
           $this->publicationRepasotory->assignPublicationTag($publication_id,$tag_id);
        }
    }





}
