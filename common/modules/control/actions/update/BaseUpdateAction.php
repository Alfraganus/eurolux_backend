<?php

namespace common\modules\control\actions\update;

use chulakov\model\services\Service;
use common\solutions\exceptions\NotFoundModelException;
use yii\base\Action;
use yii\di\Instance;
use yii\web\NotFoundHttpException;

class BaseUpdateAction extends Action
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
    public $view = 'update';

    /**
     * @var string
     */
    public $defaultReturnUrl;

    /**
     * @var string
     */
    public $redirectUrl;

    /**
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
     * @param $id
     * @return \yii\db\ActiveQuery|\yii\db\Query
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        try {
            return $this->service->find($id);
        }
        catch (NotFoundModelException $exception) {
            throw new NotFoundHttpException('Запрашиваемый элемент не найден');
        }
    }

    /**
     * @param $model
     * @param $form
     * @return bool
     * @throws \Exception
     */
    public function update($model, $form) {
        return $this->service->update($model, $form);
    }
}
