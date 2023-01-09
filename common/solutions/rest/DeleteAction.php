<?php

namespace common\solutions\rest;

use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\base\InvalidConfigException;
use common\solutions\response\HTTP;
use common\solutions\services\CrudService;
use common\solutions\exceptions\NotFoundModelException;

class DeleteAction extends Action
{
    /**
     * @var CrudService
     */
    public $service;

    /**
     * Действие удаление модели из базы
     *
     * @param integer $id
     * @return array
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     * @throws \Throwable
     */
    public function run($id)
    {
        try {
            if ($this->createService()->delete($id)) {
                return $this->controller->successResult(HTTP::SUCCESS_NO_CONTENT);
            }
        } catch (NotFoundModelException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e->getCode(), $e);
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage(), $e->getCode(), $e);
        }
        throw new BadRequestHttpException('Не удалось удалить.');
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
        if (!method_exists($this->service, 'delete')) {
            throw new InvalidConfigException('Сервис должен реализовывать метод delete.');
        }
        return $this->service;
    }
}
