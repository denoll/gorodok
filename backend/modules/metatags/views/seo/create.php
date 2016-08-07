<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Metatags */

$this->title = 'Добавлнение метатегов на новую страницу';
$this->params['breadcrumbs'][] = ['label' => 'Все метатеги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metatags-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
