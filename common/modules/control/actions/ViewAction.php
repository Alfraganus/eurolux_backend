<?php

namespace common\modules\control\actions;

use chulakov\components\exceptions\NotFoundModelException;
use yii\web\NotFoundHttpException;

class ViewAction extends BaseProductionAction
{
    /**
     * @throws NotFoundHttpException
     */
    public function run(): string
    {
        try {
            $model = $this->service->find(\Yii::$app->request->get('id'));
        } catch (NotFoundModelException $e) {
            throw new NotFoundHttpException();
        }
        return $this->controller->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    protected function initView(): string
    {
        return 'view';
    }
}
