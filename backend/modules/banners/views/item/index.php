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
			],
			[
				'class' => \common\grid\EnumColumn::className(),
				'attribute' => 'id_user',
				'enum' => ArrayHelper::map($users, 'id', 'username'),
			],
			[
				'class' => \common\grid\EnumColumn::className(),
				'attribute' => 'banner_key',
				'enum' => ArrayHelper::map($blocks, 'key', 'key'),
			],
			[
				'attribute' => 'path',
				'format' => 'raw',
				'options' => ['width' => '120'],
				'filter' => false,
				'value' => function($data){
					if(!empty($data['path'])) {
						return Html::img(\Yii::$app->fileStorage->fileUrl('banners',$data['path']), [
							'alt' => 'Фото',
							'style' => 'width:120px;'
						]);
					}else{
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
				'enum' => [
					'Выключен',
					'Включен',
				],
			],
			//'url:url',
			//'caption',
			//'order',
			//'created_at',
			//'updated_at',
			'click_count',
			'max_click',
			'start',
			'stop',
		],
	]); ?>
</div>
