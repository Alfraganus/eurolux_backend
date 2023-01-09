<?php

namespace common\modules\control\actions;

use common\modules\category\models\Category;
use Yii;
use yii\base\Action;

/**
 * Class IndexAction
 * @package common\modules\control\actions
 */
class IndexAction extends Action
{
    /**
     * @var string
     */
    public $searchModelClass;

    /**
     * @var string
     */
    public $view = 'index';

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
     * @return string
     */
    public function run()
    {
        $searchModel = new $this->searchModelClass;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->controller->render($this->view, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
