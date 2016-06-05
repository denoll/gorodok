<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\med\BackDoctorsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Doctors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doctors-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a('Create Doctors', ['create'], ['class' => 'btn btn-success']) ?>
	</p>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'id_user',
			'id_spec',
			'status',
			'confirmed',
			'rank',
			// 'price',
			// 'about:ntext',
			// 'exp',
			// 'receiving',
			// 'address',
			// 'documents',
			// 'updated_at',
			// 'created_at',
			// 'm_keyword',
			// 'm_description',

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>
</div>
<pre>
    <?php
		$auth = new \nodge\eauth\EAuth();
	print_r($auth->getServices());

	?>
</pre>
