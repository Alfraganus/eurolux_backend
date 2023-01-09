<?php
namespace api\controllers;

use chulakov\web\Controller;
use chulakov\base\AccessRule;

/**
 * Dev controller
 *
 * @OA\Info(
 *     description="API Time to exchange",
 *     version="1.0.0",
 *     title="Time to exchange API",
 * )
 */
class DevController extends Controller
{
    /**
     * Список правил доступа к экшенам контроллера.
     *
     * @return AccessRule[]
     */
    public function accessRules()
    {
        return [];
    }
}
