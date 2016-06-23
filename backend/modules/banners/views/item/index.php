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
				'class' => \common\grid\EnumColumn::className(),
				'attribute' => 'id_adv_company',
				'enum' => ArrayHelper::map($advert, 'id', 'name'),
				'format' => 'raw',
			],
			[
				'class' => \common\grid\EnumColumn::className(),
				'attribute' => 'id_user',
				'enum' => ArrayHelper::map($users, 'id', 'username'),
				'format' => 'raw',
			],
			[
				'class' => \common\grid\EnumColumn::className(),
				'attribute' => 'banner_key',
				'filter' => ArrayHelper::map($blocks, 'banner_key', 'name'),
				'format' => 'raw',
			],
			[
				'attribute' => 'path',
				'format' => 'raw',
				'options' => ['width' => '120'],
				'filter' => false,
				'value' => function ($data) {
					if (!empty($data['path'])) {
						return Html::img(\Yii::$app->storage->fileUrl(null, $data['path']), [
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
				'class' => \common\grid\EnumColumn::className(),
				'attribute' => 'status',
				'enum' => \common\helpers\Arrays::statusBanner(),
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
