<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\konkurs\KonkursItem */
/* @var $konkurs common\models\konkurs\Konkurs */
/* @var $users common\models\users\User */

$this->params['left'] = true;
$this->params['right'] = true;

$this->title = 'Изменение элемента конкурса: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Все конкурсы', 'url' => ['/konkurs/konkurs/index']];
if(!empty($konkurs->cat)){
	$this->params['breadcrumbs'][] = ['label' => $konkurs->cat->name, 'url' => ['/konkurs/konkurs/index', 'cat'=>$konkurs->cat->slug]];
}
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/konkurs/konkurs/view', 'id'=>$konkurs->slug]];
?>
<div class="konkurs-item-update">
	<h1><?= $this->title ?></h1>
	<?= $this->render('_form', [
		'model' => $model,
		'users' => $users,
		'konkurs' => $konkurs,
	]) ?>
</div>
