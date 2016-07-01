<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\firm\Firm */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Все фирмы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="firm-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Удалить', ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => 'Are you sure you want to delete this item?',
				'method' => 'post',
			],
		]) ?>
	</p>
	<?= \common\widgets\yamaps\YaMap::widget([
		'lat' => $model->lat,
		'lon' => $model->lon,
		'firm_name' => $model->name,
		'zoom' => 16,
	]); ?>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id',
			'id_cat',
			'id_user',
			'status',
			'show_requisites',
			'name',
			'tel',
			'email:email',
			'site',
			'logo',
			'address',
			'description:ntext',
			'created_at',
			'updated_at',
			'mk',
			'md',
		],
	]) ?>

</div>
