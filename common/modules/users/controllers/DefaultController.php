<?php

namespace common\modules\users\controllers;

use Yii;
use yii\base\Action;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\modules\control\actions\create\CreateAction;
use common\modules\control\actions\DeleteAction;
use common\modules\control\actions\IndexAction;
use common\modules\control\actions\update\UpdateAction;
use common\modules\users\models\Users;
use common\modules\users\models\forms\UsersForm;
use common\modules\users\models\search\UsersSearch;
use common\modules\users\services\UsersService;
use chulakov\base\AccessRule;

/**
 * Default controller for the `user` module
 */
class DefaultController extends Controller
{
    /**
     * @return bool|string
     */
    public function getViewPath()
    {
        return Yii::getAlias('@common/modules/users/views/default');
    }

    /**
     * Список правил доступа к экшенам контроллера.
     *
     * @return AccessRule[]
     */
    public function accessRules()
    {
        return [
            'index' => $this->createAccess('get', true, '@'),
            'create' => $this->createAccess('get, post', true, '@'),
            'update' => $this->createAccess('get, post', true, '@'),
            'delete' => $this->createAccess('post', true, '@'),
            'logout'  => $this->createAccess('post', true, '@'),
            'signup'  => $this->createAccess('get, post', true, '?'),
            'login'   => $this->createAccess('get, post', true),
            'reset'   => $this->createAccess('get, post', true),
            'request' => $this->createAccess('get, post', true),
            'password' => $this->createAccess('get, post', true, '@'),
        ];
    }

    /**
     * Фильтрация перед вызовом действия
     *
     * @param Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function beforeAction($action)
    {
        if (!isset($this->module->controllerMap[$action->controller->id])) {
            throw new NotFoundHttpException();
        }
        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        if ($action->id == 'index') {
            \Yii::$app->user->setReturnUrl(\Yii::$app->request->url);
        }
        return parent::afterAction($action, $result);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::class,
                'searchModelClass' => UsersSearch::class,
            ],
            'update' => [
                'class' => UpdateAction::class,
                'service' => UsersService::class,
                'formClass' => UsersForm::class,
            ],
            'create' => [
                'class' => CreateAction::class,
                'service' => UsersService::class,
                'formClass' => UsersForm::class,
            ],
            'delete' => [
                'class' => DeleteAction::class,
                'service' => UsersService::class,
                'modelClass' => Users::class
            ],
            'logout'  => __NAMESPACE__ . '\\actions\\LogoutAction',
            'signup'  => __NAMESPACE__ . '\\actions\\SignupAction',
            'login'   => __NAMESPACE__ . '\\actions\\LoginAction',
            'reset'   => __NAMESPACE__ . '\\actions\\ResetPasswordAction',
            'request' => __NAMESPACE__ . '\\actions\\RequestResetPasswordAction',
            'password' => __NAMESPACE__ . '\\actions\\PasswordAction',
        ];
    }
//    /**
//     * Renders the index view for the module
//     * @return string
//     */
//    public function actionIndex()
//    {
//        $searchModel = new UsersSearch;
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }
//
//    public function actionUpdate($id=null)
//    {
//        if ($id === null) {
//            $model = new Users();
//        } else {
//            $model = Users::findOne(['id' => $id]);
//        }
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['index']);
//        }
//        return $this->render('update', ['model' => $model]);
//    }
//
//    public function actionDelete($id)
//    {
//        Users::findOne(['id' => $id])->delete();
//        return $this->redirect(['index']);
//    }
}
