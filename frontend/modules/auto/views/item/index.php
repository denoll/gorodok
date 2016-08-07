<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\auto\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->params['left'] = true;
$this->params['right'] = true;

$this->title = 'Объявления о продаже автомобилей в Тынде';
$this->params['breadcrumbs'][] = 'Поиск автомобилей';
$seo = Yii::$app->seo->getByKey('auto_index');
$m_kw = $seo->kw;
$m_d = $seo->desc;

if (!empty($m_d)) {
	$this->registerMetaTag(['content' => Html::encode($m_d), 'name' => 'description']);
}
if (!empty($m_kw)) {
	$this->registerMetaTag(['content' => Html::encode($m_kw), 'name' => 'keywords']);
}

?>
<div class="auto-item-index">

	<div class="row">
		<div class="container-fluid">
			<hr class="no-margin">
			<h1 class="header-title">Поиск автомобилей: </h1>
			<hr class="no-margin">
		</div>
	</div>
	<?php echo $this->render('_search', [
			'model' => $searchModel,
		]);?>
	<?php if ($items) { ?>
		<?= ListView::widget([
			'dataProvider' => $dataProvider,
			'itemView' => '_item',
			'layout' => '<div class="sorter-block"><i class="small-text">Сортировать:</i> {sorter} {pager}</div> {items} {pager}',
		]); ?>
	<?php } else { ?>
		<div class="alert alert-success fade in">
			<strong>Ничего не найдено!</strong>
		</div>
	<?php } ?>
</div>
