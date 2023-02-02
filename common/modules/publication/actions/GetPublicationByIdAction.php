<?php

namespace common\modules\publication\actions;

use yii\base\Action;
use yii\data\ActiveDataProvider;
use common\modules\publication\models\providers\PublicationProvider;
use common\modules\publication\models\repositories\PublicationRepository;
use common\modules\users\services\UserService;


class GetPublicationByIdAction extends Action
{
    public function run($id)
    {
        return PublicationProvider::findOne($id);
    }
}
