<?php

namespace common\modules\control\actions\create;

use solutions\models\repositories\CrudRepository;
use yii\db\ActiveRecord;
use yii\di\Instance;
use Yii;
use yii\web\BadRequestHttpException;
use yii\widgets\ActiveForm;

class CreateRelationAction extends BaseCreateAction
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
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     * @throws \solutions\exceptions\NotFoundModelException
     */
    public function run()
    {
        if (!$parent_id = Yii::$app->request->get($this->parentRelationAttribute)) {
            throw new BadRequestHttpException('Отсутствует ' . $this->parentRelationAttribute . ' параметр');
        }

        $parent = $this->parentRepository->get($parent_id);

        $form = $this->createForm($parent);
        $form->{$this->parentRelationAttribute} = $parent->id;

        if ($form->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                return $this->controller->asJson(ActiveForm::validate($form));
            }
            if ($form->validate() && $this->service->create($form)) {
                return $this->controller->redirect([$this->defaultReturnUrl, $this->parentRelationAttribute => $parent->id]);
            }
        }

        return $this->controller->render($this->view, [
            'model' => $form,
            $this->parentRelationName => $parent,
        ]);
    }

    /**
     * @param ActiveRecord $parent
     * @return mixed
     */
    protected function createForm($parent)
    {
        return new $this->formClass;
    }
}
