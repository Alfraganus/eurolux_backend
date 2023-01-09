<?php
/**
 * Файл класса Select2SortableAsset
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\widgets\select2;

use yii\web\AssetBundle;

class Select2SortableAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/select2/assets';

    public $js = [
        'js/sortable.js',
    ];

    public $css = [
        'css/sortable.css',
    ];

    public $depends = [
        'common\modules\control\assets\JqueryUIAsset',
    ];
}
