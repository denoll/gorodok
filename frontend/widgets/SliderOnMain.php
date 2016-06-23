<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 14.10.2015
 * Time: 17:51
 */

namespace frontend\widgets;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use \yii\bootstrap\Widget;
use common\models\slider\SliderMain;
use \common\widgets\Arrays;
use \yii\caching\DbDependency;

class SliderOnMain extends Widget
{
	public $path;
	public $images;
	public $size;

	public function init()
	{

	}

	public function run()
	{
		if (empty($this->images) && empty($this->path)) {
			$this->path = Url::to('@frt_url/img/slider/');
			$this->images = SliderMain::getDb()->cache(function () {
				return SliderMain::find()->asArray()->where(['status' => 1])->andWhere(['IS NOT', 'img', null])->orderBy('id DESC')->all();
			}, Arrays::CASH_TIME );
		}
		$this->registerCssLoc();
		if (!empty($this->images[0])) {
			echo '<div id="slider-on-main" class="demo">';
			echo '<div class="item">';
			echo '<div class="clearfix" style="">';
			echo '<ul id="image-gallery" class="gallery list-unstyled cS-hidden">';
			foreach ($this->images as $_image) {
				//$this->path = Url::to('@frt_url/img/realty_sale/');
				$image = $_image['thumbnail'];
				echo '<li data-thumb="' . $this->path . $image . '">';
				echo '<img src="' . $this->path . $image . '" style="width: ' . $this->size . ' ;" alt="Фото">';
				echo '<div class="slider-main-sign">';
				echo '<h2>' . $_image['name'] . '</h2>';
				echo '<div>';
				echo '</li>';
			}
			echo '</ul>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
		} else {
			if (!empty($this->size)) {
				$avtUrl = Url::to('@frt_url/img/no-img.png');
				return Html::img($avtUrl, [
					'alt' => 'Фото',
					'style' => 'width:' . $this->size . ';'
				]);
			} else {
				$avtUrl = Url::to('@frt_url/img/no-img.png');
				return Html::img($avtUrl, [
					'alt' => 'Фото',
					'style' => 'width:100%;'
				]);
			}
		}
		$this->registerJsLoc();
		/*echo '<pre>';
		print_r($this->images);
		echo '<pre>';*/
	}


	private function registerCssLoc()
	{
		$this->view->registerCssFile('/plugins/light-slider/css/lightslider.min.css', ['depends' => [\frontend\assets\AppAsset::className()]]);
		$this->view->registerCssFile('/plugins/light-slider/css/style.css', ['depends' => [\frontend\assets\AppAsset::className()]]);
	}

	private function registerJsLoc()
	{
		$js = <<< JS
    $(document).ready(function () {
            $('#image-gallery').lightSlider({
                gallery:true,
                item:1,
                thumbItem:9,
                slideMargin: 0,
                pause: 10000,
                speed:800,
                auto:true,
                loop:true,
                onSliderLoad: function() {
                    $('#image-gallery').removeClass('cS-hidden');
                }
            });
    });
JS;
		$this->view->registerJsFile('/plugins/light-slider/js/lightslider.min.js', ['depends' => [\frontend\assets\AppAsset::className()]]);
		$this->view->registerJs($js, View::POS_END);
	}
}

?>