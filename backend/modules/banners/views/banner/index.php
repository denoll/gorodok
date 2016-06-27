<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \common\models\banners\Banner;

/* @var $this yii\web\View */
/* @var $searchModel common\models\banners\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Блоки для рекламных баннеров';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-banner-index">

	<p>
		<?php echo Html::a('Создать новый блок для рекламных баннеров', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?php echo GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}'
			],
			'name',
			'key',
			[
				'class' => \common\grid\EnumColumn::className(),
				'attribute' => 'stage',
				'enum' => Banner::bannerStages(),
			],
			[
				'class' => \common\grid\EnumColumn::className(),
				'attribute' => 'status',
				'enum' => Banner::bannerStatuses(),
				'label'=>'Статус блока'
			],
			'height',
			'width'
		],
	]); ?>

</div>
