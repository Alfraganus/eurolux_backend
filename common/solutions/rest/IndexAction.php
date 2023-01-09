<?php

namespace common\solutions\rest;

use yii\base\Model;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use common\solutions\models\search\SearchModel;
use common\solutions\models\provider\ProviderInterface;

class IndexAction extends Action
{
    /**
     * @var SearchModel
     */
    public $searchClass;
    /**
     * @var ProviderInterface
     */
    public $providerClass;

    /**
     * Получение массива данных списка моделей с фильтрацией
     *
     * @return array
     * @throws BadRequestHttpException
     */
    public function run()
    {
        try {
            /** @var SearchModel $search */
            $search = $this->createSearch();
            if ($data = $search->search(\Yii::$app->request->get(), '')) {
                $models = $data->getModels();
                if ($provider = $this->confirmProvider()) {
                    return $provider::format($models);
                }
            }
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e->getCode(), $e);
        }
        return $this->controller->errorResult($search, 'Не найдено ни одной записи удовлетворяющей условию.');
    }

    /**
     * Создание модели формы для валидации и передачи в сервис
     *
     * @return Model
     * @throws InvalidConfigException
     */
    protected function createSearch()
    {
        if (empty($this->searchClass)) {
            throw new InvalidConfigException('Не указан класс создаваемой модели формы.');
        }
        $search = new $this->searchClass;
        if (!method_exists($search, 'search')) {
            throw new InvalidConfigException('Модель должна реализовать метод search для поиска.');
        }
        return $search;
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
