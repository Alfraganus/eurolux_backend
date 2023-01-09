<?php

namespace common\modules\category\models;

use chulakov\filestorage\models\Image;
use common\modules\category\models\scopes\SubCategoryQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Модель для работы с подкатегориями
 *
 * @property int $id
 * @property int $category_id
 * @property string $slug Символьный код
 * @property string $title Наименование
 * @property string $description Краткое описание
 * @property int $is_active Активность
 *
 * @property int $created_at Дата создания
 * @property int $updated_at Дата обновления
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Category $category
 */
class SubCategory extends ActiveRecord
{
    const STATUS_ACTIVE = true;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sub_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'description', 'slug'], 'required'],
            [['category_id'], 'integer'],
            [['is_active'], 'boolean'],
            [['title'], 'string', 'max' => 128],
            [['slug'], 'string', 'max' => 164],
            [['slug'], 'unique'],
            [['description'], 'string'],
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
            'createdAt' => 'Дата создания',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'created_by' => 'Создано',
            'updated_by' => 'Обновлено',
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Получить отформатированную дату создания
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getCreatedAt()
    {
        return Yii::$app->formatter->asDate($this->created_at, 'php:d.m.Y H:i');
    }
}
