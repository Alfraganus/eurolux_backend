<?php
/**
 * Файл класса ToggleActivityAction
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\control\actions;

use Yii;
use yii\base\Action;
use yii\web\Response;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use yii\base\InvalidConfigException;

class ToggleActivityAction extends Action
{
    /**
     * @var string|ActiveRecord Класс модели
     */
    public $modelClass;
    /**
     * @var string Атрибут активности
     */
    public $attribute = 'is_active';
    /**
     * @var string|array|null Дефолтный роут возвращения обратно
     */
    public $defaultBackUrl = null;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (empty($this->modelClass) || !class_exists($this->modelClass)) {
            throw new InvalidConfigException('Некорректно настроен класс модели.');
        }
        if (empty($this->attribute)) {
            throw new InvalidConfigException('Требуется указать атрибут активности.');
        }
        $this->controller->enableCsrfValidation = false;
    }

    /**
     * Действие смены активности объекта
     *
     * @param integer $id
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function run($id)
    {
        if ($model = $this->findModel($id)) {
            $model->updateAttributes([$this->attribute => !$model->{$this->attribute}]);
            $model->trigger(ActiveRecord::EVENT_AFTER_UPDATE);
        }
        // Ответ для ajax запроса
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['success' => true];
        }
        // Возвращение на предыдущую позицию
        return $this->controller->goBack($this->defaultBackUrl);
    }

    /**
     * Поиск модели для смены активности
     *
     * @param integer $id
     * @return ActiveRecord
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $modelClass = $this->modelClass;
        if ($model = $modelClass::findOne($id)) {
            return $model;
        }
        throw new NotFoundHttpException('Не удалось найти объект.');
    }
}
