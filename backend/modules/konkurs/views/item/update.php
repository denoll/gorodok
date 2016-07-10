<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\konkurs\KonkursItem */
/* @var $users common\models\users\User */

$this->title = 'Изменение элемента конкурса: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Все элементы конкурсов', 'url' => ['index']];
?>
<div class="konkurs-item-update">
	<?= $this->render('_form', [
		'model' => $model,
		'users' => $users,
	]) ?>
</div>
