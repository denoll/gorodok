<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ForumTheme */

$this->title = 'Редактирование темы: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Темы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="forum-theme-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
