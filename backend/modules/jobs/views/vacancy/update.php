<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\jobs\JobVacancy */

$this->title = 'Update Job Vacancy: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Job Vacancies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="job-vacancy-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
