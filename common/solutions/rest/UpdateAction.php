<?php

namespace common\solutions\rest;

use yii\base\Model;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\base\InvalidConfigException;
use common\solutions\response\HTTP;
use common\solutions\services\CrudService;
use common\solutions\models\provider\ProviderInterface;
use common\solutions\exceptions\NotFoundModelException;

class UpdateAction extends Action
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
     * @param $id
     * @return array
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function run($id)
    {
        try {
            $form = $this->createForm();
            if ($form->load(\Yii::$app->request->post(), '') && $form->validate()) {
                $service = $this->createService();
                $model = $service->find($id);
                if ($service->update($model, $form)) {
                    if ($this->needModelResult && $provider = $this->confirmProvider()) {
                        return $provider::get($model->id);
                    }
                    return $this->controller->successResult(HTTP::SUCCESS_ACCEPTED);
                }
            }
        } catch (NotFoundModelException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e->getCode(), $e);
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e->getCode(), $e);
        }
        return $this->controller->errorResult($form, 'Не удалось обновить объект.');
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
        if (!method_exists($this->service, 'find')
        ||  !method_exists($this->service, 'update')) {
            throw new InvalidConfigException('Сервис должен реализовывать методы find и update.');
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
