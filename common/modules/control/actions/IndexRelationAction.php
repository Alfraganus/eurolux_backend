<?php

namespace common\modules\control\actions;

use solutions\models\repositories\CrudRepository;
use yii\base\Action;
use yii\di\Instance;
use Yii;
use yii\web\BadRequestHttpException;

class IndexRelationAction extends IndexAction
{
    /**
     * @var CrudRepository|string
     */
    public $parentRepository;
    /**
     * @var string
     */
    public $parentRelationAttribute;
    /**
     * @var string
     */
    public $parentRelationName;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!empty($this->layout)) {
            $this->controller->layout = $this->layout;
        }
        if (!empty($this->parentRepository)) {
            $this->parentRepository = Instance::ensure($this->parentRepository);
        }
    }

    /**
     * @return string
     * @throws BadRequestHttpException
     * @throws \solutions\exceptions\NotFoundModelException
     */
    public function run()
    {
        if (!$parent_id = Yii::$app->request->get($this->parentRelationAttribute)) {
            throw new BadRequestHttpException('Отсутствует ' . $this->parentRelationAttribute . ' параметр');
        }

        $parent = $this->parentRepository->get($parent_id);
        $searchModel = new $this->searchModelClass;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->controller->render($this->view, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            $this->parentRelationName => $parent
        ]);
    }
}
