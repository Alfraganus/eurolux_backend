<?php

namespace common\modules\category\forms;

use common\modules\category\models\Category;
use common\modules\category\models\SubCategory;
use yii\base\Model;

class SubCategoryForm extends Model
{
    /**
     * @var int
     */
    public $category_id;
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
     * @var SubCategory
     */
    protected $model;

    /**
     * Конструктор с зависимостью
     *
     * @param Category $model
     * @param array $config
     */
    public function __construct(SubCategory $model = null, $config = [])
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
                'category_id',
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
    public function behaviors()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'description', 'slug'], 'required'],
            [['is_active'], 'boolean'],
            [['slug'], 'string', 'max' => 164],
            [['title'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 1024],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
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