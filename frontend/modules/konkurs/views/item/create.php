<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\konkurs\KonkursItem */
/* @var $users common\models\users\User */
//$this->params['left'] = true;
$this->params['right'] = true;

$this->title = 'Добавление данных в конкурс: ';
$this->params['breadcrumbs'][] = ['label' => 'Все конкурсы', 'url' => ['index']];
echo $this->params['konkurs_id'];
?>
<div class="konkurs-item-create">
	<?= $this->render('_form', [
		'model' => $model,
		'users' => $users,
	]) ?>
</div>
