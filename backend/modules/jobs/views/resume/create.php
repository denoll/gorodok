<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\jobs\JobResume */

$this->title = 'Создание нового резюме';
$this->params['breadcrumbs'][] = ['label' => 'Резюме', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-resume-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
