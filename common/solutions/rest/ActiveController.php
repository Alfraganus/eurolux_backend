<?php

namespace common\solutions\rest;

use yii\base\Model;
use common\solutions\services\CrudService;
use common\solutions\models\search\SearchModel;
use common\solutions\models\provider\ProviderInterface;

class ActiveController extends Controller
{
    /**
     * @var CrudService
     */
    public $service;
    /**
     * @var SearchModel
     */
    public $searchClass;
    /**
     * @var Model
     */
    public $createFormClass;
    /**
     * @var Model
     */
    public $updateFormClass;
    /**
     * @var ProviderInterface
     */
    public $providerClass;
    /**
     * @var bool Передавать ли данные о модели в качестве результата выполнения
     */
    public $needModelResult = false;
    /**
     * @var bool Возможность перобразования модели в массив при отсутствии провайдера
     */
    public $needModelConvert = true;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => 'solutions\rest\IndexAction',
                'searchClass' => $this->searchClass,
                'providerClass' => $this->providerClass,
            ],
            'view' => [
                'class' => 'solutions\rest\ViewAction',
                'service' => $this->service,
                'providerClass' => $this->providerClass,
                'needModelConvert' => $this->needModelConvert,
            ],
            'create' => [
                'class' => 'solutions\rest\CreateAction',
                'service' => $this->service,
                'formClass' => $this->createFormClass,
                'providerClass' => $this->providerClass,
                'needModelResult' => $this->needModelResult,
            ],
            'update' => [
                'class' => 'solutions\rest\UpdateAction',
                'service' => $this->service,
                'formClass' => $this->updateFormClass,
                'providerClass' => $this->providerClass,
                'needModelResult' => $this->needModelResult,
            ],
            'delete' => [
                'class' => 'solutions\rest\DeleteAction',
                'service' => $this->service,
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }

    /**
     * Список правил доступа к экшенам контроллера.
     *
     * @return AccessRule[]
     */
    public function accessRules()
    {
        return [
            'index'   => $this->createAccess('get', true, '@'),
            'view'    => $this->createAccess('get', true, '@'),
            'create'  => $this->createAccess('post', true, '@'),
            'update'  => $this->createAccess('put, patch', true, '@'),
            'delete'  => $this->createAccess('delete', true, '@'),
            'options' => $this->createAccess(),
        ];
    }
}