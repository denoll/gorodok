<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\konkurs\KonkursSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['left'] = true;
$this->params['right'] = true;

$cur_cat_slug = Yii::$app->request->get('cat');
$cur_cat = Yii::$app->session->get('cat');


$this->title = 'Конкурсы для жителей Тынды';
$mk = 'конкурсы в Тынде, соревнования в Тынде, конкурсы, соревнования, состязания';
$md = 'конкурсы, соревнования, состязания проводимые для жителей города Тында';

$this->params['breadcrumbs'][] = ['label' => 'Все конкурсы', 'url' => ['/konkurs/konkurs/index']];
if(!empty($cur_cat_slug) && !empty($cur_cat)){
	$this->params['breadcrumbs'][] = ['label' => $cur_cat['name'], 'url' => ['/konkurs/konkurs/index', 'cat'=>$cur_cat['slug']]];
	$this->title = $cur_cat['name'] .' для жителей Тынды';
	$mk = $cur_cat['mk'] . ', ' . $mk;
	$md = $cur_cat['md'] . ', ' . $md;
}

if (!empty($md)) {
	$this->registerMetaTag(['content' => Html::encode($md), 'name' => 'description']);
}
if (!empty($mk)) {
	$this->registerMetaTag(['content' => Html::encode($mk), 'name' => 'keywords']);
}



?>
<div class="konkurs-index">

	<h1 class="header-title"><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_search', ['model' => $searchModel]); ?>

	<?= \yii\widgets\ListView::widget([
		'dataProvider' => $dataProvider,
		'itemView' => '_item',
		'layout' => '<div class="sorter-block"><i class="small-text">Сортировать:</i> {sorter} {summary} {pager}</div> {items} {pager}',
	]); ?>

</div>
