<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use \common\models\banners\BannerItem;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\banners\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рекламные баннеры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-item-index">

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a('<i class="fa fa-plus"></i>&nbsp;&nbsp;Создать новый рекламный баннер', ['create'], ['class' => 'btn btn-success']) ?>
	</p>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\ActionColumn'],
			'id',
			[
				'attribute' => 'id_adv_company',
				'value' => 'advert.name',
				'format' => 'raw',
				'filter' => ArrayHelper::map($advert, 'id', 'name'),
				'options' => ['style' => 'max-width: 200px;'],
				'contentOptions' => ['style' => 'max-width: 200px;'],
			],
			[
				'attribute' => 'id_user',
				'value' => 'user.username',
				'format' => 'raw',
				'filterType' => GridView::FILTER_SELECT2,
				'filter' => \yii\helpers\ArrayHelper::map($users, 'id', 'username'),
				'filterWidgetOptions' => [
					'pluginOptions' => ['allowClear' => true],
				],
				'filterInputOptions' => ['placeholder' => 'Пользователь ...'],
			],
			[
				'attribute' => 'banner_key',
				'value' => 'banner.name',
				'format' => 'raw',
				'filter' => ArrayHelper::map($blocks, 'banner_key', 'name'),
				'options' => ['style' => 'max-width: 200px;'],
				'contentOptions' => ['style' => 'max-width: 200px;'],
			],
			[
				'attribute' => 'path',
				'format' => 'raw',
				'options' => ['width' => '120'],
				'filter' => false,
				'value' => function ($data) {
					if (!empty($data['path'])) {
						return Html::img($data['base_url'] .'/'.$data['path'], [
							'alt' => 'Фото',
							'style' => 'width:120px;'
						]);
					} else {
						return Html::img(Url::to('@frt_url/img/no-img.png'), [
							'alt' => 'Фото',
							'style' => 'width:120px;'
						]);
					}
				},
			],
			[
				'class' => \common\grid\EnumColumn::className(),
				'attribute' => 'size',
				'enum' => BannerItem::bannerSize(),
			],
			[
				'attribute' => 'status',
				'format' => 'raw',
				'filter' => \common\helpers\Arrays::statusBanner(),
				'value' => function($data){
					return \common\helpers\Arrays::getStatusBanner($data->status);
				}
			],
			'click_count',
			'hit_count',
			'day_count',
			'last_click',
			'last_hit',
			'last_day',
			//'max_click',
			//'max_hit',
			//'max_day',
			'start',
			'stop',
		],
	]); ?>
	<br><br><br><br>
</div>
