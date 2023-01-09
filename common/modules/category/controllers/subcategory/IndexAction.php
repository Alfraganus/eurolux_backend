<?php

namespace common\modules\category\controllers\subcategory;

use common\modules\category\models\Category;
use common\modules\category\models\search\SubCategorySearch;
use yii\base\Action;

class IndexAction extends Action
{
    /**
     * @var string Шаблон
     */
    public $layout;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!empty($this->layout)) {
            $this->controller->layout = $this->layout;
        }
    }

    /**
     * @param $category_id
     * @return string
     * @throws \common\solutions\exceptions\NotFoundModelException
     */
    public function run($category_id)
    {

        $category = Category::findOne($category_id);

        $searchModel = new SubCategorySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->controller->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'category' => $category,
        ]);
    }
}