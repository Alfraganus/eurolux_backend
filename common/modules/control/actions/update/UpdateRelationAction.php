<?php

namespace common\modules\control\actions\update;

use solutions\exceptions\NotFoundModelException;
use solutions\models\repositories\CrudRepository;
use yii\db\ActiveRecord;
use yii\di\Instance;
use Yii;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;

class UpdateRelationAction extends BaseUpdateAction
{
    /**
     * @var string|CrudRepository
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
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (!empty($this->layout)) {
            $this->controller->layout = $this->layout;
        }
        if (!empty($this->service)) {
            $this->service = Instance::ensure($this->service);
        }
        if (!empty($this->parentRepository)) {
            $this->parentRepository = Instance::ensure($this->parentRepository);
        }
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function run($id)
    {
        try {
            $model = $this->findModel($id);
            $parent = $this->parentRepository->get($model->{$this->parentRelationAttribute});
        } catch (NotFoundModelException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        $form = $this->createForm($parent, $model);
        $form->{$this->parentRelationAttribute} = $parent->id;

        if ($form->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                return $this->controller->asJson(ActiveForm::validate($form));
            }
            if ($form->validate() && $this->service->update($model, $form)) {
                return $this->controller->goBack([$this->defaultReturnUrl]);
            }
        }

        return $this->controller->render($this->view, [
            'model' => $form,
            $this->parentRelationName => $parent
        ]);
    }

    /**
     * @param ActiveRecord $parent
     * @param ActiveRecord $model
     * @return mixed
     */
    protected function createForm($parent, $model)
    {
        return new $this->formClass($model);
    }
}
