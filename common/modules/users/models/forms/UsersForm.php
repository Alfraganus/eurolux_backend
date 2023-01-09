<?php
namespace common\modules\users\models\forms;

use common\modules\users\models\Users;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;

/**
 * Users form
 */
class UsersForm extends Model
{
//    public $id;
    public $is_active = true;
    public $name;
    public $phone;

    /**
     * @var Users
     */
    protected $model;

    /**
     * @param Users $model
     * @param array $config
     */
    public function __construct(Users $model = null, $config = [])
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
                'name', 'phone', 'is_active'
            ]));
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone'], 'string'],
            ['is_active', 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'is_active' => 'Активность',
            'phone' => 'Телефон',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'created_by' => 'Создано',
            'updated_by' => 'Обновлено',
        ];
    }

    /**
     * @return Users
     */
    public function getModel()
    {
        return $this->model;
    }
}
