<?php

namespace common\modules\category\models;

use chulakov\filestorage\models\Image;
use common\helpers\MediaAssetDb;
use common\models\MediaAsset;
use common\modules\category\models\SubCategory;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id
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
 * @property Image $icon
 * @property SubCategory[] $categories
 */
class Category extends \yii\db\ActiveRecord
{
    const ICON_GROUP = 'category-icon';
    const SOURCE_TABLE = 'category';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    public function fields()
    {
        return [
            'id',
            'icon' => function (Category $category) {
                $image = $category->icon;
                return "https://api.spector77.uz/storage/web/upload/$image";
            },
            'title',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\category\models\scopes\CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\category\models\scopes\CategoryQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'slug'], 'required'],
            [['is_active'], 'boolean'],
            [['title'], 'string', 'max' => 128],
            [['slug'], 'string', 'max' => 164],
            [['slug'], 'unique'],
            [['description'], 'string'],
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
            'icon' => 'Иконка',
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
            BlameableBehavior::class
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIcon()
    {
        return $this->hasOne(Image::class, ['object_id' => 'id'])->where(['group_code' => static::ICON_GROUP]);
    }

    public function getImage()
    {
        return $this->hasOne(MediaAsset::class, ['object_id' => 'id'])->where(['source_table' => static::SOURCE_TABLE]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(SubCategory::class, ['category_id' => 'id']);
    }

    /**
     * Получить отформатированную дату создания
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getCreatedAt()
    {
        return \Yii::$app->formatter->asDate($this->created_at, 'php:d.m.Y H:i');
    }

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function afterDelete()
    {
        parent::afterDelete();
        if ($icon = $this->icon) {
            $icon->delete();
        }
    }
}