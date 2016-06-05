<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\med\Doctors */

$this->title = 'Создание заявки на добавление в каталог врачей';
$this->params['breadcrumbs'][] = ['label' => 'Врачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doctors-create">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h1 style="margin: 0px; font-size: 1.2em;"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
