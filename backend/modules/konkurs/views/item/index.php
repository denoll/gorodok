<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\konkurs\Konkurs;
use common\models\users\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\konkurs\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Элементы конкурсов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="konkurs-item-index">

	<h1 class="header-title"><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a('Создать новый элемент конкурса', ['create'], ['class' => 'btn btn-success']) ?>
	</p>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}',
			],
			'id',
			'name',
			[
				'attribute' => 'status',
				'filter' => \common\helpers\Arrays::status(),
				'value' => function ($data) {
					return \common\helpers\Arrays::getStatus($data->status);
				}
			],
			[
				'attribute' => 'img',
				'format' => 'raw',
				'value' => function ($data) {
					return \common\helpers\Thumb::img($data->base_url, $data->img, '50px');
				}
			],
			[
				'attribute' => 'id_konkurs',
				'format' => 'raw',
				'filter' => ArrayHelper::map(Konkurs::find()->orderBy('id DESC')->asArray()->all(), 'id', 'name') ,
				'value' => 'konkurs.name'
			],
			[
				'attribute' => 'id_user',
				'format' => 'raw',
				'filter' => ArrayHelper::map(User::find()->orderBy('id DESC')->asArray()->all(), 'id', 'username') ,
				'value' => 'user.username'
			],
			'scope',
			'created_at',
			//'yes',
			//'no',
			// 'description',
			// 'updated_at',
		],
	]); ?>
</div>
