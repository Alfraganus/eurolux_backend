<?php

namespace common\solutions\widgets;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use yii\base\InvalidConfigException;
use common\solutions\widgets\assets\SlugInputAsset;

class SlugInput extends InputWidget
{
    /**
     * @var string Уникальный идентификатор поля из которого брать значение
     */
    public $targetId;
    /**
     * @var string Атрибут модели для генерации уникального идентификатора по умолчанию
     */
    public $targetAttribute;
    /**
     * @var array Дефолтные настройки поля
     */
    public $options = [
        'class' => 'form-control',
    ];
    /**
     * Опции плагина:
     * - separator: Выбор символа разделитея слов
     * - disabled: Возможможность заблокировать поле вводе URL метки
     *
     * @var array
     */
    public $pluginOptions = [];

    /**
     * Проверка настроек виджета
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (empty($this->targetAttribute) && empty($this->targetId)) {
            throw new InvalidConfigException();
        }
        if (empty($this->targetId)) {
            $this->targetId = Html::getInputId($this->model,  $this->targetAttribute);
        }
        parent::init();
    }

    /**
     * Отрисовка виджета
     *
     * @return string
     */
    public function run()
    {
        $this->registerClientScript();
        return $this->renderInputHtml('text');
    }

    /**
     * Регистрация клиентского скрипта
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        SlugInputAsset::register($view);

        $options = $this->pluginOptions;
        $options['targetId'] = $this->targetId;
        $options = Json::encode($options);

        $view->registerJs(
            "$('#{$this->options['id']}').chSlugInput({$options});",
            $view::POS_READY
        );
    }
}
