<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Extensions */

$this->title = 'Новое расширение';
$this->params['breadcrumbs'][] = ['label' => 'Расширения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="extensions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
