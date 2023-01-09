<?php

namespace common\modules\control\actions\update;

/**
 * Class SingleUpdateAction
 * @package common\modules\control\actions\update
 */
class SingleUpdateAction extends UpdateAction
{
    public $recordId = 1;

    /**
     * @param null $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($id = null)
    {
        return parent::run($this->recordId);
    }
}