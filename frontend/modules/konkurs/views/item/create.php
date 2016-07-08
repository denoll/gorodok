<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\konkurs\KonkursItem */
/* @var $users common\models\users\User */

$this->title = 'Создание нового элемента конкурса';
$this->params['breadcrumbs'][] = ['label' => 'Все конкурсы', 'url' => ['index']];

?>
<div class="konkurs-item-create">
	<?= $this->render('_form', [
		'model' => $model,
		'users' => $users,
	]) ?>
</div>
