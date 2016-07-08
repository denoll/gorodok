<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\konkurs\KonkursSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Конкурсы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="konkurs-index">

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a('Создать новый конкурс', ['create'], ['class' => 'btn btn-success']) ?>
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
	]); ?>
</div>
