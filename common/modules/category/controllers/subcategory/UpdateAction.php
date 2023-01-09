<?php

namespace common\modules\category\controllers\subcategory;

use common\modules\category\forms\SubCategoryForm;
use common\modules\category\models\SubCategory;
use common\modules\category\services\SubCategoryService;
use common\solutions\exceptions\NotFoundModelException;
use Yii;
use yii\base\Action;
use yii\base\Controller;
use yii\web\NotFoundHttpException;

class UpdateAction extends Action
{
    /**
     * @var string Шаблон
     */
    public $layout;

    /**
     * @var SubCategoryService
     */
    protected $service;

    /**
     * @inheritdoc
     */
    public function __construct($id, Controller $controller, SubCategoryService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $controller, $config);
    }

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
     * @param integer $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function run($id)
    {
        try {
            /** @var SubCategory $model */
            $model = $this->service->find($id);
        } catch (NotFoundModelException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        $form = new SubCategoryForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            if ($this->service->update($model, $form)) {
                return $this->controller->redirect(['index', 'category_id' => $model->category_id]);
            }
        }

        return $this->controller->render('update', [
            'model' => $form
        ]);
    }
}
