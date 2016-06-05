<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\banners\AdvertSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рекламные компании';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-adv-index">
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a('<i class="fa fa-plus" ></i>&nbsp;&nbsp;Создать новую рекламныю компанию', ['create'], ['class' => 'btn btn-success']) ?>
	</p>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\ActionColumn'],
			'name',
			'click_price',
			'day_price',
			'description',
			'id',
		],
	]); ?>
</div>
