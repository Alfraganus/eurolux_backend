<?php

namespace common\modules\control\actions\update;

use chulakov\components\exceptions\NotFoundModelException;
use common\modules\control\actions\BaseProductionAction;
use common\modules\control\services\TranslationService;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class UpdateAction
 * @package common\modules\control\actions\update
 */
class UpdateSimpleAction extends BaseProductionAction
{
    /** @var Model */
    protected $model;
    /** @var Model */
    protected $form;

    /**
     * @inheritdoc
     */
    protected function validationSuccess($form, $model = null, $translationForms = []): ?Response
    {
        if ($this->update($model, $form, $translationForms)) {
            return $this->redirectSuccess($model);
        }

        return null;
    }

    /**
     * @param $id
     *
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function run($id)
    {
        $this->model = $this->findModel($id);
        $this->form = $this->createForm($this->model);

        if ($result = $this->initForm($this->form, $this->model)) {
            return $result;
        }

        return $this->renderView($this->form, $this->translationForms);
    }

    /**
     * @param $id
     *
     * @return ActiveRecord
     * @throws NotFoundHttpException
     */
    public function findModel($id): ActiveRecord
    {
        try {
            return $this->service->find($id);
        } catch (NotFoundModelException $exception) {
            throw new NotFoundHttpException('Запрашиваемый элемент не найден');
        }
    }

    /**
     * @param $model
     * @param $form
     * @param array $translationForms
     *
     * @return bool
     */
    public function update($model, $form, array $translationForms): bool
    {
        if (!empty($translationForms) && ($this->service instanceof TranslationService)) {
            $result = $this->service->updateWithTranslations($model, $form, $translationForms);
        } else {
            $result = $this->service->update($model, $form);
        }

        return $result != null;
    }

    protected function initView(): string
    {
        return 'update';
    }
}
