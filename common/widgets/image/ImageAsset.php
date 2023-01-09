<?php


namespace common\widgets\image;

use yii\web\AssetBundle;

class ImageAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/image/assets';

    public $css = [
        'css/style.css'
    ];

    public $js = [
        'js/script.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}