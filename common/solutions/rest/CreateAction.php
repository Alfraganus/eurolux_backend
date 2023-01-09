<?php

namespace common\solutions\rest;

use yii\base\Model;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use common\solutions\response\HTTP;
use common\solutions\services\CrudService;
use common\solutions\models\provider\ProviderInterface;

class CreateAction extends Action
{
    /**
     * @var CrudService
     */
    public $service;
    /**
     * @var Model
     */
    public $formClass;
    /**
     * @var bool Передавать ли данные о модели в качестве результата выполнения
     */
    public $needModelResult = false;
    /**
     * @var ProviderInterface
     */
    public $providerClass;

    /**
     * Создание нового объекта в системе
     *
     * @return array
     * @throws BadRequestHttpException
     */
    public function run()
    {
        try {
            $form = $this->createForm();
            if ($form->load(\Yii::$app->request->post(), '') && $form->validate()) {
                if ($model = $this->createService()->create($form)) {
                    if ($this->needModelResult && $provider = $this->confirmProvider()) {
                        return $provider::get($model->id);
                    }
                    return $this->controller->successResult(HTTP::SUCCESS_CREATED);
                }
            }
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e->getCode(), $e);
        }
        return $this->controller->errorResult($form, 'Не удалось создать новый объект.');
    }

    /**
     * Создание модели формы для валидации и передачи в сервис
     *
     * @return Model
     * @throws InvalidConfigException
     */
    protected function createForm()
    {
        if (empty($this->formClass)) {
            throw new InvalidConfigException('Не указан класс создаваемой модели формы.');
        }
        $form = new $this->formClass;
        if (!($form instanceof Model)) {
            throw new InvalidConfigException('Модель формы должны наследоваться от Model.');
        }
        return $form;
    }

    /**
     * Создание сервиса
     *
     * @return CrudService
     * @throws InvalidConfigException
     */
    protected function createService()
    {
        if (!is_object($this->service)) {
            $this->service = \Yii::createObject($this->service);
        }
        if (!method_exists($this->service, 'create')) {
            throw new InvalidConfigException('Сервис должен реализовывать метод create.');
        }
        return $this->service;
    }

    /**
     * Валидация провайдера
     *
     * @return ProviderInterface
     * @throws InvalidConfigException
     */
    protected function confirmProvider()
    {
        if (empty($this->providerClass) || !class_exists($this->providerClass)) {
            throw new InvalidConfigException('Не настроен класс провайдера данных.');
        }
        if (!($this->providerClass instanceof ProviderInterface)) {
            throw new InvalidConfigException('Провайдер должен наследоваться от ProviderInterface.');
        }
        return $this->providerClass;
    }
}
