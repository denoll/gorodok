<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\jobs\JobResume */

$this->title = 'Изменение резюме: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Мои резюме', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="job-resume-update">

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
