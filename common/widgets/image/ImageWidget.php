<?php
/**
 * Файл виджета  ImageWidget
 *
 * @copyright Copyright (c) 2017, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\widgets\image;

use Yii;
use yii\base\Widget;
use yii\base\InvalidConfigException;

/**
 * Класс виджета загрузки изображений
 */
class ImageWidget extends Widget
{
    const DEFAULT_COLUMN_SIZE = 2;
    const DEFAULT_IMAGE_SIZE = 150;

    /**
     * Модели
     * @var mixed
     */
    public $models;

    /**
     * Заголовок
     *
     * @var string
     */
    public $title;

    /**
     * Текст для кнопки
     *
     * @var string
     */
    public $buttonText;

    /**
     * Название атрибута изображения
     *
     * @var string
     */
    public $imageAttribute;

    /**
     * Название текстового поля
     *
     * @var string
     */
    public $textAttribute;

    /**
     * Размер колонки
     *
     * @var integer
     */
    public $imageColumnSize;

    /**
     * Высота изображения
     *
     * @var integer
     */
    public $imageHeight;

    /**
     * Ширина изображения
     *
     * @var integer
     */
    public $imageWidth;

    /**
     * Url создания модели
     * @var string
     */
    public $createUrl;

    /**
     * Url обновления модели
     *
     * @var string
     */
    public $updateUrl;

    /**
     * Url удаления модели
     *
     * @var string
     */
    public $deleteUrl;

    /**
     * Название контроллера
     */
    public $controllerUrl;

    /**
     * Класс для кнопки
     *
     * @var string
     */
    public $btnClass;

    /**
     * Ширина кнопки
     *
     * @var string
     */
    public $btnWidth;

    /**
     * Инициализация
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (!$this->controllerUrl) {
            throw new InvalidConfigException('Необходимо задать Url контроллера');
        }
        if (!$this->title) {
            $this->title = 'Изображение';
        }
        if (!$this->buttonText) {
            $this->buttonText = 'Добавить';
        }
        if (!$this->imageColumnSize) {
            $this->imageColumnSize = static::DEFAULT_COLUMN_SIZE;
        }
        if (!$this->imageHeight) {
            $this->imageHeight = static::DEFAULT_IMAGE_SIZE;
        }
        if (!$this->createUrl) {
            $this->createUrl = $this->controllerUrl . '/create';
        }
        if (!$this->updateUrl) {
            $this->updateUrl = $this->controllerUrl . '/update';
        }
        if (!$this->deleteUrl) {
            $this->deleteUrl = $this->controllerUrl . '/delete';
        }
        if (!$this->btnClass) {
            $this->btnClass = 'btn btn-primary';
        }
        if (!$this->btnWidth) {
            $this->btnWidth = 100;
        }
        Yii::$app->i18n->translations['OlegChulakovStudio/widgets/image*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'ru',
            'basePath' => __DIR__ . '/messages',
            'fileMap' => [
                'OlegChulakovStudio/widgets/image/index' => 'index.php',
            ]
        ];

        $this->registerAssets();
    }

    /**
     * Выводит форму
     */
    public function run()
    {
        echo $this->formView();
    }

    /**
     * Формирует визуальное представление
     * @return mixed
     */
    private function formView()
    {
        return $this->render('index', [
            'models' => $this->models,
            'imageAttribute' => $this->imageAttribute,
            'createUrl' => $this->createUrl,
            'updateUrl' => $this->updateUrl,
            'deleteUrl' => $this->deleteUrl,
            'imageColumnSize' => $this->imageColumnSize,
            'imageHeight' => $this->imageHeight,
            'title' => $this->title,
            'buttonText' => $this->buttonText,
            'textAttribute' => $this->textAttribute,
            'btnClass' => $this->btnClass,
            'btnWidth' => $this->btnWidth,
        ]);
    }

    /**
     * Регистрирует ImageAsset с view
     */
    private function registerAssets()
    {
        ImageAsset::register($this->getView());
    }
}