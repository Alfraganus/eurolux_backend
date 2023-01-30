<?php

namespace common\modules\publication\models\providers;

use common\models\MediaAsset;
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
            'title',
            'description',
            'price',

            'is_active'=> function () {
                return (bool) $this->is_active;
            },
            'image'=>function() {
                return MediaAsset::find()->select('asset_name')
                    ->where(['source_table'=>'publication'])
                    ->andWhere(['object_id'=>$this->id])
                    ->orderBy('id ASC')
                    ->one()->asset_name??null;
            },

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
