<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\auto\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Объявления авто';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-item-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a('Создать новое объявление', ['create'], ['class' => 'btn btn-success']) ?>
	</p>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			[
				'class' => 'yii\grid\ActionColumn',
				'contentOptions' => ['style' => 'width: 90px; max-width: 90px;'],
				'template' => '{update} {delete-item}',
				'buttons' => [
					'update' => function ($url, $model, $key) {
						return Html::a(
							'<i class="fa fa-edit"></i>',
							$url,
							[
								'class' => 'btn btn-sm btn-primary',
								'title' => 'Редактировать',
							]
						);
					},
					'delete-item' => function ($url, $model, $key) {
						return Html::a(
							'<i class="fa fa-trash"></i>',
							$url,
							[
								'class' => 'btn btn-sm btn-danger',
								'title' => 'Удалить',
								'data' => [
									'confirm' => 'Вы действительно хотите удалить это объявление?',
									'method' => 'post',
								],
							]
						);
					},
				],
			],

			'id',
			[
				'attribute' => 'id_user',
				'value' => function($model){
					return $model->user->username;
				},
				'format' => 'raw',
				'filterType' => GridView::FILTER_SELECT2,
				'filter' => \yii\helpers\ArrayHelper::map(\common\models\users\User::find()->all(), 'id', 'username'),
				'filterWidgetOptions' => [
					'pluginOptions' => ['allowClear' => true],
				],
				'filterInputOptions' => ['placeholder' => 'Пользователь ...'],
			],
			[
				'attribute' => 'id_brand',
				'format' => 'raw',
				'filter' => \yii\helpers\ArrayHelper::map(\common\models\auto\AutoBrands::find()->all(), 'id', 'name'),
				'value' => 'brand.name'
			],
			[
				'attribute' => 'id_model',
				'format' => 'raw',
				'filter' => \yii\helpers\ArrayHelper::map(\common\models\auto\AutoModels::find()->all(), 'id', 'name'),
				'value' => 'model.name'
			],
			[
				'attribute' => 'status',
				'filter' => \common\models\auto\Arrays::statusAuto(),
				'value' => function($model){
					return \common\models\auto\Arrays::getStatusAuto($model->status);
				}
			],
			'price',
			'volume',
			[
				'attribute' => 'new',
				'filter' => \common\models\auto\Arrays::newAuto(),
				'value' => function($model){
					return \common\models\auto\Arrays::getNewAuto($model->new);
				}
			],
			[
				'attribute' => 'body',
				'filter' => \common\models\auto\Arrays::bodyAuto(),
				'value' => function($model){
					return \common\models\auto\Arrays::getBodyAuto($model->body);
				}
			],
			[
				'attribute' => 'transmission',
				'filter' => \common\models\auto\Arrays::transmissionAuto(),
				'value' => function($model){
					return \common\models\auto\Arrays::getTransmissionAuto($model->transmission);
				}
			],
			'year',
			'distance',
			[
				'attribute' => 'color',
				'filter' => \common\models\auto\Arrays::colorAuto(),
				'value' => function($model){
					return \common\models\auto\Arrays::getColorAuto($model->color);
				}
			],
		],
	]); ?>
</div>
