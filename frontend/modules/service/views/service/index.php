<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\goods\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$cur_cat = Yii::$app->session->get('current_cat');
$parent_cat = Yii::$app->session->get('parent_cat');
$first_child = Yii::$app->session->get('first_child');

$this->title = 'Оказание услуг';
$this->params['left'] = true;
$this->params['right'] = true;
if (!empty($cur_cat)) {
	$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
	$m_kw = $cur_cat['m_keyword'];
	$m_d = $cur_cat['m_description'];
} else {
	$m_kw = 'каталог, услуги, услуги в тынде, оказать услуги тынде, каталог услуг в тынде';
	$m_d = 'Каталог объявлений об услугах в Тынде. Здесь Вы можете подать свое объявление об оказании услуг.';
}

if (!empty($parent_cat)) {
	foreach ($parent_cat as $item) {
		$this->params['breadcrumbs'][] = ['label' => $item['name'], 'url' => ['index', 'cat' => $item['alias']]];
	}
}
if (!empty($cur_cat)) {
	$this->params['breadcrumbs'][] = ['label' => $cur_cat['name'], 'url' => ['index', 'cat' => $cur_cat['alias']]];
} else {
	$this->params['breadcrumbs'][] = $this->title;
}

if (!empty($m_d)) {
	$this->registerMetaTag(['content' => Html::encode($m_d), 'name' => 'description']);
}
if (!empty($m_kw)) {
	$this->registerMetaTag(['content' => Html::encode($m_kw), 'name' => 'keywords']);
}
?>

<div class="panel panel-default" style="margin-bottom: 5px;">
	<div class="panel-heading" style=" padding: 5px 5px 5px 12px;">
		<h1 class="panel-title" style="display: inline-table;"><?= Html::encode($this->title) ?></h1>
	</div>

	<?php if (!empty($first_child)) { ?>
		<div class="panel-body" style=" padding: 5px 12px 12px 12px;">
			<label class="small-text">Подкатегории:</label>
			<ul class="list-inline" style="margin-bottom: 0;">
				<?php foreach ($first_child as $item) { ?>
					<li style="padding: 0;"><?= Html::a($item['name'], ['index', 'cat' => $item['alias']], ['class' => 'btn-u btn-u-sm btn-u-default']) ?></li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>
</div>

<?php
/*echo $this->render("_category",[
	'cat' => $cat,
	'cur_cat' => $cur_cat,
	'first_child' => $first_child,
	'title' => $this->title,
]);*/
if ($items) {
	echo $this->render('_search', [
		'model' => $searchModel,
		'first_child' => $first_child,
	]);
	echo ListView::widget([
		'dataProvider' => $dataProvider,
		'itemView' => '_item',
		'layout' => '<div class="sorter-block"><i class="small-text">Сортировать:</i> {sorter} {summary} {pager}</div> {items} {pager}',
	]); ?>
<?php } else { ?>
	<div class="alert alert-success fade in">
		<strong>Ничего не найдено!</strong>
	</div>
<?php } ?>



