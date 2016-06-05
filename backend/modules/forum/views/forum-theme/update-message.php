<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ForumMessage */



$this->title = 'Редактирование сообщения в теме: ' . ' ' . $theme->name;
$this->params['breadcrumbs'][] = ['label' => 'Темы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Сообщения', 'url' => ['message', 'id'=> $theme->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="forum-message-update">

    <?= $this->render('_formMessage', [
        'model' => $model,
	    'theme' => $theme,
    ]) ?>

</div>
