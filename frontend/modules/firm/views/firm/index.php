<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use common\models\users\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\firm\FirmSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['left'] = true;
$this->params['right'] = true;

$model = $dataProvider->getModels();
$current_cat = Yii::$app->session->get('current_cat');

$this->title = 'Фирмы';
if(!empty($current_cat)) $this->params['breadcrumbs'][] = ['label' => $current_cat['name'], 'url' => ['index', 'cat' => $current_cat['slug']]];
$this->params['breadcrumbs'][] = $this->title;

$seo = Yii::$app->seo->getByKey('firm_index');
$mk = $seo->kw;
$md = $seo->desc;

if (!empty($current_cat)) {
	if(empty($current_cat['mk'])) $mk = $current_cat['name'] . ', ' . $mk;
	if(empty($current_cat['md'])) $md = $current_cat['name'] . ', ' . $md;

	$mk = $current_cat['mk'] . ', ' . $mk;
	$md = $current_cat['md'] . '. ' . $md;
}

if (!empty($md)) {
	$this->registerMetaTag(['content' => Html::encode($md), 'name' => 'description']);
}
if (!empty($mk)) {
	$this->registerMetaTag(['content' => Html::encode($mk), 'name' => 'keywords']);
}

?>
<div class="firm-index">
	<?php if ($items) {
		echo $this->render('_search', [
			'model' => $searchModel,
			'first_child' => $first_child,
		]);
		echo ListView::widget([
			'dataProvider' => $dataProvider,
			'itemView' => '_item',
			'layout' => '<div class="sorter-block"><i class="small-text">Сортировать:</i> {sorter} {summary} {pager}</div> {items} {pager}',
		]);
	} else { ?>
		<div class="alert alert-success fade in">
			<strong>Ничего не найдено!</strong>
		</div>
	<?php } ?>
</div>
