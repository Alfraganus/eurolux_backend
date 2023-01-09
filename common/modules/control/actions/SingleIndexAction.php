<?php

namespace common\modules\control\actions;

use chulakov\components\exceptions\NotFoundModelException;
use chulakov\components\models\repositories\CrudRepository;
use chulakov\components\services\CrudService;
use yii\base\Action;
use yii\di\Instance;
use yii\web\NotFoundHttpException;

/**
 * Class SingleIndexAction
 * @package common\modules\control\actions
 */
class SingleIndexAction extends Action
{
    /**
     * @var string
     */
    public $view = 'view';

    /**
     * @var string|CrudService
     */
    public $service;

    /**
     * @var string Шаблон
     */
    public $layout;

    /**
     * @inheritdoc
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
     * @return string
     */
    public function run()
    {
        $model = $this->getModel();

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }

    /**
     * @return \yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    public function getModel()
    {
        try {
            return $this->service->find(1);
        } catch (NotFoundModelException $e) {
            throw new NotFoundHttpException();
        }
    }
}
