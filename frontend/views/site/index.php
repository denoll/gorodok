<?php
/* @var $this yii\web\View */

use app\widgets\DbText;
use yii\helpers\Html;
use common\widgets\DbBanner;


$seo = Yii::$app->seo->getByKey('main_page');
$this->title = $seo->title;
$this->registerMetaTag([ 'content' => $seo->desc, 'name' => 'description' ]);
$this->registerMetaTag([ 'content' => $seo->kw, 'name' => 'keywords' ]);

?>
<div class="site-index row" style="margin-top: 10px; margin-bottom: 20px;">
	<?php if ( DbText::widget([ 'key' => 'text-on-main-comming-soon' ]) ) { ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 shadow-wrapper">
					<div class="tag-box tag-box-v1 box-shadow shadow-effect-2">
						<?= DbText::widget([ 'key' => 'text-on-main-comming-soon' ]) ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-7 side_left">
				<?= \frontend\widgets\NewsMainWidget::widget(); ?>
			</div>
			<div class="col-md-5">
				<?= \frontend\widgets\SliderOnMain::widget(); ?>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<div class="row">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6 side_left" style="margin-top: 10px;">
						<?= \frontend\widgets\AfishaMainWidget::widget(); ?>
					</div>
					<div class="col-md-6 side_left" style="margin-top: 10px;">
						<?= \frontend\widgets\KonkursMainWidget::widget(); ?>
						<?= \frontend\widgets\LettersMainWidget::widget(); ?>
					</div>
				</div>
			</div>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6 side_left" style="margin-top: 10px;">
						<?= \frontend\widgets\GoodsMainWidget::widget(); ?>
					</div>
					<div class="col-md-6 side_left" style="margin-top: 10px;">
						<?= \frontend\widgets\ServiceMainWidget::widget(); ?>
					</div>
				</div>
			</div>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6 side_left" style="margin-top: 10px;">
						<?= \frontend\widgets\RealtySaleMainWidget::widget(); ?>
					</div>
					<div class="col-md-6 side_left" style="margin-top: 10px;">
						<?= \frontend\widgets\RealtyRentMainWidget::widget(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3" style="margin-top: 10px;">
		<div class="banner-header">
			<span class="title-underblock title-bottom-border dark">Полезная информация</span>
		</div>
		<?php
		echo \frontend\widgets\LinkPage::widget([
			'text' => '<i class="fa fa-smile-o"></i>&nbsp;&nbsp;&nbsp;Улыбнись',
			'url' => ['/news/news/index', 'cat'=>'ulybnis'],
			'options' => [
				'class' => 'btn-u header-link',
				'style' => 'margin-bottom: 10px; padding: 10px 15px; width: 100%; font-size: 1.2em;'
			],
		]);
		echo \frontend\widgets\LinkPage::widget([
			'text' => '<i class="fa fa-train"></i>&nbsp;&nbsp;&nbsp;Ж/Д расписание',
			'url' => ['/page/page/view', 'cat' => 'poleznaa-informacia','id'=>'raspisanie-poezdov-i-elektricek-stancia-tynda'],
			'options' => [
				'class' => 'btn-u header-link',
				'style' => 'margin-bottom: 10px; padding: 10px 15px; width: 100%; font-size: 1.2em;'
			],
		]);
		echo \frontend\widgets\LinkPage::widget([
			'text' => '<i class="fa fa-bus"></i>&nbsp;&nbsp;&nbsp;Расписание автобусов',
			'url' => ['/page/page/view', 'cat' => 'poleznaa-informacia','id'=>'raspisanie-avtobusov'],
			'options' => [
				'class' => 'btn-u header-link',
				'style' => 'margin-bottom: 10px; padding: 10px 15px; width: 100%; font-size: 1.2em;'
			],
		]);
		echo \frontend\widgets\LinkPage::widget([
			'text' => '<i class="fa fa-envelope-o"></i>&nbsp;&nbsp;&nbsp;Что улучшить в городе?',
			'url' => ['/letters/letters/index'],
			'options' => [
				'class' => 'btn-u header-link',
				'style' => 'margin-bottom: 10px; padding: 10px 15px; width: 100%; font-size: 1.2em;'
			],
		]);
		?>
		<?= DbBanner::widget([ 'key' => 'main_page_right_service' ]) ?>
		<div class="banner-header">
			<span class="title-underblock title-bottom-border dark">Реклама</span>
		</div>
		<?= DbBanner::widget([ 'key' => 'banners_main_page_right' ]) ?>
	</div>
</div>
