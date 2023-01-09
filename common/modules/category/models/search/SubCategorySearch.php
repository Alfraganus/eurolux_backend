<?php

namespace common\modules\category\models\search;

use common\modules\category\models\SubCategory;
use common\solutions\models\search\SearchForm;
use yii\db\ActiveQuery;

/**
 * Модель поиска
 */
class SubCategorySearch extends SearchForm
{
    /**
     * @var integer
     */
    public $is_active;

    /**
     * @var integer
     */
    public $category_id;

    /**
     * @var string
     */
    public $title;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active', 'category_id'], 'integer'],
            [['title'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Категория',
            'is_active' => 'Активность',
            'title' => 'Заголовок',
        ];
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return '';
    }

    /**
     * Применение фильтров
     *
     * @param ActiveQuery $query
     */
    protected function applyFilter(ActiveQuery $query)
    {
        $query->andFilterWhere(['is_active' => $this->is_active])
            ->andFilterWhere(['category_id' => $this->category_id]);
    }

    /**
     * @return \common\modules\category\models\scopes\SubCategoryQuery|\yii\db\ActiveQuery
     */
    protected function buildQuery()
    {
        return SubCategory::find();
    }
}
