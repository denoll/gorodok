<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\banners\BannerItem;

/* @var $this yii\web\View */
/* @var $model common\models\banners\Banner */

$this->title = 'Изменение блока баннеров - ' . $model->key;
$this->params['breadcrumbs'][] = ['label' => 'Все блоки баннеров', 'url' => ['index']];
?>
<div class="widget-banner-update">

	<?php echo $this->render('_form', [
		'model' => $model,
	]) ?>


	<hr class="no-margin">
	<h2>Баннеры расположенные в этом рекламном блоке:</h2>

	<p>
		<?php echo Html::a('<i class="fa fa-plus"></i>&nbsp;&nbsp;Добавить новый рекламный баннер в этот рекламный блок', ['/banners/item/create', 'banner_key' => $model->key], ['class' => 'btn btn-success']) ?>
	</p>

	<?php echo GridView::widget([
		'dataProvider' => $bannerItemsProvider,
		'columns' => [
			[
				'class' => 'yii\grid\ActionColumn',
				'contentOptions' => ['style' => 'width: 90px; max-width: 90px;'],
				'template' => '{update} {delete}',
				'buttons' => [
					'update' => function ($url, $model, $key) {
						Url::remember();
						return Html::a(
							'<i class="fa fa-edit"></i>',
							['/banners/item/update', 'id' => $key],
							[
								'class' => 'btn btn-sm btn-primary',
								'title' => 'Редактировать баннер',
							]
						);
					},
					'delete' => function ($url, $model, $key) {
						return Html::a(
							'<i class="fa fa-trash"></i>',
							['/banners/item/delete', 'id' => $key],
							[
								'class' => 'btn btn-sm btn-danger',
								'title' => 'Удалить баннер',
								'data' => [
									'confirm' => 'Вы действительно хотите удалить баннер?',
									'method' => 'post',
								],
							]
						);
					},
				],
			],
			[
				'attribute' => 'path',
				'format' => 'raw',
				'options' => ['width' => '120'],
				'filter' => false,
				'value' => function ($data) {
					if (!empty($data['path'])) {
						return Html::img($data['base_url'] . '/' . $data['path'], [
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
				'attribute' => 'id_adv_company',
				'enum' => ArrayHelper::map($advert, 'id', 'name'),
			],
			[
				'class' => \common\grid\EnumColumn::className(),
				'attribute' => 'id_user',
				'enum' => ArrayHelper::map($banner_users, 'id', 'username'),
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
		],
	]); ?>


</div>
