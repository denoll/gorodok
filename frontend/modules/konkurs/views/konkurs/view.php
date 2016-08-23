<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\konkurs\Konkurs */
/* @var $dataProvider yii\data\ActiveDataProvider */


//$this->params['left'] = true;
$this->params['right'] = true;

Yii::$app->session->remove('id_konkurs');
Yii::$app->session->set('id_konkurs', $model->id);

$cur_cat_slug = Yii::$app->request->get('cat');
$cur_cat = $model->cat;

$mk = $model->mk;
$md = $model->md;

$this->title = 'Конкурс: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Все конкурсы', 'url' => ['index']];
if(!empty($cur_cat_slug) && !empty($cur_cat)){
	$this->params['breadcrumbs'][] = ['label' => $cur_cat['name'], 'url' => ['/konkurs/konkurs/index', 'cat'=>$cur_cat['slug']]];
	$mk = $mk . ', ' . $cur_cat['mk'];
	$md = $md . ', ' . $cur_cat['md'];
}
$this->params['breadcrumbs'][] = $this->title;

if (!empty($md)) {
	$this->registerMetaTag(['content' => Html::encode($md), 'name' => 'description']);
}
if (!empty($mk)) {
	$this->registerMetaTag(['content' => Html::encode($mk), 'name' => 'keywords']);
}


?>
<div class="konkurs-view">
	<?= $this->render('_searchItem', ['model' => $searchModel]); ?>
	<div class="row" style="padding-top: 5px;">
		<div class="container-fluid">
			<div class="tag-box tag-box-v4 no-margin">
				<h1 class="no-margin"><?= Html::encode($model['title']) ?></h1>
				<?= $model['description'] ?><br>
				<?= Html::a('Принять участие в конкурсе',['/konkurs/item/create'],['class'=>'btn-u btn-block']); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<?= \yii\widgets\ListView::widget([
			'dataProvider' => $dataProvider,
			'itemView' => '_itemItem',
			'viewParams' => [
				'konkurs' => $model,
			],
			'layout' => '<div class="col-md-12"><div class="sorter-block"><i class="small-text">Сортировать:</i> {sorter} {pager}</div> </div> {items} <div class="col-md-12">{pager}</div>',
		]); ?>
	</div>
</div>
<?php
$this->registerJsFile('/js/jquery.matchHeight.min.js',[
	'depends' => [
		\yii\bootstrap\BootstrapAsset::className()
	],
]);

$js = <<<JS
	$(document).ready(function(){
		$(function() {
			$('.for-one-height').matchHeight();
		});
	});
JS;
$this->registerJS($js, \yii\web\View::POS_END);

?>
