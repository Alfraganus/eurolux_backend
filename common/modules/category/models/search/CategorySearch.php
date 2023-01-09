<?php

namespace common\modules\category\models\search;

use common\modules\category\models\Category;
use common\solutions\models\search\SearchForm;
use yii\db\ActiveQuery;

/**
 * Модель поиска
 */
class CategorySearch extends SearchForm
{
    /**
     * @var integer
     */
    public $is_active;

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
            [['is_active'], 'integer'],
            [['title'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
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
        $query->andFilterWhere([
            'is_active' => $this->is_active,
        ]);

        if ($this->title) {
            $query->innerJoinWith(['eventTranslations' => function (ActiveQuery $query) {
                return $query->andFilterWhere(['like', 'title', $this->title]);
            }], false);
        }
    }

    /**
     * @return \common\modules\category\models\scopes\CategoryQuery|\yii\db\ActiveQuery
     */
    protected function buildQuery()
    {
        return Category::find()->with('icon');
    }
}
