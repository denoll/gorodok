<?php

namespace common\helpers;

use common\widgets\DbBanner;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Widget;
use yii\helpers\Html;


class Banner extends Widget
{

    public $items = [];
    public $block_size;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        Html::addCssClass($this->options, ['widget' => 'col-md-'.$this->block_size]);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        return implode("\n", [
            Html::beginTag('div', $this->options),
            $this->renderItems(),
            Html::endTag('div')
        ]) . "\n";
    }


    /**
     * Renders banner items as specified on [[items]].
     * @return string the rendering result
     */
    public function renderItems()
    {
        $items = [];
        for ($i = 0, $count = count($this->items); $i < $count; $i++) {
            $items[] = $this->renderItem($this->items[$i], $i);
        }

        return implode("\n", $items);
    }

    /**
     * Renders a single banner item
     * @param string|array $item a single item from [[items]]
     * @param integer $index the item index as the first item should be set to `active`
     * @return string the rendering result
     * @throws InvalidConfigException if the item is invalid
     */
    public function renderItem($item, $index)
    {

        $block = 'col-sm-'.$item['size'];

        if (is_string($item)) {
            $content = $item;
            $caption = null;
            $options = [];
        } elseif (isset($item['content'])) {
            $content = $item['content'];
            $caption = ArrayHelper::getValue($item, 'caption');
            if ($caption !== null) {
                $caption = Html::tag('div', $caption, ['class' => 'caption-content']);
                $caption = Html::tag('div', $caption, ['class' => 'caption-ar']);
            }
            $options = ArrayHelper::getValue($item, 'options', []);
        } else {
            throw new InvalidConfigException('The "content" option is required.');
        }
        $content = implode("\n", [
                Html::beginTag('div', ['class' => 'img-caption-ar']),
                $content,
                $caption,
                Html::endTag('div')
            ]) . "\n";
        Html::addCssClass($options, ['widget' => $block]);


        return Html::tag('div', $content, $options);
    }
}
