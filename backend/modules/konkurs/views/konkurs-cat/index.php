<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\konkurs\KonkursCatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории конкурсов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="konkurs-cat-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a('Создать новую категорию', ['create'], ['class' => 'btn btn-success']) ?>
	</p>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'id',
			'id_parent',
			'status',
			'order',
			'name',
			'slug',
			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>
</div>
