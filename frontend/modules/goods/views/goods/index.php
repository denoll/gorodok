<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\goods\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$ses = Yii::$app->session;
$ses->open();
$cur_cat = $ses->get('current_cat');
$parent_cat = $ses->get('parent_cat');
$first_child = $ses->get('first_child');
$ses->close();
$this->title = !empty($cur_cat) ? $cur_cat['name'] : 'Товары';
$this->params['left'] = true;
$this->params['right'] = true;
$seo = Yii::$app->seo->getByKey('goods_index');
$mk = $seo->kw;
$md = $seo->desc;
if(!empty($cur_cat)){
    $this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
    $m_kw = $cur_cat['m_keyword']. ', ' . $seo->kw;
    $m_d = $cur_cat['m_description']. '. ' . $seo->desc;
}else{
	$m_kw = $seo->kw;
	$m_d = $seo->desc;
}

if(!empty($parent_cat)){
    foreach($parent_cat as $item){
        $this->params['breadcrumbs'][] = ['label' => $item['name'], 'url' => ['index', 'cat'=>$item['alias']]];
    }
}
$this->params['breadcrumbs'][] = $this->title;
if (!empty($m_d)) {
    $this->registerMetaTag(['content' => Html::encode($m_d), 'name' => 'description']);
}
if (!empty($m_kw)) {
    $this->registerMetaTag(['content' => Html::encode($m_kw), 'name' => 'keywords']);
}

?>
<?php echo $this->render('_category', [
	'cat' => $cat,
	'cur_cat' => $cur_cat,
	'first_child' => $first_child,
]); ?>

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


