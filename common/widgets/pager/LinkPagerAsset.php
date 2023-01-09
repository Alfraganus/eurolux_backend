<?php

namespace common\widgets\pager;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class LinkPagerAsset extends AssetBundle
{
    public $js = [
        'js/pager.js'
    ];

    public $css = [
        'css/pager.css'
    ];

    public $depends = [
        JqueryAsset::class
    ];

    public function init()
    {
        // Base path of current widget
        $this->sourcePath = __DIR__ . "/assets";
        parent::init();
    }
}
