<?php

namespace common\widgets\pager;

use sem\helpers\Html;
use yii\helpers\Url;

/**
 * Class LinkPager
 * @package common\widgets\pager
 */
class LinkPager extends \yii\widgets\LinkPager
{
    /**
     * @var string
     */
    public $layout = '{pageButtons}{pageSizeList}';

    /**
     * @var int
     */
    public $step = 20;

    /**
     * @var int
     */
    public $pageSizeListSize = 4;

    /**
     * @var string
     */
    public $pageSizeParam = 'per-page';

    /**
     * @var string[]
     */
    public $wrapperOptions = ['class' => 'link-pager'];

    /**
     * @var string[]
     */
    public $dropdownOptions = ['class' => 'page-size-dropdown'];

    public $pageSizeListLabel = 'Отображать по';

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return string|void
     */
    public function run()
    {
        LinkPagerAsset::register($this->getView());

        return Html::tag('div', preg_replace_callback("/{(\\w+)}/", function ($matches) {
                $sectionName = $matches[1];
                $content = $this->renderSection($sectionName);

                return $content === false ? $matches[1] : $content;
            }, $this->layout), $this->wrapperOptions);

    }

    /**
     * @param $name
     * @return mixed
     */
    public function renderSection($name)
    {
        $function = 'render' . $name;
        return $this->{$function}();
    }

    /**
     * @return string
     */
    public function renderPageSizeList()
    {
        if ($this->pagination->getPageCount() < 2) {
            return '';
        }

        $pageSizeList = [];
        for ($i = 0; $i < $this->pageSizeListSize; $i++) {
            $pageSize = $this->pagination->defaultPageSize + $i * $this->step;
            $pageSizeList[Url::current([$this->pageSizeParam => $pageSize])] = $pageSize;
        }


        $render = Html::label($this->pageSizeListLabel);
        $render .= Html::dropDownList(
            $this->pageSizeParam,
            Url::current(),
            $pageSizeList,
            $this->dropdownOptions
        );

        return Html::tag('div', $render, $this->dropdownOptions);
    }
}
