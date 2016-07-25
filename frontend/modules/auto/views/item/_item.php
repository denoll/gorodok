<?php

/** @var $model \common\models\auto\AutoItem */

use yii\helpers\Html;
use \yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use frontend\widgets\Avatar;
use \common\widgets\Arrays;

//Вычисляем период между текущей датой и датой получения статуса vip
$const = Arrays::getConst();
$vip_date = strtotime($model['vip_date']);
$now = strtotime(date('Y-m-d'));
$period = intval(abs(($now - $vip_date) / (3600 * 24)));

if ($period <= $const['vip'] && $model['vip_date'] !== null) {
	$color = 'background-color: rgba(145,201,72, 0.5);';
	$star = true;
} else {
	$color = 'border: 1px solid #ddd;';
	$star = false;
}
?>
<div class="item" xmlns="http://www.w3.org/1999/html">
	<div class="margin-bottom-10">
		<div class="container-fluid" style="<?= $color ?> padding: 1px; 10px; margin: 0px;">
			<div class="col-sm-2 side_left sm-margin-bottom-20">
				<div class="thumbnail" style="padding: 1px; margin: 15px 0px 17px 0px;">
					<?= Html::a(Avatar::imgAuto($model->autoImg[0]->base_url, $model->autoImg[0]->path, '100%'), [Url::to('/auto/item/view'), 'id' => $model['id']]) ?>
				</div>
			</div>
			<div class="col-md-7 side_left">
				<h2 style="margin: 5px 0px;">
					<?= $star ? Avatar::Star() : '&nbsp;' ?>&nbsp;
					<?= Html::a($model->brand->name . ' - ' . $model->model->name, [Url::to('/auto/item/view'), 'id' => $model['id']]) ?>&nbsp;&nbsp;
					<i><?= \common\models\auto\Arrays::getNewAuto($model->new) ?></i>
				</h2>
				<p>
					<span class="nowrap"><i class="small-text">Год выпуска:&nbsp;</i><strong><?= $model->year ?></strong>&nbsp;&nbsp;</span>
					<span class="nowrap"><i class="small-text">Пробег:&nbsp;</i><strong><?= number_format($model->distance, null, '', ' ') ?> км.</strong>&nbsp;&nbsp;</span>
					<span class="nowrap"><i class="small-text">Кузов:&nbsp;</i><strong><?= \common\models\auto\Arrays::getBodyAuto($model->body) ?></strong>&nbsp;&nbsp;</span>
					<span class="nowrap"><i class="small-text">Коробка передач:&nbsp;</i><strong><?= \common\models\auto\Arrays::getTransmissionAuto($model->transmission) ?></strong>&nbsp;&nbsp;</span>
					<span class="nowrap"><i class="small-text">Двигатель:&nbsp;</i><strong><?= \common\models\auto\Arrays::getMotorAuto($model->privod) ?></strong>&nbsp;&nbsp;</span>
					<span class="nowrap"><i class="small-text">Объем:&nbsp;</i><strong><?= $model->volume ?> л.</strong>&nbsp;&nbsp;</span>
					<span class="nowrap"><i class="small-text">Привод:&nbsp;</i><strong><?= \common\models\auto\Arrays::getPrivodAuto($model->privod) ?></strong>&nbsp;&nbsp;</span>
					<span class="nowrap"><i class="small-text">Мощность:&nbsp;</i><strong><?= $model->power ?> л.с.</strong>&nbsp;&nbsp;</span>
					<span class="nowrap"><i class="small-text">Цвет:&nbsp;</i>&nbsp;
						<span style="background-color: <?= $model->color; ?>;" class="color-bage">&nbsp;</span>&nbsp;
						<strong><?= \common\models\auto\Arrays::getColorAuto($model->color) ?></strong>&nbsp;&nbsp;
					</span>
				</p>

			</div>
			<div class="col-md-3 resume-right-col" style="margin-top: 10px;">
				<p><i class="small-text">Цена: </i>&nbsp;<span style="font-weight: bold;"><?= number_format($model->price, 2, ',', "'") . '&nbsp;<i class="small-text">Руб. </i>' ?></span></p>
				<p><i class="small-text"><?= \Yii::$app->formatter->asDate($model['created_at'], 'long') ?></i></p>
				<p><i class="small-text">Автор:&nbsp;<?= $model->user->company ? ' Компания ' : ' Частное лицо ' ?></i></p>
				<p><?= $model->user->company ? $model->user->company_name : $model->user->username ?></p>
			</div>
		</div>

	</div>
</div>
