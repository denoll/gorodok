<?php
use yii\helpers\Html;

$this->params['left'] = true;
$this->params['right'] = true;
$this->title = 'Тег: '. $tag['name'];
$m_d = 'Теги портала Наша Тында';
$m_k = 'Теги портала Наша Тында';
if (!empty($m_d)) {
    $this->registerMetaTag(['content' => Html::encode($m_d), 'name' => 'description']);
}
if (!empty($m_kw)) {
    $this->registerMetaTag(['content' => Html::encode($m_kw), 'name' => 'keywords']);
}

$this->params['breadcrumbs'][] = ['label' => 'Все теги', 'url' => ['all-tags']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tags-default-index">
    <h1><?=$this->title?></h1>
    <div class="row">
        <?php foreach ($model as $item) {
            if(!empty($item['news'])){$path = '/news/news/view'; $razdel = 'Новости';}
            if(!empty($item['page'])){$path = '/page/page/view'; $razdel = 'Статьи';}
            if(!empty($item['afisha'])){$path = '/afisha/afisha/view'; $razdel = 'Афиша';}
            if(!empty($item['letters'])){$path = '/letters/letters/view'; $razdel = 'Письма';}
            if(!empty($item['forum'])){$path = '/forum/forum/theme'; $razdel = 'Форум тема';}
            ?>

            <div class="col-md-6">
                <div class="tag-box tag-box-v3 margin-bottom-10">
                    <h2 style="margin: 0; font-size: 1.2em;"><?= Html::a($item['title'],[$path,'id'=>$item['alias']]) ?></h2>
                    <i class="small-text"><?=$razdel?></i>
                </div>
            </div>

        <?php } ?>
    </div>
</div>
