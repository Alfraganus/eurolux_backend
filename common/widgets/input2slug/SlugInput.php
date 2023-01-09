<?php

namespace common\widgets\input2slug;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * Производит транслитерацию вводимого текста в текстовое поле
 * и запись результата транслитерации в указазанное по id поле формы (RU -> EN)
 */
class SlugInput extends InputWidget
{
    /**
     * HTML-идентификатор поля для результата транслитерации
     * @var string
     */
    public $targetId;

    /**
     * Разделитель
     *
     * @var string
     */
    public $separator = '-';
    /**
     * Регулярное выражение для фильтрации символов
     * Удаляются все символы, заданные в регулярном выражении
     *
     * @var string
     */
    public $regexp = '[^a-z0-9_-]';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->targetId)) {
            throw new InvalidConfigException("id поля ввода назначения должно быть указано");
        }

    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerClientScript();

        $this->options['data-slug_target'] = '#' . $this->targetId;

        if ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textInput($this->name, $this->value, $this->options);
        }
    }

    /**
     * Регистрирует необходимые ассеты для включения клиентских скриптов
     */
    public function registerClientScript()
    {
        $js = "$(function () {
	    var isFirst = true;
	    var wasEmpty = false;

	    $(document).on('change blur focus keyup','input[data-slug_target*=\"#\"]',function(e){
            \$input = $(\$(this).attr('data-slug_target'));
            \$input.bind('keyup',function(e){
                wasEmpty = false;
                isFirst = false;
                return true;
            });
    
            if(isFirst){
                isFirst = false;
                if(!\$input.val())
                    wasEmpty = true;
            }
            
            if(wasEmpty){
                var str = slugization($(this).val().trim().toLowerCase(), '{$this->separator}', true);
                var r = new RegExp('{$this->regexp}', 'g');
                str = str.replace(r, '');
                \$input.val(str);
            }
            
            return true;
	    });
	});";
        $view = $this->getView();
        SlugInputAsset::register($view);
        $view->registerJs($js);
    }
}
