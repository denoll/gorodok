<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\widgets\Arrays;
use yii\widgets\LinkPager;

$this->params['left'] = true;
$this->params['right'] = true;
$this->title = 'Мои коллективные письма';
$this->params['breadcrumbs'][] = ['label' => 'Мой профиль', 'url' => [Url::home() . 'profile/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="jobs-default-index">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h1 class="panel-title" style="margin: 0px; font-size: 1.2em;"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="panel-body">
                <?= Html::a('Мои коллективные письма', ['/letters/letters/my-letters'], ['class' => 'btn-u btn-u-dark-blue']) ?>
                <?= Html::a('<i class="fa fa-plus"></i>  Предложить новое коллективное письмо', ['/letters/letters/create'], ['class' => 'btn-u btn-u-dark']) ?>
                <?= LinkPager::widget([
                    'pagination' => $pages,
                ]); ?>
                <br><br>

                <?php $form = ActiveForm::begin(); ?>
                <div class="container-fluid s-results margin-bottom-50">
                    <?php foreach ($model as $item) { ?>
                        <div class="inner-results">
                            <h3 style="margin:0px; font-size: 1.2em;"><?= Html::a($item['title'], ['/letters/letters/view', 'id' => $item['alias']], []) ?></h3>
                            <ul class="list-inline">
                                <?php if (!$item['status']) { ?>
                                    <li>
                                        <i>Редактировать письмо можно только до момента его публикации на сайте.</i>
                                    </li>
                                    <li>
                                        <div class="btn-group" style="margin: 5px 0px;">
                                            <?= Html::a('Редактировать', ['/letters/letters/update', 'id' => $item['id']], ['class' => 'btn-u btn-u-xs  btn-u-default']) ?>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                            <ul class="list-inline up-ul">
                                <li>
                                    <i class="small-text">‎Дата письма:</i>&nbsp;
                                    <span><?= Yii::$app->formatter->asDate($item['created_at'], 'long') ?></span>
                                </li>
                                <li>
                                    <i class="small-text">Опубликовано:</i>&nbsp;
                                    <span id="span_updated_at_<?= $item['id'] ?>"><?= $item['publish'] != null ? ' с ' . Yii::$app->formatter->asDate($item['publish'], 'long') : '<strong>письмо ещё не опубликовано.</strong>&nbsp;' ?></span>
                                </li>
                                <?php if ($item['status']) { ?>
                                    <li>
                                        <i class="small-text">Статус письма:</i>&nbsp;
                                        <span><?= Arrays::getLetterStage($item['stage']) ?></span>

                                    </li>
                                <?php } else { ?>
                                    <br>‎<i>Письмо будет опубликовано после его проверки администрацией сайта. </i>
                                <?php } ?>
                            </ul>

                        </div>
                        <hr>
                    <?php } ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
<?php
$this->registerJsFile('/js/date.format.js', ['depends' => [\yii\web\YiiAsset::className()]]);
//$this->registerJsFile('/js/ajax/letters.js', ['depends' => [\yii\web\YiiAsset::className()]]);
?>