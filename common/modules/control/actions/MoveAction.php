<?php
/**
 * Файл класса MoveAction
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
use common\modules\control\models\enums\Move;

class MoveAction extends Action
{
    /**
     * @var string Позиция смещения
     */
    public $direction;
    /**
     * @var string|ActiveRecord Класс модели
     */
    public $modelClass;
    /**
     * @var string Атрибут сортировки
     */
    public $attribute = 'sort';
    /**
     * @var array|callable Фильтр для выбора участников сортировки
     */
    public $filter;
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
        if (empty($this->direction) || !in_array($this->direction, Move::getRanges())) {
            throw new InvalidConfigException('Некорректно настроена позиция смещения.');
        }
        if (empty($this->modelClass) || !class_exists($this->modelClass)) {
            throw new InvalidConfigException('Некорректно настроен класс модели.');
        }
        if (empty($this->attribute)) {
            throw new InvalidConfigException('Требуется указать атрибут сортировки.');
        }
        $this->controller->enableCsrfValidation = false;
    }

    /**
     * Действие смены позиции объекта
     *
     * @param integer $id
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function run($id)
    {
        // Поиск модели для смены позиции
        $model = $this->findModel($id);
        $modelPosition = $model->{$this->attribute};
        // Поиск модели с позицией в которую переходит основная модель
        if ($swapModel = $this->findSwapModel($model, $modelPosition)) {
            $swapPosition = $swapModel->{$this->attribute};
            // Смена позиции для двух записей
            $model->updateAttributes([$this->attribute => $swapPosition]);
            $swapModel->updateAttributes([$this->attribute => $modelPosition]);
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
     * Поиск модели для смены позиции
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

    /**
     * Поиск модели следующей по сортировке
     *
     * @param ActiveRecord $model
     * @param integer $position
     * @return ActiveRecord|null
     */
    protected function findSwapModel($model, $position)
    {
        $modelClass = $this->modelClass;
        $whereClause = $this->direction == Move::UP ? '<' : '>';
        $orderClause = $this->direction == Move::UP ? SORT_DESC : SORT_ASC;
        $query = $modelClass::find()
            ->andWhere([$whereClause, $this->attribute, $position])
            ->orderBy([$this->attribute => $orderClause]);
        if ($this->filter) {
            if ($this->filter instanceof \Closure) {
                call_user_func($this->filter, $query, $model, $position);
            } else {
                $query->andWhere($this->filter);
            }
        }
        return $query->limit(1)->one();
    }
}
