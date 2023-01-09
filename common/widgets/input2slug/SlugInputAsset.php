<?php

namespace common\widgets\input2slug;

use yii\web\AssetBundle;

/**
 * Бандл для виджета [[SlugInput]]
 */
class SlugInputAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $js = [
        'js/script.js'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets';
    }
}
