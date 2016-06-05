<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $searchModel common\models\users\BUserAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Платежи пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-account-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	<p>
		<?= Html::a('<i class="fa fa-money"></i>&nbsp;&nbsp;Пополнить баланс одного из пользователей', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?= Tabs::widget(['items' => [
		[
			'label' => 'Входящие платежи (пополнения баланса)',
			'active' => true,
			'content' => GridView::widget([
				'dataProvider' => $dataProvider->search(Yii::$app->request->queryParams, 'in'),
				'filterModel' => $searchModel,
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],
					[
						'class' => 'yii\grid\ActionColumn',
						'contentOptions' => ['style' => 'width: 130px; max-width: 130px;'],
						'template' => '<div class="btn-group">{view} {update}</div> {delete}',
						'buttons' => [
							'view' => function ($url, $model, $key) {
								return Html::a(
									'<i class="fa fa-eye"></i>',
									['view', 'id' => $model['id']],
									[
										'class' => 'btn btn-sm btn-primary',
										'title' => 'Просмотр',
									]
								);
							},
							'update' => function ($url, $model, $key) {
								return Html::a(
									'<i class="fa fa-edit"></i>',
									['update', 'id' => $model['id']],
									[
										'class' => 'btn btn-sm btn-success',
										'title' => 'Изменить',
									]
								);
							},
							'delete' => function ($url, $model, $key) {
								return Html::a(
									'<i class="fa fa-trash"></i>',
									['delete', 'id' => $model['id']],
									[
										'class' => 'btn btn-sm btn-danger',
										'title' => 'Удалить',
										'data' => [
											'confirm' => 'Вы действительно хотите удалить этот платеж?',
											'method' => 'post',
										],
									]
								);
							},
						],
					],
					[
						'attribute' => 'id_user',
						'label' => 'Пользователь',
						'value' => 'idUser.username',
						'filter' => false,
					],
					'pay_in',
					'pay_in_with_percent',
					'invoice',
					'date',
					'service',
					'yandexPaymentId',
					'invoiceId',
					// 'paymentType',
				],
			]),
		],
		[
			'label' => 'Оплаты за услуги',
			'content' => GridView::widget([
				'dataProvider' => $dataProvider->search(Yii::$app->request->queryParams, 'out'),
				'filterModel' => $searchModel,
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],
					[
						'class' => 'yii\grid\ActionColumn',
						'contentOptions' => ['style' => 'width: 130px; max-width: 130px;'],
						'template' => '<div class="btn-group">{view} {update}</div> {delete}',
						'buttons' => [
							'view' => function ($url, $model, $key) {
								return Html::a(
									'<i class="fa fa-eye"></i>',
									['view', 'id' => $model['id']],
									[
										'class' => 'btn btn-sm btn-primary',
										'title' => 'Просмотр',
									]
								);
							},
							'update' => function ($url, $model, $key) {
								return Html::a(
									'<i class="fa fa-edit"></i>',
									['update', 'id' => $model['id']],
									[
										'class' => 'btn btn-sm btn-success',
										'title' => 'Изменить',
									]
								);
							},
							'delete' => function ($url, $model, $key) {
								return Html::a(
									'<i class="fa fa-trash"></i>',
									['delete', 'id' => $model['id']],
									[
										'class' => 'btn btn-sm btn-danger',
										'title' => 'Удалить',
										'data' => [
											'confirm' => 'Вы действительно хотите удалить этот платеж?',
											'method' => 'post',
										],
									]
								);
							},
						],
					],
					[
						'attribute' => 'id_user',
						'label' => 'Пользователь',
						'value' => 'idUser.username',
						'filter' => false,
					],
					'pay_out',
					'invoice',
					'date',
					'service',
				],
			]),
		],
	]
	]);
	?>

</div>
