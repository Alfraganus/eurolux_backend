<?php
/**
 * Файл класса ToggleInputWidget.php
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\widgets\toggle;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\InputWidget;

/**
 * Реализует логику работы виджета-переключателя взамен некрасивого чекбокса.
 * При смене состояния происходит AJAX-запрос по URL-адресу, полученному из [[updateRoute]].
 * Пример конфигурации для поля изменения активности:
 * ```php
 *      <?= GridView::widget([
 *          'dataProvider' => $dataProvider,
 *          'columns' => [
 *              ...
 *              [
 *                  'attribute' => 'is_active',
 *                  'format' => 'raw',
 *                  'value' => function (Document $model) {
 *                      return \common\widgets\toggle\ToggleInputWidget::widget([
 *                              'model' => $model,
 *                              'attribute' => 'is_active',
 *                              'updateRoute' => ['active', 'id' => $model->id]
 *                      ]);
 *                  }
 *              ],
 *              ...
 *      ]); ?>
 * ```
 * @todo реализовать DataColumn для GridView
 */
class ToggleInputWidget extends InputWidget
{

    /**
     * @var string
     */
    public $updateRoute;

    /**
     * {@inheritdoc}
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (!$this->updateRoute) {
            throw new InvalidConfigException("Роут для обновления состояния 'updateRoute' должен быть задан");
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        ToggleInputAsset::register($this->getView());
        return $this->renderInputHtml('checkbox');
    }

    /**
     * @inheritdoc
     */
    public function renderInputHtml($type)
    {
        $options = [];

        if ($this->hasModel()) {
            $options = [
                'checked' => (bool) $this->model->{$this->attribute}
            ];
        }

        $this->options = array_merge($this->options, $options);

        $isChecked = isset($this->options['checked']) && $this->options['checked'];
        $isDisabled = isset($this->options['disabled']) && $this->options['disabled'];

        $checkbox = parent::renderInputHtml($type)  . Html::tag('div', '', [
            'class' => 'toggle',
        ]);

        return Html::tag('div', $checkbox, [
            'class' => 'switch' . ($isDisabled ? ' disable' : ($isChecked ? ' on' : ' off')),
            'data' => [
                'url' => Url::to($this->updateRoute)
            ]
        ]);
    }
}