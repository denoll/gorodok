<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\jobs\JobResume */

$this->title = 'Создание новой вакансии';
$this->params['breadcrumbs'][] = ['label' => 'Мои вакансии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-resume-create">

    <div class="panel panel-dark">

        <div class="panel-heading">
            <h1 class="panel-title" style="margin: 0px; font-size: 1.2em;"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">

            <?= $this->render('_form', [
                'model' => $model,
                'cat' => $cat,
            ]) ?>
        </div>
    </div>
</div>
