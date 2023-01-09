<?php

namespace common\modules\control\actions;

use chulakov\components\services\CrudService;
use chulakov\model\services\Service;
use sem\helpers\ArrayHelper;
use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\di\Instance;
use yii\web\Response;

abstract class BaseProductionAction extends Action
{
    /**
     * @var string|Service
     */
    public $service;
    /**
     * @var string Форма модели
     */
    public $formClass;
    /**
     * @var string Шаблон
     */
    public $layout;
    /**
     * @var string
     */
    public $view;
    /**
     * @var string
     */
    public $defaultReturnUrl = 'index';
    /**
     * @var bool
     */
    protected $withTranslation = false;
    /**
     * @var array
     */
    protected $translationForms = [];

    protected abstract function initView(): string;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
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

        $this->view = $this->initView();
    }

    /**
     * Создать форму из имени класса
     *
     * @param $model
     *
     * @return Model
     */
    protected function createForm($model = null)
    {
        return new $this->formClass($model);
    }

    /**
     * Дополенительные свойства для view
     *
     * @return array
     */
    protected function viewProperty(): array
    {
        return [];
    }

    /**
     * Генерация view
     *
     * @param $form
     * @param array $translationForms
     *
     * @return string
     */
    protected function renderView($form, array $translationForms = []): string
    {
        return $this->controller->render(
            $this->view,
            ArrayHelper::merge(
                ['model' => $form],
                $this->withTranslation ? ['translationModels' => $translationForms] : [],
                $this->viewProperty()
            )
        );
    }

    /**
     * Инициализации и валидации формы
     *
     * @param $form
     * @param null $model
     *
     * @return null
     */
    protected function initForm($form, $model = null)
    {
        $this->withTranslation = $form->hasMethod('getTranslationModelsForAllLanguages');
        $translationValidate = true;

        if ($this->withTranslation) {
            $this->translationForms = $form->getTranslationModelsForAllLanguages();
            if (Model::loadMultiple($this->translationForms, Yii::$app->request->post())) {
                $translationValidate = Model::validateMultiple($this->translationForms);
            }
        }

        if ($form->load(Yii::$app->request->post()) && $form->validate() && $translationValidate) {
            return $this->validationSuccess($form, $model, $this->translationForms ?? []);
        }

        return null;
    }

    /**
     * Метод вызывается при успешной инициализации и валидации формы
     *
     * @param Model $form
     * @param ActiveRecord|null $model
     * @param Model[] $translationForms
     *
     * @return Response|null
     */
    protected function validationSuccess($form, $model, $translationForms)
    {
        return null;
    }

    /**
     * Вызывается по окончаний удачной работы сервиса (create/update)
     *
     * @param $model
     *
     * @return Response
     */
    protected function redirectSuccess($model): Response
    {
        return $this->controller->redirect([$this->defaultReturnUrl]);
    }
}