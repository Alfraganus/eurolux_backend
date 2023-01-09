<?php

namespace common\modules\publication\actions;

use common\components\ValidatorComponent;
use Yii;
use yii\base\Action;
use yii\data\ActiveDataProvider;
use common\modules\publication\models\providers\PublicationProvider;
use common\modules\publication\models\repositories\PublicationRepository;
use common\modules\users\services\UserService;


class GetAllPublicationAction extends Action
{
    CONST DEFAULT_PAGE_SIZE = 6;


    public function run()
    {
        $responseMessage = Yii::$app->apiResponse;
        $userInfo = UserService::getUserInfo();

        $validator = Yii::createObject(ValidatorComponent::class)->checkObligatoryData([
            'latitude' => $userInfo['latitude'] ?? null,
            'longitude' => $userInfo['longitude'] ?? null,
            'search_radius' => $userInfo['search_radius'] ?? null,
        ]);

        if (sizeof($validator) > 0)  return $responseMessage->respond('Fail', 'User fails to provide data', $validator, '', '', 400);

        $query = PublicationProvider::find()
                ->select([
                    "*",
                    'distance' => PublicationRepository::getSqlDistanceFormula($userInfo['latitude'],$userInfo['longitude'])
                ])
                ->having(['<=', 'distance',$userInfo['search_radius']]);

       return  new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6,
            ],
        ]);

    }
}
