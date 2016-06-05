<?php
/**
 * denoll <denoll@denoll.ru>
 * @var \yii\data\ArrayDataProvider $dataProvider
 */
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Кеш';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            'class',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{flush-cache}',
                'buttons'=>[
                    'flush-cache'=>function ($url, $model) {
                        return \yii\helpers\Html::a('<i class="fa fa-refresh"></i>', $url, [
                            'title' => 'Сбросить кеш',
                            'data-confirm' => 'Вы действительно хотите сбросить кеш?'
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>

    <div class="row">
        <div class="col-xs-6">
            <h4><?php echo 'Удаление кеша по ключу' ?></h4>
            <?php \yii\bootstrap\ActiveForm::begin([
                'action'=>\yii\helpers\Url::to('flush-cache-key'),
                'method'=>'get',
                'layout'=>'inline',
            ]) ?>
                <?php echo Html::dropDownList(
                    'id', null, \yii\helpers\ArrayHelper::map($dataProvider->allModels, 'name', 'name'),
                    ['class'=>'form-control', 'prompt'=> 'Выберите кеш'])
                ?>
                <?php echo Html::input('string', 'key', null, ['class'=>'form-control', 'placeholder' => 'Ключ']) ?>
                <?php echo Html::submitButton('Сбросить кеш', ['class'=>'btn btn-danger']) ?>
            <?php \yii\bootstrap\ActiveForm::end() ?>
        </div>
        <div class="col-xs-6">
            <h4><?php echo 'Тег' ?></h4>
            <?php \yii\bootstrap\ActiveForm::begin([
                'action'=>\yii\helpers\Url::to('flush-cache-tag'),
                'method'=>'get',
                'layout'=>'inline'
            ]) ?>
                <?php echo Html::dropDownList(
                    'id', null, \yii\helpers\ArrayHelper::map($dataProvider->allModels, 'name', 'name'),
                    ['class'=>'form-control', 'prompt'=> 'Выберите кеш']) ?>
                <?php echo Html::input('string', 'tag', null, ['class'=>'form-control', 'placeholder' => 'Тег']) ?>
                <?php echo Html::submitButton('Сбросить кеш', ['class'=>'btn btn-danger']) ?>
            <?php \yii\bootstrap\ActiveForm::end() ?>
        </div>
    </div>

</div>
