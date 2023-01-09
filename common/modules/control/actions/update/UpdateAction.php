<?php

namespace common\modules\control\actions\update;

use yii\web\NotFoundHttpException;

/**
 * Class UpdateAction
 * @package common\modules\control\actions\update
 */
class UpdateAction extends BaseUpdateAction
{
    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function run($id)
    {
        $model = $this->findModel($id);
        $form = new $this->formClass($model);

        if ($form->load(\Yii::$app->request->post()) && $form->validate() ) {
            if ($this->update($model, $form)) {
                return $this->redirectUrl ? $this->controller->redirect($this->redirectUrl) : $this->controller->goBack([$this->defaultReturnUrl]);
            }
        }

        return $this->controller->render($this->view, [
            'model' => $form,
        ]);
    }
}
