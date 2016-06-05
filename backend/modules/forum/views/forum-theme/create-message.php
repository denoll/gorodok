<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ForumMessage */

	$this->title = 'Создание сообщения в теме: ' . ' ' . $theme->name;
	$this->params['breadcrumbs'][] = ['label' => 'Темы', 'url' => ['index']];
	$this->params['breadcrumbs'][] = ['label' => 'Сообщения', 'url' => ['message', 'id'=> $theme->id]];
	$this->params['breadcrumbs'][] = 'Создание';
?>
<div class="forum-message-create">

    <?= $this->render('_formMessage', [
        'model' => $model,
	    'theme' => $theme,
    ]) ?>

</div>
