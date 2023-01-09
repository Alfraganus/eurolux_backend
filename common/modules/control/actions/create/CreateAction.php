<?php

namespace common\modules\control\actions\create;

use sem\helpers\ArrayHelper;
use yii\base\Model;
use Yii;

/**
 * Class CreateAction
 * @package common\modules\control\actions
 */
class CreateAction extends BaseCreateAction
{
    /**
     * @return string|\yii\web\Response
     */
    public function run()
    {
        $form = new $this->formClass;
        $withTranslation = $form->hasMethod('getTranslationModelsForAllLanguages');
        $translationValidate = true;

        if ($withTranslation) {
            $translationForms = $form->getTranslationModelsForAllLanguages();
            if (Model::loadMultiple($translationForms, Yii::$app->request->post())) {
                $translationValidate = Model::validateMultiple($translationForms);
            }
        }

        if ($form->load(Yii::$app->request->post()) && $form->validate() && $translationValidate) {
            if ($this->create($form, $withTranslation ? $translationForms : [])) {
                return $this->controller->redirect([$this->defaultReturnUrl]);
            }
        }

        return $this->controller->render($this->view, ArrayHelper::merge([
            'model' => $form,
        ], $withTranslation ? ['translationModels' => $translationForms] : []));
    }
}
