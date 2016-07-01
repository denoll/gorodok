<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use \common\widgets\Arrays;
/* @var $this yii\web\View */
/* @var $model common\models\firm\Firm */

$this->params['left'] = true;
$this->params['right'] = true;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Все фирмы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model['cat']['name'], 'url' => ['index', 'cat' => $model['cat']['slug']]];

if(!empty($model['mk'])&&!empty($model['md'])){
	$mk = $model['mk'];
	$md = $model['md'];
} elseif (!empty($model['cat']['mk']) && !empty($model['cat']['md']) && empty($model['mk']) && empty($model['md'])) {
	$mk = $model['name'] . ', ' . $current_cat['mk'];
	$md = $model['name'] . '. ' . $current_cat['md'];
} else {
	$mk = $model['name'] . ', справочник адресов Тынды, адреса Тынды, адреса гос органов Тынды, адреса фирм Тынды, каталог фирм города Тында';
	$md = $model['name'] . '. Справочник адресов государственных органов и компаний города Тында';
}

if (!empty($md)) {
	$this->registerMetaTag(['content' => Html::encode($md), 'name' => 'description']);
}
if (!empty($mk)) {
	$this->registerMetaTag(['content' => Html::encode($mk), 'name' => 'keywords']);
}

?>
<div class="firm-view">
	<div class="row" style="margin: 20px 0;">
		<?php if($model->logo){ ?>
		<div class="col-sm-2">
			<?= \frontend\widgets\Avatar::imgFirm($model->logo, '100%') ?>
		</div>
		<?php } ?>
		<div class="col-sm-10">
			<h1><?= Html::encode($this->title) ?></h1>
			<p><i class="small-text">Категория:&nbsp;</i><strong><?= Html::a($model['cat']['name'], [Url::to('/firm/firm/index'), 'cat' => $model['cat']['slug']]); ?></strong></p>
			<p><i class="small-text">Тел: </i>&nbsp;<span style="font-weight: bold;"><?= $model['tel'] ? $model['tel'] : 'не указан' ?></span></p>
			<p>
				<i class="small-text">Сайт: </i>&nbsp;<span style="font-weight: bold;"><?= $model['site'] ? $model['site'] : 'не указан' ?></span>&nbsp;&nbsp;&nbsp;
				<i class="small-text">Email: </i>&nbsp;<span style="font-weight: bold;"><?= $model['email'] ? $model['email'] : 'не указан' ?></span>
			</p>
			<p><i class="small-text">Адрес: </i>&nbsp;<span style="font-weight: bold;"><?= $model['address'] ? $model['address'] : 'не указан' ?></span></p>
		</div>
	</div>


	<?php if ($model->lon && $model->lat) { ?>
		<?= \common\widgets\yamaps\YaMap::widget([
			'lat' => $model->lat,
			'lon' => $model->lon,
			'firm_name' => $model->name,
			'zoom' => 16,
		]); ?>
	<?php } ?>

	<?php if(trim($model->description)){ ?>
		<div class="headline">
			<h2>Описание</h2>
		</div>
		<p>
			<?= nl2br($model->description); ?>
		</p>
	<?php } ?>

</div>
