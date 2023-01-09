<?php

namespace common\modules\category\controllers\subcategory;

use common\modules\category\forms\SubCategoryForm;
use common\modules\category\services\SubCategoryService;
use Yii;
use yii\base\Action;
use yii\base\Controller;
use yii\web\Response;

class CreateAction extends Action
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
     * Конструктор
     *
     * @param string $id
     * @param Controller $controller
     * @param SubCategoryService $service
     * @param array $config
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
     * Выполнение действия создания подкатегории
     *
     * @param int $category_id
     *
     * @return array|string|Response
     */
    public function run($category_id)
    {
        $form = new SubCategoryForm();
        $form->category_id = $category_id;

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            if ($this->service->create($form)) {
                return $this->controller->redirect(['index', 'category_id' => $category_id]);
            }
        }

        return $this->controller->render('create', [
            'model' => $form,
        ]);
    }
}
