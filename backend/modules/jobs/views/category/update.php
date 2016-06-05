<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\jobs\JobCategory */

$this->title = 'Изменение сферы деятельности: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Сферы деятельности', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="job-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
