<?php

namespace common\modules\publication\actions;

use yii\base\Action;
use yii\data\ActiveDataProvider;
use common\modules\publication\models\providers\PublicationProvider;


class GetAllPublicationByUserIdAction extends Action
{
    public function run($user_id)
    {
        $query = PublicationProvider::find()
                ->where(['user_id'=> $user_id]);

       return  new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6,
            ],
        ]);

    }
}
