<?php
/**
 * Eugine Terentev <eugine@terentev.net>
 */

namespace common\widgets;

use common\models\banners\Banner;
use common\models\banners\BannerItem;
use Yii;
use yii\base\InvalidConfigException;
use common\helpers\Banner as BannerHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class DbBanner
 * @package common\widgets
 */
class DbBanner extends BannerHelper
{
    const CASH_TIME = 3600; //seconds
    /**
     * @var
     */
    public $key;

    public $block_model;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->key) {
            throw new InvalidConfigException;
        }
        $cacheKey = [
            Banner::className(),
            $this->key
        ];
        $block = Banner::getDb()->cache(function(){
            $banner = Banner::findOne(['key'=> $this->key]);
            return $banner;
        }, self::CASH_TIME);

        $this->block_size = $block->col_size;
        $this->block_model = $block;
        $items = Yii::$app->cache->get($cacheKey);
        if ($items === false) {
            $items = [];
            $query = BannerItem::find()
                ->joinWith('banner')
                ->where([
                    '{{%banner_item}}.status' => 1,
                    '{{%banner}}.status' => Banner::STATUS_ACTIVE,
                    '{{%banner}}.key' => $this->key,
                ])
                ->orderBy(['order' => SORT_ASC]);

            foreach ($query->all() as $k => $item) {
                /** @var $item \common\models\banners\BannerItem */

                if ($item->path) {
                    $img = Html::img($item::bannerImgUrl($item->path),['style'=>'width: 100%;']);
                    if($item->url){
                        $link = Url::to(['/adv/default/index','id'=> base64_encode($item->id)]);
                        $items[$k]['content'] = Html::a($img, $link, ['target'=>'_blank', 'class'=>'animated fadeInDown']);
                    }else{
                        $items[$k]['content'] = $img;
                    }
                }
                if ($item->size) {
                    $items[$k]['size'] = $item->size;
                }

                //$items[$k]['content'] = Html::tag('div', $items[$k]['content'], ['class' => 'img-caption-ar']);
            }
            Yii::$app->cache->set($cacheKey, $items, self::CASH_TIME);
        }
        $this->items = $items;
        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $content = '';
        if (!empty($this->items)) {
            $content = implode("\n", [
                $this->renderItems(),
            ]);
        }
        $block = Html::tag('div', $content, $this->options);
        return Html::tag('div', $block, ['id'=>$this->key,'class'=> 'row']);
    }
}
