<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $searchModel common\models\users\UserAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['left'] = true;
$this->title = 'Взаиморасчеты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-account-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?= Tabs::widget(['items' => [
		[
			'label' => 'Входящие платежи (пополнения баланса)',
			'active' => true,
			'content' => GridView::widget([
				'dataProvider' => $dataProvider->search(Yii::$app->request->queryParams, 'in'),
				'filterModel' => $searchModel,
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],
					'description',
					'date',
					'invoice',
					'pay_in',
					//'pay_out',
					//'service',
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
					'description',
					'date',
					'invoice',
					//'pay_in',
					'pay_out',
					//'service',
				],
			]),
		],
	]
	]);
	?>

</div>
