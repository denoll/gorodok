<?php
use yii\helpers\Html;
$this->params['left'] = true;
$this->params['right'] = true;
$this->title = 'Все теги';
$m_d = 'Теги портала Наша Тында';
$m_k = 'Теги портала Наша Тында';
if (!empty($m_d)) {
    $this->registerMetaTag(['content' => Html::encode($m_d), 'name' => 'description']);
}
if (!empty($m_kw)) {
    $this->registerMetaTag(['content' => Html::encode($m_kw), 'name' => 'keywords']);
}

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tags-default-index">
    <h1>Все теги</h1>
    <ul class="list-inline tags-v2 margin-bottom-40">
        <?php foreach ($model as $item) { ?>
        <li><?= \yii\helpers\Html::a($item['name'],['/tags/tags/index', 'tag'=>$item['name']]) ?></li>
        <?php } ?>
    </ul>
</div>
