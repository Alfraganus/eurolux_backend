<?php

namespace common\modules\control\actions\update;

/**
 * Class SingleUpdateAjaxAction
 * @package common\modules\control\actions\update
 */
class SingleUpdateAjaxAction extends UpdateAjaxAction
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
