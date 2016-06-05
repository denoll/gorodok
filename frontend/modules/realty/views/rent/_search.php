<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\widgets\Arrays;
use common\widgets\RealtyArrays;

/* @var $this yii\web\View */
/* @var $model common\models\med\DoctorsSearch */
/* @var $form yii\widgets\ActiveForm */

$get_cat = Yii::$app->request->get('cat');
if (!empty($first_child)) {
    $data = \yii\helpers\ArrayHelper::map($first_child, 'alias', 'name');
} else {
    $data = false;
}

if(!empty($cur_cat)){
    $cur_cat['comfort'] ? $comfort = 'block' : $comfort = 'none';
    $cur_cat['repair'] ? $repair = 'block' : $repair = 'none';
    $cur_cat['resell'] ? $resell = 'block' : $resell = 'none';
    $cur_cat['type'] ? $type = 'block' : $type = 'none';
    $cur_cat['floor_home'] ? $floor_home = 'block' : $floor_home = 'none';
    $cur_cat['floor'] ? $floor = 'block' : $floor = 'none';
    $cur_cat['area_land'] ? $area_land = 'block' : $area_land = 'none';
    $cur_cat['area_home'] ? $area_home = 'block' : $area_home = 'none';
}else{
    $comfort = $repair = $resell = $type = $floor_home = $floor = $area_land = $area_home = 'none';
}


?>

