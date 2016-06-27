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
		$block = Banner::getDb()->cache(function () {
			$banner = Banner::findOne(['key' => $this->key]);
			return $banner;
		}, self::CASH_TIME);

		$this->block_size = $block->col_size;
		$this->block_model = $block;
		//$items = Yii::$app->cache->get($cacheKey);
		//if ($items === false) {
			$items = [];
			$query = BannerItem::findItemsByKey($this->key);

			foreach ($query->all() as $k => $item) {
				/** @var $item \common\models\banners\BannerItem */
				$items[$k]['id'] = $item->id;
				$items[$k]['user_id'] = $item['user']['id'];
				$items[$k]['sum_in'] = $item['user']['sum_in'];
				$items[$k]['sum_out'] = $item['user']['sum_out'];
				$items[$k]['account'] = $item['user']['account'];
				$items[$k]['hit_count'] = $item['hit_count'];
				$items[$k]['hit_price'] = $item['advert']['hit_price'];
				$items[$k]['hit_size'] = $item['advert']['hit_size'];
				$items[$k]['last_hit'] = $item['last_hit'];
				$items[$k]['click_count'] = $item['click_count'];
				$items[$k]['click_price'] = $item['advert']['click_price'];
				$items[$k]['click_size'] = $item['advert']['click_size'];
				$items[$k]['last_click'] = $item['last_click'];
				$items[$k]['day_count'] = $item['day_count'];
				$items[$k]['day_price'] = $item['advert']['day_price'];
				$items[$k]['day_size'] = $item['advert']['day_size'];
				$items[$k]['last_day'] = $item['last_day'];
				$items[$k]['hit_status'] = $item['advert']['hit_status'];
				$items[$k]['click_status'] = $item['advert']['click_status'];
				$items[$k]['day_status'] = $item['advert']['day_status'];
				$items[$k]['start'] = $item['start'];
				$items[$k]['stop'] = $item['stop'];
				if ($item->path) {
					$img = Html::img($item->base_url.'/'.$item->path, ['style' => 'width: 100%;']);
					if ($item->url) {
						$link = Url::to(['/adv/default/index', 'id' => base64_encode($item->id)]);
						$items[$k]['content'] = Html::a($img, $link, ['target' => '_blank', 'class' => 'animated fadeInDown']);
					} else {
						$items[$k]['content'] = $img;
					}
				}
				if ($item->size) {
					$items[$k]['size'] = $item->size;
				}
				//$items[$k]['content'] = Html::tag('div', $items[$k]['content'], ['class' => 'img-caption-ar']);
			}
			//Yii::$app->cache->set($cacheKey, $items, self::CASH_TIME);
		//}
		if(!empty($items)){

			foreach ($items as $item){
				$ids[] = $item['id'];
			}
			BannerItem::bannerHit($ids, $items);
			BannerItem::bannerDay($ids, $items);
			$this->items = $items;
		}
		parent::init();
	}

	/**
	 * Renders the widget.
	 */
	public function run()
	{
		parent::run();
		$content = '';
		if (!empty($this->items)) {
			$content = implode("\n", [
				$this->renderItems(),
			]);
		}
		$block = Html::tag('div', $content, $this->options);
		return Html::tag('div', $block, ['id' => $this->key, 'class' => 'row']);
	}
}
