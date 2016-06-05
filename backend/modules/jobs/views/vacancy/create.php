<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\jobs\JobVacancy */

$this->title = 'Create Job Vacancy';
$this->params['breadcrumbs'][] = ['label' => 'Job Vacancies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-vacancy-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
