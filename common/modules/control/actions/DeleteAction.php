<?php

namespace common\modules\control\actions;

use common\models\S3Manager;
use common\modules\category\services\CategoryService;
use Yii;
use yii\base\Action;
use yii\di\Instance;
use yii\web\Response;
use yii\db\ActiveRecord;
use yii\web\BadRequestHttpException;

class DeleteAction extends Action
{
    /**
     * @var string|ActiveRecord Класс модели
     */
    public $modelClass;
    /**
     * @var object Любой объект, имеющий метод удаления по id (Сервис или Репозиторий)
     */
    public $service;
    /**
     * @var string|array|null Дефолтный роут возвращения обратно
     */
    public $defaultBackUrl = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->controller->enableCsrfValidation = false;
        if (!empty($this->service)) {
            $this->service = Instance::ensure($this->service);
        }
    }

    /**
     * Предворительное форматирование ответа
     *
     * @return bool
     */
    protected function beforeRun()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
        }
        return parent::beforeRun();
    }

    /**
     * Действие удаление модели
     *
     * @param integer $id
     * @return array|Response
     * @throws BadRequestHttpException
     */
    public function run($id)
    {

        // Поиск и удаление объекта
        $e = null;
        $result = false;
        if ($model = $this->findDelete($id)) {
            try {
                Yii::createObject(S3Manager::class)
                    ->deleteFromS3(
                        'category',$id,CategoryService::S3_BUCKET_NAME
                    );
                if ($model instanceof ActiveRecord) {
                    $result = $model->delete();
                } else {
                    $result = $model->delete($id);
                }

            }

            catch (\Exception $e) { Yii::error($e); }
            catch (\Throwable $e) { Yii::error($e); }
        }
        // Проверка наличия ошибки
        if (!empty($e)) {
            throw new BadRequestHttpException($e->getMessage(), 0, $e);
        }
        // Ответ для ajax запроса
        if (Yii::$app->request->isAjax) {
            return ['success' => !!$result];
        }
        // Возвращение на предыдущую позицию
        return $this->controller->goBack($this->defaultBackUrl);
    }

    /**
     * Поиск объекта имеющего возможность удаления
     *
     * @param integer $id
     * @return null|object|ActiveRecord
     */
    protected function findDelete($id)
    {
        // Поиск метода удаления в "сервисе"
        if (is_object($this->service) && method_exists($this->service, 'delete')) {
            return $this->service;
        }
        // Поиск непосредственно модели для удаления напрямую
        if ($modelClass = $this->modelClass) {
            return $modelClass::findOne($id);
        }
        return null;
    }
}
