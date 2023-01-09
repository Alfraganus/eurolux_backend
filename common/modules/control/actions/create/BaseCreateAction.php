<?php

namespace common\modules\control\actions\create;

use chulakov\components\services\CrudService;
use yii\base\Action;
use yii\di\Instance;

abstract class BaseCreateAction extends Action
{
    /**
     * @var string|CrudService
     */
    public $service;

    /**
     * @var string Форма
     */
    public $formClass;

    /**
     * @var string Шаблон
     */
    public $layout;
    /**
     * @var string
     */
    public $view = 'create';

    /**
     * @var string
     */
    public $defaultReturnUrl = 'index';

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (!empty($this->layout)) {
            $this->controller->layout = $this->layout;
        }
        if (!empty($this->service)) {
            $this->service = Instance::ensure($this->service);
        }
    }

    /**
     * @param $form
     * @param array $translationForms
     * @return \yii\base\Model
     */
    public function create($form, $translationForms = [])
    {
        return $translationForms ? $this->service->createWithTranslations($form, $translationForms) : $this->service->create($form);
    }
}
