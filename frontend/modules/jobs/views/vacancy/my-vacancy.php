<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\widgets\Arrays;

$this->params['left'] = true;

$this->title = 'Мои вакансии';
$this->params['breadcrumbs'][] = ['label' => 'Мой профиль', 'url' => [Url::home() . 'profile/index']];
$this->params['breadcrumbs'][] = $this->title;
//'education', 'skills', 'about', 'experience'
?>

<div class="jobs-default-index">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h1 class="panel-title" style="margin: 0px; font-size: 1.2em;"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">
            <?= Html::a('Сведения о компании', [Url::home() . 'profile/company'], ['class' => 'btn-u btn-u-purple']) ?>
            <?= Html::a('Вакансии', [Url::home() . 'jobs/vacancy/my-vacancy'], ['class' => 'btn-u btn-u-dark-blue']) ?>
            <?= Html::a('<i class="fa fa-plus"></i>  Добавить вакансию', [Url::home() . 'jobs/vacancy/create'], ['class' => 'btn-u btn-u-dark']) ?>
            <br><br>
            <div id="m-up-success" class="alert alert-info fade in alert-dismissable" style="display: none;">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <strong>Объявление поднято на верх!</strong>
                С вашего счета списано 30руб.
            </div>
            <div id="m-up-danger" class="alert alert-danger fade in alert-dismissable" style="display: none;">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <strong>Объявление не поднято на верх!</strong>
                На вашем счёте недостаточно средств.
            </div>
            <div id="m-vip-success" class="alert alert-info fade in alert-dismissable" style="display: none;">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <strong>Объявление выделено цветом на следующие 7 дней!</strong>
                С вашего счета списано 30руб.
            </div>
            <div id="m-vip-danger" class="alert alert-danger fade in alert-dismissable" style="display: none;">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <strong>Объявление не выделено!</strong>
                На вашем счёте недостаточно средств.
            </div>
            <br>
            <?php $form = ActiveForm::begin(); ?>
            <div class="container-fluid s-results margin-bottom-50">
                <?php foreach ($model as $item) { ?>
                    <div class="inner-results">
                        <ul class="list-inline">
                            <li>
                                <h3 style="margin:0px;"><?= Html::a($item['title'], [Url::home() . 'jobs/vacancy/view', 'id' => $item['id']], []) ?></h3>
                            </li>
                            <li>
                                <div class="btn-group">
                                    <?php
                                    if ($item['status'] == 1) {
                                        echo '<span onclick="changeStatus(' . $item['id'] . ')" id="status-btn-' . $item['id'] . '" class="btn-u btn-u-xs  btn-u-green" title="Изменить статус на - Видно только мне">Видно всем</span>';
                                        echo '<span onclick="changeUp(' . $item['id'] . ')" id="up-btn-' . $item['id'] . '" class="btn-u btn-u-xs  btn-u-orange" title="Поднять вакансию на верх">Поднять на верх</span>';
                                        echo '<span onclick="changeVip(' . $item['id'] . ')" id="vip-btn-' . $item['id'] . '" class="btn-u btn-u-xs  btn-u-dark-blue" title="Выделить вакансию цветом">Выделить цветом</span>';
                                    } else {
                                        echo '<span onclick="changeStatus(' . $item['id'] . ')" id="status-btn-' . $item['id'] . '" class="btn-u btn-u-xs  btn-u-red" title="Изменить статус на - Видно всем">Видно только мне</span>';
                                    }

                                    echo Html::a('Редактировать',[Url::home() . 'jobs/vacancy/update', 'id' => $item['id']], ['class'=>'btn-u btn-u-xs  btn-u-default']);
                                    echo Html::a('Удалить',[Url::home() . 'jobs/vacancy/delete', 'id' => $item['id']], ['class'=>'btn-u btn-u-xs  btn-u-danger','data' => [
                                        'confirm' => 'Вы действительно хотите удалить это объявление?',
                                        'method' => 'post',
                                    ]]);
                                    ?>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-inline up-ul">
                            <li>З/п: <strong><?= $item['salary'] != null ? number_format($item['salary'],2,',',"'").' руб.' : 'Не указана' ?></strong> ‎</li>
                            <li>
                                <i class="small-text">‎Дата резюме:</i>&nbsp;
                                <?= Yii::$app->formatter->asDate($item['created_at'], 'long') ?>
                            </li>
                            <li>
                            <span>
                                <i class="small-text">‎Поднято на верх:</i>&nbsp;
                                <span id="span_updated_at_<?=$item['id']?>"><?= $item['updated_at'] != $item['created_at'] ? Yii::$app->formatter->asDate($item['updated_at'], 'long') : 'Резюме еще не поднимали' ?></span>
                            ‎</li>
                            <li>
                                <i class="small-text">Выделено:</i>&nbsp;
                                <span id="span_vip_date_<?=$item['id']?>"><?= $item['vip_date'] != null ? Yii::$app->formatter->asDate($item['vip_date'], 'long') : 'Резюме еще не выделяли' ?></span>
                                ‎</li>
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
$this->registerJsFile('/js/ajax/vacancy.js', ['depends' => [\yii\web\YiiAsset::className()]]);
?>