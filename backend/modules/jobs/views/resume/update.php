<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\jobs\JobResume */

$this->title = 'Изменение резюме: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Резюме', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'изменение';
?>
<div class="job-resume-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
