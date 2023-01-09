<?php

namespace common\widgets\rss;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\widgets\BaseListView;

class RssView extends BaseListView
{
    /**
     * @var string
     */
    public $feedClass = RssFeed::class;

    /**
     * @var RssFeed
     */
    public $feed;

    /**
     * @var array
     */
    public $channel;

    /**
     * @var array
     */
    public $items;

    /**
     * @var array
     */
    public $requiredChannelElements = ['title', 'link', 'description'];

    /**
     * @var array
     */
    public $requiredItemElements = ['title', 'description', 'link', 'pubDate'];

    /**
     * @var array
     */
    private $channelAttributes = [];

    /**
     * @var array
     */
    private $itemAttributes = [];

    /**
     * @inheritdoc
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->dataProvider === null) {
            throw new InvalidConfigException('The "dataProvider" property must be set');
        }
        $this->channelAttributes = $this->getAttributes($this->channel);
        foreach ($this->requiredChannelElements as $channelElement) {
            if (!in_array($channelElement, $this->channelAttributes)) {
                throw new InvalidConfigException('Required channel attribute "' . $channelElement . '" must be set');
            }
        }
        $this->itemAttributes = $this->getAttributes($this->items);
        foreach ($this->requiredItemElements as $itemElement) {
            if (!in_array($itemElement, $this->itemAttributes)) {
                throw new InvalidConfigException('Required item attribute "' . $itemElement . '" must be set');
            }
        }
        $this->feed = new $this->feedClass;
    }

    /**
     * @inheritdoc
     *
     * @return string|RssFeed
     */
    public function run()
    {
        $this->renderChannel();
        if ($this->dataProvider->getCount() > 0) {
            $this->renderItems();
        }
        return $this->feed;
    }

    /**
     * @return RssFeed
     */
    public function getFeed()
    {
        return $this->feed;
    }

    public function renderChannel()
    {
        $this->getFeed()->addChannel(ArrayHelper::getValue($this->channel, 'link'));
        foreach ($this->channel as $element => $value) {
            if (is_string($value)) {
                $this->getFeed()->addChannelElement($element, $value);
            } else {
                $result = call_user_func($value, $this, $this->getFeed());
                if (is_string($result)) {
                    $this->getFeed()->addChannelElement($element, $result);
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function renderItems()
    {
        $models = $this->dataProvider->getModels();
        foreach ($models as $model) {
            $this->renderItem($model);
        }
    }

    /**
     * @param $model
     */
    public function renderItem($model)
    {
        $this->getFeed()->addItem();
        foreach ($this->items as $element => $value) {
            if (is_string($value)) {
                if (is_string($element)) {
                    $this->getFeed()->addItemElement($element, $value);
                } else {
                    $this->getFeed()->addItemElement($value, ArrayHelper::getValue($model, $value));
                }
            } else {
                $result = call_user_func($value, $model, $this, $this->getFeed());
                if (is_string($result)) {
                    $this->getFeed()->addItemElement($element, $result);
                }
                if (is_array($result) && isset($result['type'])) {
                    if ($result['type'] === 'attributeList') {
                        foreach ($result['value'] as $item => $attributes) {
                            $this->getFeed()->addItemElement($element, '', $attributes);
                        }
                    }
                    if ($result['type'] === 'CDATA') {
                        $this->getFeed()->appendCDATA($element, $result['value']);
                    }
                }
            }
        }
    }

    /**
     * @param $configArray
     *
     * @return array
     *
     * @throws InvalidConfigException
     */
    private function getAttributes($configArray)
    {
        $attributes = [];
        foreach ($configArray as $key => $value) {
            if (is_string($key)) {
                $attributes[] = $key;
            } else {
                if (is_string($value)) {
                    $attributes[] = $value;
                } else {
                    throw new InvalidConfigException('Wrong configured attribute');
                }
            }
        }
        return $attributes;
    }
}
