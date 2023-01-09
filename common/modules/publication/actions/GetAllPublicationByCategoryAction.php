<?php

namespace common\modules\publication\actions;

use yii\base\Action;
use yii\data\ActiveDataProvider;
use common\modules\publication\models\providers\PublicationProvider;
use common\modules\publication\models\repositories\PublicationRepository;
use common\modules\users\services\UserService;


class GetAllPublicationByCategoryAction extends Action
{
    public function run($category_id,$sub_category_id=null)
    {
        $query = PublicationProvider::find()
                ->where(['category_id'=>$category_id]);

        if ($sub_category_id) {
            $query->andWhere(['sub_category_id'=>$sub_category_id]);
        }
       return  new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6,
            ],
        ]);

    }
}
