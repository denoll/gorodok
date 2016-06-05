<?php

use yii\helpers\Html;
use app\modules\letters\Module;

/* @var $this yii\web\View */
/* @var $model common\models\Letters */

$this->title = 'Изменить письмо: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Письма', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="letters-update">

    <?= $this->render('_form', [
        'model' => $model,
        'module' => $module,
    ]) ?>

</div>
