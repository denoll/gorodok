<?php

use yii\helpers\Html;
use kartik\grid\GridView;

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
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}',
				'options' => ['width' => '60'],
			],
			[
				'class' => \common\grid\EnumColumn::className(),
				'attribute' => 'status',
				'enum' => \common\models\banners\BannerAdv::advertStatuses(),
				'label'=>'Статус'
			],
			'name',
			[
				'attribute' => 'hit_price',
				'options' => ['width' => '80'],
			],
			[
				'attribute' => 'click_price',
				'options' => ['width' => '80'],
			],
			[
				'attribute' => 'day_price',
				'options' => ['width' => '80'],
			],
			[
				'attribute' => 'hit_status',
				'format' => 'boolean',
				'filter' => \common\helpers\Arrays::statusYesNo(),
				'options' => ['width' => '80'],
			],
			[
				'attribute' => 'click_status',
				'filter' => \common\helpers\Arrays::statusYesNo(),
				'format' => 'boolean',
				'options' => ['width' => '80'],
			],
			[
				'attribute' => 'day_status',
				'filter' => \common\helpers\Arrays::statusYesNo(),
				'format' => 'boolean',
				'options' => ['width' => '80'],
			],
			'height',
			'width',
			[
				'attribute' => 'id',
				'options' => ['width' => '60'],
			],
		],
	]); ?>
</div>
