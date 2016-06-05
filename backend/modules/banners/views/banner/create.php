<?php
/* @var $this yii\web\View */
/* @var $model common\models\WidgetBanner */

$this->title = 'Создание нового виджета баннеров';
$this->params['breadcrumbs'][] = ['label' => 'Все баннеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-banner-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
