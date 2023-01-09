<?php

namespace common\modules\control\actions\create;

use common\modules\article\article\forms\ArticleForm;
use sem\helpers\ArrayHelper;
use Yii;

/**
 * Class CreateAjaxAction
 * @package common\modules\control\actions
 */
class CreateAjaxAction extends BaseCreateAction
{
    /**
     * @return string|\yii\web\Response
     */
    public function run()
    {
        /**
         * @var ArticleForm $form
         */
        $form = new $this->formClass;

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            if ($this->create($form)) {
                return $this->controller->redirect([$this->defaultReturnUrl]);
            }
        }

        return $this->controller->render($this->view, [
            'model' => $form,
        ]);
    }
}
