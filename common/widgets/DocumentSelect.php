<?php

namespace common\widgets;

use common\modules\document\helpers\DocumentWidgetHelper;
use common\widgets\select2\Select2Sortable;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;

class DocumentSelect extends Select2Sortable
{
    /**
     * @var array Места расположения документов
     */
    public $documentSections;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!$this->documentSections) {
            throw new \InvalidArgumentException('Необходимо указать параметр documentSections');
        }

        $this->theme = Select2::THEME_DEFAULT;
        $this->buttons = DocumentWidgetHelper::getDocumentButtons();
        $this->showToggleAll = false;
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
                'url' => Url::to(['/document/document/list', 'sections' => $this->documentSections]),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return { service_name: params.term }; }')
            ]
        ];

        parent::init();
    }
}