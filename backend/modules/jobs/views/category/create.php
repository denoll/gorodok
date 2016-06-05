<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\jobs\JobCategory */

$this->title = 'Создание новой сферы деятельности';
$this->params['breadcrumbs'][] = ['label' => 'Сферы деятельности', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
