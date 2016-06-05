<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\widgets\Arrays;
/* @var $this yii\web\View */
/* @var $model common\models\jobs\JobResume */
/* @var $form yii\widgets\ActiveForm */

$this->params['left'] = true;

?>

<div class="job-resume-form">
    <?php $form = ActiveForm::begin([
        'id' => 'resume-form',
        'options' => ['class' => 'sky-form'],
    ]) ?>
    <div class="form-group">
        <?= \frontend\widgets\ProfileMenu::Menu() ?>
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o" ></i>    Сохранить' : '<i class="fa fa-floppy-o" ></i>    Сохранить', ['class' => $model->isNewRecord ? 'btn-u' : 'btn-u']) ?>
    </div>
    <br>
    <label class="control-label" for="tree-wrapper">Выберите категории в которых будет размещено Ваше резюме <i>( не более 5 категорий )</i>.</label>

    <div class="row">
        <div class="col-md-6 side_left">
            <?= \common\widgets\CatList::run(\common\widgets\Arrays::getJobCat()) ?>
        </div>
        <div class="col-md-6">
            <div class="thumbnail" style="height: 350px; width: 100%; display:inline-block; overflow: auto;">
                <div class="service-block service-block-grey" style="margin-bottom: 5px; padding: 5px;">
                    <h2 class="heading-md" style="margin: 5px auto; font-size: 1.2em;">Выбранные категории</h2>
                </div>
                <?php if (is_array($cat) && count($cat) > 0) { ?>
                    <ul class="list-text-small list-group" style="list-style-type: none; padding-left: 0px;">
                        <?php foreach ($cat as $item) { ?>
                            <li class="list-group-item" id="cat-<?= $item['id'] ?>" style="padding: 5px;">
                                <span onclick="catRes_del(<?= $item['id'] ?>)" id="btn-del-<?= $item['id'] ?>" class="btn-u btn-u-xs btn-u-sea" title="Исключить категорию из резюме." style="padding: 4px 5px; line-height: 9px;">
                                    <i class="fa fa-times" style="font-size: 1.1em; line-height: 9px;"></i>
                                </span>
                                <span><?//= $item['parent'] ?></span>
                                <span style="padding-left: 8px;"><i class="fa fa-long-arrow-right"></i>&nbsp;&nbsp;<?= $item['name'] ?></span>

                            </li>
                        <?php } ?>
                    </ul>

                <?php } else { ?>
                    <div class="service-block service-block-grey">
                        <i class="icon-custom icon-color-light rounded-x fa fa-bell-o"></i>

                        <h2 class="heading-md"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;Добавьте категории</h2>
                        <p></p>
                        <p>Для того, чтобы Ваше резюме увидели работодатели, не забудьте добавить категории.</p>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 side_left">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Укажите желаемую должность (обязательное поле)') ?>
        </div>
        <div class="col-md-2 side_left">
            <?= $form->field($model, 'salary')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'employment')->widget(Select2::classname(), [
                'data' => Arrays::employment() ,
                'hideSearch' => true,
                'options' => ['placeholder' => 'График работы'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Укажите график работы (обязательное поле)'); ?>
        </div>
    </div>



    <?= $form->field($model, 'description')->textarea(['maxlength' => true])->label('Немного расширьте описание должности, например укажите специализацию или другие названия должности.') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o" ></i>    Сохранить' : '<i class="fa fa-floppy-o" ></i>    Сохранить', ['class' => $model->isNewRecord ? 'btn-u' : 'btn-u']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJsFile('/js/ajax/resume.js', ['depends' => [\yii\web\YiiAsset::className()]]);
?>
