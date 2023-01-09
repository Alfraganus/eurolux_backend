<?php

namespace common\solutions\rest;

use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\base\InvalidConfigException;
use common\solutions\services\CrudService;
use common\solutions\models\provider\ProviderInterface;
use common\solutions\exceptions\NotFoundModelException;

class ViewAction extends Action
{
    /**
     * @var CrudService
     */
    public $service;
    /**
     * @var ProviderInterface
     */
    public $providerClass;
    /**
     * @var bool Возможность перобразования модели в массив при отсутствии провайдера
     */
    public $needModelConvert = true;

    /**
     * Получение массива информации об объекте
     *
     * @param integer $id
     * @return array
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function run($id)
    {
        try {
            if ($provider = $this->confirmProvider()) {
                return $provider::get($id);
            }
            if ($this->needModelConvert) {
                return ArrayHelper::toArray($this->createService()->find($id));
            }
            throw new InvalidConfigException('Не найден провайдер данных модели.');
        } catch (NotFoundModelException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e->getCode(), $e);
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e->getCode(), $e);
        }
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
        if (!method_exists($this->service, 'find')) {
            throw new InvalidConfigException('Сервис должен реализовывать метод find.');
        }
        return $this->service;
    }

    /**
     * Валидация провайдера
     *
     * @return ProviderInterface|null
     * @throws \Exception
     */
    protected function confirmProvider()
    {
        try {
            if (empty($this->providerClass) || !class_exists($this->providerClass)) {
                throw new InvalidConfigException('Не настроен класс провайдера данных.');
            }
            if (!($this->providerClass instanceof ProviderInterface)) {
                throw new InvalidConfigException('Провайдер должен наследоваться от ProviderInterface.');
            }
            return $this->providerClass;
        } catch (\Exception $e) {
            if ($this->needModelConvert) {
                return null;
            }
            throw $e;
        }
    }
}
