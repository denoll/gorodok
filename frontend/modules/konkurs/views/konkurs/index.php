<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\konkurs\KonkursSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['left'] = true;
$this->params['right'] = true;

$model = $dataProvider->getModels();

$this->title = 'Конкурсы';
$this->params['breadcrumbs'][] = $this->title;

$mk = 'справочник адресов Тынды, адреса Тынды, адреса гос органов Тынды, адреса фирм Тынды, каталог фирм города Тында';
$md = 'Справочник адресов государственных органов и компаний города Тында';

if (!empty($md)) {
	$this->registerMetaTag(['content' => Html::encode($md), 'name' => 'description']);
}
if (!empty($mk)) {
	$this->registerMetaTag(['content' => Html::encode($mk), 'name' => 'keywords']);
}



?>
<div class="konkurs-index">

	<h1 class="header-title"><?= Html::encode($this->title) ?></h1>

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?= \yii\widgets\ListView::widget([
		'dataProvider' => $dataProvider,
		'itemView' => '_item',
		'layout' => '<div class="sorter-block"><i class="small-text">Сортировать:</i> {sorter} {summary} {pager}</div> {items} {pager}',
	]); ?>

</div>
