<?php
/* @var $this yii\web\View */

use app\widgets\DbText;
use yii\helpers\Html;
use common\widgets\DbBanner;

$this->title = 'Наша Тында';
$this->registerMetaTag(['content' => Html::encode('Городской портал Наша Тында'), 'name' => 'description']);
$this->registerMetaTag(['content' => Html::encode('Городской портал Наша Тында'), 'name' => 'keywords']);

?>
<div class="site-index row" style="margin-top: 10px; margin-bottom: 20px;">
	<?php if (DbText::widget(['key' => 'text-on-main-comming-soon'])) { ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 shadow-wrapper">
					<div class="tag-box tag-box-v1 box-shadow shadow-effect-2">
						<?= DbText::widget(['key' => 'text-on-main-comming-soon']) ?>
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
	<div class="col-md-3 side_left" style="margin-top: 10px;">

		<div class="banner-header">
			<span class="title-underblock title-bottom-border dark">Реклама</span>
		</div>
		<?= DbBanner::widget(['key' => 'banners_main_page_right']) ?>
	</div>
</div>
