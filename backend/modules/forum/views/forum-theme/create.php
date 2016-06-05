<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ForumTheme */

$this->title = 'Создание темы';
$this->params['breadcrumbs'][] = ['label' => 'Темы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forum-theme-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
