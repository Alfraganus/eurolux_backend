<?php

namespace common\modules\publication\models\providers;

use Yii;
use common\modules\publication\models\Publication;
use common\modules\publication\models\PublicationImages;
use sem\helpers\ArrayHelper;

class PublicationProvider extends Publication
{

    public function fields()
    {
        return [
            'id',
            'category'=> function (Publication $publication) {
                return $publication->category->title;
            },
            'sub_category'=> function (Publication $publication) {
                return $publication->subCategory->title;
            },
            'link_video',
            'title',
            'description',
            'price',
            'location',
            'latitude',
            'longitude',
            'tariff_id',
            'is_mutually_surcharged'=> function () {
                return (bool) $this->is_mutually_surcharged;
            },
            'is_active'=> function () {
                return (bool) $this->is_active;
            },
            'images'=>function() {
                return ArrayHelper::getColumn(
                    PublicationImages::find()->select('image')
                        ->where(['publication_id'=>$this->id])
                        ->asArray()
                        ->all(),'image');
            },
            'tags' => function () {
                return ArrayHelper::getColumn(
                    ArrayHelper::getColumn(PublicationTagProvider::find()
                        ->where(['publication_id' => $this->id])
                        ->all(), 'tag'), 'name');
            },
            'exchange_category'=> function() {
                return PublicationExchangeCategoryProvider::find()
                    ->where(['publication_id'=>$this->id])
                    ->all();
            },
          'distance'=> function() {
              return   $this->getDistanceBetweenPointsNew(
                    $this->latitude,
                    $this->longitude,
                    40.779544,
                    72.367030
                );
            }
        ];

    }

    public function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Km') {
        $theta = $longitude1 - $longitude2;
        $distance = sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta));

        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;

        switch($unit)
        {
            case 'Mi': break;
            case 'Km' : $distance = $distance * 1.609344;
        }

        return (round($distance,2));
    }
}
