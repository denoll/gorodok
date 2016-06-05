<?php

	use yii\helpers\Html;
	use kartik\grid\GridView;

	/* @var $this yii\web\View */
	/* @var $searchModel common\models\search\ForumMessageSearch */
	/* @var $dataProvider yii\data\ActiveDataProvider */


	$this->title = 'Сообщения в теме: '.$theme->name;
	$this->params['breadcrumbs'][] = ['label' => 'Темы', 'url' => ['index']];
	$this->params['breadcrumbs'][] = 'Сообщения';
	$status = [
		['id' => '0', 'name' => 'Не активная'],
		['id' => '1', 'name' => 'Активная'],
		['id' => '2', 'name' => 'Закрыта',]
	];


?>
<div class="forum-message-index">

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<div class="btn-group">
		<?= Html::a('Создать новое сообщение', ['create-message'], ['class' => 'btn btn-success']) ?>
		<?= Html::a('Назад к темам', ['index'], ['class' => 'btn btn-default']) ?>
	</div>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			[
				'class' => 'yii\grid\ActionColumn',
				'contentOptions' => ['style' => 'width: 130px; max-width: 130px;'],
				'template' => '<div class="btn-group">{update-message}</div> {delete-message}',
				'buttons' => [
					'update-message' => function ($url, $model, $key) {
						return Html::a(
							'<i class="fa fa-edit"></i>',
							$url.'&theme_id='.$model->id_theme,
							[
								'class' => 'btn btn-sm btn-primary',
								'title' => 'Редактировать',
							]
						);
					},
					'delete-message' => function ($url, $model, $key) {
						return Html::a(
							'<i class="fa fa-trash"></i>',
							$url.'&theme_id='.$model->id_theme.'&author_id='.$model->id_author,
							[
								'class' => 'btn btn-sm btn-danger',
								'title' => 'Удалить',
								'data' => [
									'confirm' => 'Вы действительно хотите удалить это сообщение?',
									'method' => 'post',
								],
							]
						);
					},
				],
			],
			[
				'attribute' => 'id',
				'label' => 'ID',
				'options' => ['width' => '70']
			],
			[
				'attribute' => 'status',
				'label' => 'Статус',
				'format' => 'raw',
				'filter' => \yii\helpers\ArrayHelper::map($status, 'id', 'name'),
				'value' => 'status',
				'options' => ['style' => 'width: 90px; max-width: 90px;'],
				'contentOptions' => ['style' => 'width: 90px; max-width: 90px;'],
			],
			[
				'attribute' => 'id_author',
				'label' => 'Автор',
				'value' => 'idAuthor.username',
				'format' => 'raw',
				'filterType' => GridView::FILTER_SELECT2,
				'filter' => \yii\helpers\ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'),
				'filterWidgetOptions' => [
					'pluginOptions' => ['allowClear' => true],
				],
				'filterInputOptions' => ['placeholder' => 'Автор ...'],
				'options' => ['style' => 'width: 150px;'],
				'contentOptions' => ['style' => 'width: 150px;'],
			],
			// 'created_at',
			// 'modify_at',
			'message:raw',
		],
	]); ?>

</div>
