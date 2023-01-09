<?php

namespace common\modules\publication\actions;

use Yii;
use common\modules\auth\services\AuthService;
use yii\web\Controller;
use yii\base\Action;


class TestAction extends Action
{
    private $authService;

    public function __construct($id,Controller $controller, AuthService $service,  $config = [])
    {
        $this->authService = $service;
        parent::__construct($id, $controller, $config);
    }


    public function run()
    {

        return 200;
    }
}
