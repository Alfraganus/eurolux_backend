<?php

namespace common\modules\publication\actions;

use yii\base\Action;
use yii\data\ActiveDataProvider;
use common\modules\publication\models\providers\PublicationProvider;
use common\modules\publication\models\repositories\PublicationRepository;
use common\modules\users\services\UserService;


class GetAllPublicationNoAuthAction extends Action
{
    CONST DEFAULT_PAGE_SIZE = 6;

    public function run()
    {
        $query = PublicationProvider::find();

       return  new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::DEFAULT_PAGE_SIZE,
            ],
        ]);
    }
}
