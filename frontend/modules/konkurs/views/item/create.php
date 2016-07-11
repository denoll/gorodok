<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\konkurs\KonkursItem */
/* @var $konkurs common\models\konkurs\Konkurs */
/* @var $users common\models\users\User */
$this->params['left'] = true;
$this->params['right'] = true;

$this->title = 'Добавление данных в конкурс: '.$konkurs->name;
$this->params['breadcrumbs'][] = ['label' => 'Все конкурсы', 'url' => ['/konkurs/konkurs/index']];
$this->params['breadcrumbs'][] = ['label' => $konkurs->name, 'url' => ['/konkurs/konkurs/view', 'id'=>$konkurs->slug]];

?>

<div class="konkurs-item-create">

	<h1><?= $this->title ?></h1>
	
	<?= $this->render('_form', [
		'model' => $model,
		'users' => $users,
		'konkurs' => $konkurs,
	]) ?>
</div>
