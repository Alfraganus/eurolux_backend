<?php
/**
 * Файл класса ToogleAsset.php
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\widgets\toggle;

use yii\web\AssetBundle;

class ToggleInputAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@common/widgets/toggle/assets';

    /**
     * @var array
     */
    public $css = [
        'css/toogle-input.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'js/toogle-input.js'
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}