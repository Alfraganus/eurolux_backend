<?php

namespace common\modules\category\forms;

use chulakov\filestorage\models\Image;
use chulakov\filestorage\uploaders\UploadInterface;
use chulakov\filestorage\validators\FileValidator;
use common\modules\category\models\Category;
use common\solutions\behaviors\FileOwnerBehavior;
use Yii;
use yii\base\Model;


class CategoryForm extends Model
{
    /**
     * @var string
     */
    public $slug;
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $description;
    /**
     * @var boolean
     */
    public $is_active = true;
    /**
     * @var Image
     */
    public $icon;
    /**
     * @var UploadInterface
     */
    public $iconFile;

    /**
     * @var Category
     */
    protected $model;

    /**
     * Конструктор с зависимостью
     *
     * @param Category $model
     * @param array $config
     */
    public function __construct(Category $model = null, $config = [])
    {
        $this->model = $model;
        parent::__construct($config);
    }

    /**
     * Инициализация
     */
    public function init()
    {
        parent::init();
        $this->fill();
    }

    /**
     * Заполнение полей формы данными из модели
     */
    protected function fill()
    {
        if ($this->model) {
            $this->setAttributes($this->model->getAttributes([
                'slug',
                'title',
                'description',
                'is_active',
            ]));
        }
    }

    /**
     * @inheritdoc
     */


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'slug'], 'required'],
            [['is_active'], 'boolean'],
            [['slug'], 'string', 'max' => 164],
            [['title'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 1024],
            [['iconFile'], 'file'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Символьный код',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'is_active' => 'Активность',
            'iconFile' => 'Иконка',
        ];
    }

    /**
     * @return array
     */
    public function attributeHints()
    {
        return [
            'title' => 'Максимальная длина 128 символов',
            'description' => 'Максимальная длина 512 символов',
            'iconFile' => 'Рекомендуемый размер 60x60px, в формате svg, jpeg и webp',
        ];
    }

    /**
     * @return Category
     */
    public function getModel()
    {
        return $this->model;
    }
}