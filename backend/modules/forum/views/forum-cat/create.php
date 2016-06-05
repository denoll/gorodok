<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Forums */

$this->title = 'Новая категория форума';
$this->params['breadcrumbs'][] = ['label' => 'категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forums-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
