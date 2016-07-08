<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\konkurs\Konkurs */

$this->params['left'] = true;
$this->params['right'] = true;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Все конкурсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="konkurs-view">

	<h1><?= Html::encode($this->title) ?></h1>
	<div class="row">
		<?= \yii\widgets\ListView::widget([
			'dataProvider' => $dataProvider,
			'itemView' => '_itemItem',
			'layout' => '<div class="col-md-12"><div class="sorter-block"><i class="small-text">Сортировать:</i> {sorter} {summary} {pager}</div> </div> {items} <div class="col-md-12">{pager}</div>',
		]); ?>
	</div>
</div>
