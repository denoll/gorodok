<?php

use yii\helpers\Html;
use app\modules\page\Module;

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = 'Изменить статью: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="page-update">

    <?= $this->render('_form', [
        'model' => $model,
        'module' => $module,
    ]) ?>

</div>
