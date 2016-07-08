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

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?= \yii\widgets\ListView::widget([
		'dataProvider' => $dataProvider,
		'itemView' => '_item',
		'layout' => '<div class="sorter-block"><i class="small-text">Сортировать:</i> {sorter} {summary} {pager}</div> {items} {pager}',
	]); ?>

	<?/*= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view}',
			],
			'id',
			'name',
			'title',
			//'slug',
			[
				'attribute' => 'status',
				'filter' => \common\helpers\Arrays::status(),
				'value' => function($data){
					return \common\helpers\Arrays::getStatus($data->status);
				}
			],
			[
				'attribute' => 'show_img',
				'filter' => \common\helpers\Arrays::statusYesNo(),
				'value' => function($data){
					return \common\helpers\Arrays::getYesNo($data->show_img);
				}
			],
			[
				'attribute' => 'show_des',
				'filter' => \common\helpers\Arrays::statusYesNo(),
				'value' => function($data){
					return \common\helpers\Arrays::getYesNo($data->show_des);
				}
			],
			[
				'attribute' => 'stars',
				'filter' => \common\helpers\Arrays::typeKonkurs(),
				'value' => function($data){
					return \common\helpers\Arrays::getTypeKonkurs($data->stars);
				}
			],
			[
				'attribute' => 'img',
				'format' => 'raw',
				'value' => function ($data) {
					return \common\helpers\Thumb::img($data->base_url, $data->img, '50px');
				}
			],
			'width',
			'height',
			'start',
			'stop',
			'created_at',
			'updated_at',
			// 'mk',
			// 'md',
		],
	]);*/ ?>
</div>
