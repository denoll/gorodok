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

		$items = BannerItem::findItemsByKey($this->key);

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
