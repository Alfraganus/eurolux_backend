<?php

namespace common\modules\control\actions\create;

use common\modules\control\actions\BaseProductionAction;
use common\modules\control\services\TranslationService;
use yii\base\Model;
use yii\web\Response;

/**
 * Class CreateAction
 * @package common\modules\control\actions
 */
class CreateSimpleAction extends BaseProductionAction
{
    /**
     * @inheritdoc
     */
    protected function validationSuccess($form, $model, $translationForms): ?Response
    {
        if ($this->create($form, $translationForms)) {
            return $this->redirectSuccess($model);
        }

        return null;
    }

    /**
     * @return string|Response
     */
    public function run()
    {
        $form = $this->createForm();

        if ($result = $this->initForm($form)) {
            return $result;
        }

        return $this->renderView($form, $this->translationForms ?? []);
    }


    /**
     * @param Model $form
     * @param Model[] $translationForms
     *
     * @return Model
     */
    protected function create($form, $translationForms)
    {
        if (!empty($translationForms) && ($this->service instanceof TranslationService)) {
            $result = $this->service->createWithTranslations($form, $translationForms);
        } else {
            $result = $this->service->create($form);
        }

        return $result;
    }

    protected function initView(): string
    {
        return 'create';
    }
}
