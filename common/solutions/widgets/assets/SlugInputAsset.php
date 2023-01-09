<?php

namespace common\solutions\widgets\assets;

use yii\web\AssetBundle;

class SlugInputAsset extends AssetBundle
{
    public $sourcePath = '@common/solutions/widgets/assets/slug-input';
    public $js = [
        'slug-input.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
