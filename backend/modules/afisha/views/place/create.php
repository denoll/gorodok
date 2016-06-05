<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\afisha\AfishaPlace */

$this->title = 'Создание нового места мероприятия';
$this->params['breadcrumbs'][] = ['label' => 'Места мероприятий', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="afisha-place-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