<div class="doctor-search">
    <?php $form = ActiveForm::begin([
        'action' => empty($get_cat) ? ['index'] : ['index', 'cat'=>$get_cat],
        'method' => 'get',
    ]); ?>

    <div class="filter">
        <div class="filter_element col-md-12 side_left" style="margin-top: 5px;">
            <div class="input-group">
                <?= $form->field($model, 'search_field', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'Введите искомую информацию или ее часть ...']])->label(false) ?>
                <span class="input-group-btn"><?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;&nbsp;Найти', ['class' => 'btn-u']) ?></span>
            </div>
        </div>
        <div class="row">
            <div class=" container-fluid">
                <?php /* if ($data) { ?>
                    <div class="filter_element col-sm-6 side_left">
                        <?= $form->field($model, 'cat')->widget(Select2::classname(), [
                            'data' => $data,
                            'hideSearch' => false,
                            'options' => ['placeholder' => 'Выбор подкатегории...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Подкатегория'); ?>
                    </div>
                <?php }*/ ?>
                <div id="resell" class="filter_element col-sm-4 side_left" style="display: <?=$resell?>">
                    <?= $form->field($model, 'resell')->widget(Select2::classname(), [
                        'data' => \yii\helpers\ArrayHelper::map(RealtyArrays::realtyResell(), 'id', 'name'),
                        'hideSearch' => true,
                        'options' => ['placeholder' => 'Выбрите ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Тип жилья'); ?>
                </div>
                <div id="type" class="filter_element col-sm-4 side_left" style="display: <?=$type?>">
                    <?= $form->field($model, 'type')->widget(Select2::classname(), [
                        'data' => \yii\helpers\ArrayHelper::map(RealtyArrays::homeTypes(), 'id', 'name'),
                        'hideSearch' => true,
                        'options' => ['placeholder' => 'Выбрите ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Тип строения'); ?>
                </div>
                <div id="repair" class="filter_element col-sm-4 side_left" style="display: <?=$repair?>">
                    <?= $form->field($model, 'repair')->widget(Select2::classname(), [
                        'data' => \yii\helpers\ArrayHelper::map(RealtyArrays::realtyRepair(), 'id', 'name'),
                        'hideSearch' => true,
                        'options' => ['placeholder' => 'Выбрите ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Состояние ремонта'); ?>
                </div>
                <div id="cost" class="filter_element col-sm-4 side_left">
                    <label class="control-label" for="el-cost">Стоимость объекта (руб):</label>
                    <table id="el-cost">
                        <tr>
                            <td><?= $form->field($model, 'cost_min', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'от']])->label(false) ?></td>
                            <td><?= $form->field($model, 'cost_max', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'до']])->label(false) ?></td>
                        </tr>
                    </table>
                </div>
                <div id="distance" class="filter_element col-sm-4 side_left" style="display: <?=$distance?>">
                    <label class="control-label" for="el-distance">Удаленность от города (км):</label>
                    <table id="el-distance">
                        <tr>
                            <td><?= $form->field($model, 'distance_min', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'от']])->label(false) ?></td>
                            <td><?= $form->field($model, 'distance_max', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'до']])->label(false) ?></td>
                        </tr>
                    </table>
                </div>
                <div id="area_home" class="filter_element col-sm-4 side_left" style="display: <?=$area_home?>">
                    <label class="control-label" for="el-area">Площадь объекта (м2):</label>
                    <table id="el-area">
                        <tr>
                            <td><?= $form->field($model, 'area_home_min', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'от']])->label(false) ?></td>
                            <td><?= $form->field($model, 'area_home_max', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'до']])->label(false) ?></td>
                        </tr>
                    </table>
                </div>
                <div id="area_land" class="filter_element col-sm-4 side_left" style="display: <?=$area_land?>">
                    <label class="control-label" for="el-area_land">Площадь участка (сотка):</label>
                    <table id="el-area_land">
                        <tr>
                            <td><?= $form->field($model, 'area_land_min', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'от']])->label(false) ?></td>
                            <td><?= $form->field($model, 'area_land_max', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'до']])->label(false) ?></td>
                        </tr>
                    </table>
                </div>
                <div id="floor" class="filter_element col-sm-4 side_left" style="display: <?=$floor?>">
                    <label class="control-label" for="el-floor">Этаж:</label>
                    <table id="el-floor">
                        <tr>
                            <td><?= $form->field($model, 'floor_min', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'от']])->label(false) ?></td>
                            <td><?= $form->field($model, 'floor_max', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'до']])->label(false) ?></td>
                        </tr>
                    </table>
                </div>
                <div id="floor_home" class="filter_element col-sm-4 side_left" style="display: <?=$floor_home?>">
                    <label class="control-label" for="el-floor_home">Этажей в доме (строении):</label>
                    <table id="el-floor_home">
                        <tr>
                            <td><?= $form->field($model, 'floor_home_min', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'от']])->label(false) ?></td>
                            <td><?= $form->field($model, 'floor_home_max', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'до']])->label(false) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <label class="control-label" for="comfort" style="margin: 15px 2px 2px 5px;display: <?=$comfort?>;">Имеющиеся удобства:</label>
        <hr style="margin: 0px 7px; border: none; border-bottom: 1px solid #fff; box-shadow: 0px 1px 0px rgba(0,0,0,0.04); display: <?=$comfort?>;">
        <div id="comfort" class="row"  style="display: <?=$comfort?>;">
            <div class=" container-fluid">
                <div class="filter_element col-sm-2 side_left">
                    <?= $form->field($model, 'elec')->widget(Select2::classname(), [
                        'data' => ['1'=>'Есть','0'=>'Нет'],
                        'hideSearch' => true,
                        'options' => ['placeholder' => 'Неважно'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Электричество'); ?>
                </div>
                <div class="filter_element col-sm-2 side_left">
                    <?= $form->field($model, 'gas')->widget(Select2::classname(), [
                        'data' => ['1'=>'Есть','0'=>'Нет'],
                        'hideSearch' => true,
                        'options' => ['placeholder' => 'Неважно'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Газ'); ?>
                </div>
                <div class="filter_element col-sm-2 side_left">
                    <?= $form->field($model, 'water')->widget(Select2::classname(), [
                        'data' => ['1'=>'Есть','0'=>'Нет'],
                        'hideSearch' => true,
                        'options' => ['placeholder' => 'Неважно'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Вода'); ?>
                </div>
                <div class="filter_element col-sm-2 side_left">
                    <?= $form->field($model, 'heating')->widget(Select2::classname(), [
                        'data' => ['1'=>'Есть','0'=>'Нет'],
                        'hideSearch' => true,
                        'options' => ['placeholder' => 'Неважно'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Отопление'); ?>
                </div>
                <div class="filter_element col-sm-2 side_left">
                    <?= $form->field($model, 'tel_line')->widget(Select2::classname(), [
                        'data' => ['1'=>'Есть','0'=>'Нет'],
                        'hideSearch' => true,
                        'options' => ['placeholder' => 'Неважно'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Телефон'); ?>
                </div>
                <div class="filter_element col-sm-2 side_left">
                    <?= $form->field($model, 'internet')->widget(Select2::classname(), [
                        'data' => ['1'=>'Есть','0'=>'Нет'],
                        'hideSearch' => true,
                        'options' => ['placeholder' => 'Неважно'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Интернет'); ?>
                </div>
            </div>
        </div>

    </div>

</div>
