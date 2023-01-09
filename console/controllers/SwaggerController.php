<?php

namespace console\controllers;

use chulakov\filestorage\FileStorage;
use OpenApi\Generator;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

class SwaggerController extends Controller
{
    const API_DECLARATION = "@api/controllers";
    const SCAN_DIRECTORY = "@common/modules";
    const COMPONENTS_DIRECTORY = "@common/components";

    private $fileStorage;

    public function __construct($id, $module, FileStorage $fileStorage, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->fileStorage = $fileStorage;
    }

    /**
     * Генерация документации OpenAPI
     * @return int
     */
    public function actionGenerate()
    {
//        print_r(Yii::getAlias(self::API_DECLARATION));
        $docFile = 'api/web/upload/api/swagger.yaml';

        $this->stdout("Начата генерация документации \n");

        $openApi = Generator::scan([
            Yii::getAlias(self::API_DECLARATION),
            Yii::getAlias(self::SCAN_DIRECTORY),
            Yii::getAlias(self::COMPONENTS_DIRECTORY),
        ]);

//        $this->fileStorage->save($docFile, $openApi->toYaml());
        file_put_contents($docFile, $openApi->toYaml());

        $this->stdout("Завершено! \r\n", Console::FG_GREEN);

        return ExitCode::OK;
    }
}
