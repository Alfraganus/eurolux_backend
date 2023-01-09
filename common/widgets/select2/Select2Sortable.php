<?php
/**
 * Файл класса Select2Sortable
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\widgets\select2;

use yii\helpers\Html;
use kartik\select2\Select2;

class Select2Sortable extends Select2
{
    /**
     * @var string Файл шаблона
     */
    public $layout = '@common/widgets/select2/views/sortable';
    public $buttons = [];

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerClientScript();
        echo Html::beginTag('div', [
            'class' => 'sortable-wrapper',
        ]);
        parent::run();
        echo $this->render($this->layout, [
            'elements' => $this->renderElements($this->data),
            'buttons' => $this->renderButtons(),
            'formName' => $this->getFormName(),
        ]);
        echo Html::endTag('div');
    }

    /**
     * Получение элементов
     * @param $data
     * @return array
     */
    protected function renderElements($data)
    {
        $result = [];
        foreach ($data as $key => $value) {
            $buttons = $this->renderButtons($key);

            $result[$key] = [
                'title' => $value,
                'buttons' => $buttons,
            ];
        }

        return $result;
    }

    /**
     * Генерация кнопок
     *
     * @param mixed $key
     * @return array
     */
    protected function renderButtons($key = null)
    {
        $result = [];
        foreach ($this->buttons as $button_id => $button) {
            $result[$button_id] = $this->renderButtonLink($button, $key);
        }
        return $result;
    }

    /**
     * Генерация ссылки для кнопки
     *
     * @param $button
     * @param mixed $paramValue
     * @return string
     */
    protected function renderButtonLink($button, $paramValue = null)
    {
        return Html::a(
            "<span class='{$button["icon"]}'></span>",
            [$button['baseUrl'], $button['urlParam'] => $paramValue ?? ''],
            $button['linkOptions']
        );
    }

    /**
     * Получение имени формы
     *
     * @return string
     */
    protected function getFormName()
    {
        if ($this->hasModel()) {
            $name = Html::getInputName($this->model, $this->attribute);
        } else {
            $name = $this->name;
        }
        if (substr_compare($name, '[]', -2, 2) === 0) {
            $name = mb_substr($name, 0, mb_strlen($name)-2);
        }
        return $name;
    }

    /**
     * Регистрация клиентского скрипта
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        Select2SortableAsset::register($view);

        $view->registerJs(
            "$('#{$this->options['id']}').chSelect2Sortable();",
            $view::POS_READY
        );
    }
}
