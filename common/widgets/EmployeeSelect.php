<?php

namespace common\widgets;

use common\widgets\select2\Select2Sortable;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;

class EmployeeSelect extends Select2Sortable
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->theme = Select2::THEME_DEFAULT;
        $this->showToggleAll = false;
        $this->buttons = [
            'edit' => [
                'baseUrl' => '/about/management-employee/update',
                'icon' => 'fa fa-pencil',
                'linkOptions' => ['target' => '_blank'],
                'urlParam' => 'id'
            ],
        ];
        $this->options = [
            'placeholder' => 'Выберите документы...',
            'multiple' => true,
        ];

        $this->pluginOptions = [
            'minimumInputLength' => 1,
            'allowClear' => false,
            // Для отключения эскейпа
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'ajax' => [
                'url' => Url::to(['/about/management-employee/list']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return { full_name: params.term }; }')
            ]
        ];

        parent::init();
    }
}