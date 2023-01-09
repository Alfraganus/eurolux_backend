<?php

namespace common\modules\publication\models;

use common\modules\category\models\Category;
use common\modules\category\models\SubCategory;
use Yii;

/**
 * This is the model class for table "publication_exchange_category".
 *
 * @property int $id
 * @property int $publication_id
 * @property int|null $reaction_type
 * @property int|null $category_id
 * @property int|null $sub_category_id
 *
 * @property Category $category
 * @property Publication $publication
 * @property SubCategory $subCategory
 */
class PublicationExchangeCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'publication_exchange_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['publication_id'], 'required'],
            [['publication_id', 'reaction_type', 'category_id', 'sub_category_id'], 'integer'],
            [['publication_id'], 'exist', 'skipOnError' => true, 'targetClass' => Publication::class, 'targetAttribute' => ['publication_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['sub_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubCategory::class, 'targetAttribute' => ['sub_category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'publication_id' => 'Publication ID',
            'reaction_type' => 'Reaction Type',
            'category_id' => 'Category ID',
            'sub_category_id' => 'Sub Category ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|\common\modules\publication\models\scopes\CategoryQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Publication]].
     *
     * @return \yii\db\ActiveQuery|\common\modules\publication\models\scopes\PublicationQuery
     */
    public function getPublication()
    {
        return $this->hasOne(Publication::class, ['id' => 'publication_id']);
    }

    /**
     * Gets query for [[SubCategory]].
     *
     * @return \yii\db\ActiveQuery|\common\modules\publication\models\scopes\SubCategoryQuery
     */
    public function getSubCategory()
    {
        return $this->hasOne(SubCategory::class, ['id' => 'sub_category_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\publication\models\scopes\PublicationExchangeCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\publication\models\scopes\PublicationExchangeCategoryQuery(get_called_class());
    }
}
