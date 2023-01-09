<?php

namespace common\modules\control\actions;

use chulakov\filestorage\models\Image;
use Yii;
use yii\base\Action;
use yii\web\NotFoundHttpException;

class ImageDeleteAction extends Action
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
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function run()
    {
        $key = Yii::$app->request->post('key');

        $image = Image::findOne($key);

        if ($image) {
            $image->delete();
            return $this->controller->asJson([]);
        }

        throw new NotFoundHttpException('Изображение не найдено');
    }
}
