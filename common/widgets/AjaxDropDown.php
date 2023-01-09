<?php

namespace common\widgets;

use kartik\select2\Select2;
use yii\web\JsExpression;

class AjaxDropDown extends Select2
{
    /** @var string */
    public $url = '';

    /** @var string */
    public $placeholder;

    /** @var bool */
    public $multiple = true;

    /**
     * @throws \ReflectionException
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if ($this->placeholder) {
            $this->options = array_merge(['placeholder' => $this->placeholder], $this->options);
        }

        if (!$this->theme) {
            $this->theme = Select2::THEME_DEFAULT;
        }

        if (empty($this->pluginOptions)) {
            $this->pluginOptions = $this->getPluginOptions();
        }
    }

    /**
     * @return array
     */
    protected function getPluginOptions(): array
    {
        return [
            'allowClear' => true,
            'closeOnSelect' => true,
            'multiple' => $this->multiple,
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'ajax' => [
                'url' => $this->url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return { term: params.term }; }')
            ]
        ];
    }
}
