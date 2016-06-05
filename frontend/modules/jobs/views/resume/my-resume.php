<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\widgets\Arrays;

$this->params['left'] = true;

$this->title = 'Мои резюме';
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
            <?= \frontend\widgets\ProfileTextBlock::init('Для полноценного отображения Ваших данных в резюме, пожалуйста заполните расширенные сведения о себе, а также об образовании и об опыте работы.','Важно!') ?>
            <?= \frontend\widgets\ProfileMenu::Menu() ?>
            <?= Html::a('<i class="fa fa-plus"></i>  Добавить резюме', [Url::home() . 'jobs/resume/create'], ['class' => 'btn-u btn-u-dark']) ?>
            <br><br>

            <?php $form = ActiveForm::begin(); ?>
            <div class="container-fluid s-results margin-bottom-50">
                <?php foreach ($model as $item) { ?>
                    <div class="inner-results">
                        <ul class="list-inline">
                            <li>
                                <h3 style="margin:0px;"><?= Html::a($item['title'], [Url::home() . 'jobs/resume/view', 'id' => $item['id']], []) ?></h3>
                            </li>
                            <li>
                                <div class="btn-group">
                                    <?php
                                    if ($item['status'] == 1) {
                                        echo '<span onclick="changeStatus(' . $item['id'] . ')" id="status-btn-' . $item['id'] . '" class="btn-u btn-u-xs  btn-u-green" title="Изменить статус на - Видно только мне">Видно всем</span>';
                                        echo '<span onclick="changeUp(' . $item['id'] . ')" id="up-btn-' . $item['id'] . '" class="btn-u btn-u-xs  btn-u-orange" title="Поднять резюме на верх">Поднять на верх</span>';
                                        echo '<span onclick="changeVip(' . $item['id'] . ')" id="vip-btn-' . $item['id'] . '" class="btn-u btn-u-xs  btn-u-dark-blue" title="Выделить резюме цветом">Выделить цветом</span>';
                                    } else {
                                        echo '<span onclick="changeStatus(' . $item['id'] . ')" id="status-btn-' . $item['id'] . '" class="btn-u btn-u-xs  btn-u-red" title="Изменить статус на - Видно всем">Видно только мне</span>';
                                    }

                                    echo Html::a('Редактировать',[Url::home() . 'jobs/resume/update', 'id' => $item['id']], ['class'=>'btn-u btn-u-xs  btn-u-default']);
                                    echo Html::a('Удалить',[Url::home() . 'jobs/resume/delete', 'id' => $item['id']], ['class'=>'btn-u btn-u-xs  btn-u-danger','data' => [
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
                        <p><?= $item['description'] != null || $item['description'] != '' ? 'Усточнение должности: ' . $item['description'] : '' ?></p>
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
$this->registerJsFile('/js/ajax/resume.js', ['depends' => [\yii\web\YiiAsset::className()]]);
?>