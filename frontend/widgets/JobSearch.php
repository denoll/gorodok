<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 03.11.2015
 * Time: 5:58
 */

namespace frontend\widgets;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\jobs\JobResume;

class JobSearch
{
    public static function run(){

        $arr = [
            ['id'=>'res', 'name'=>'Резюме'],
            ['id'=>'vac', 'name'=>'Вакансии'],
            ['id'=>'service', 'name'=>'Услуги'],
            ['id'=>'auto', 'name'=>'Авто'],
            ['id'=>'realty', 'name'=>'Недвижимость'],
        ];
        echo Html::beginForm([Url::home().'jobs/resume/index'], 'get');
        echo '<div class="input-group">';
        echo '<span class="input-group-btn">';
        echo Html::dropDownList('search','', ArrayHelper::map($arr, 'id', 'name'), ['class' => 'form-control']);
        echo '</span>';
        echo Html::input('text', 'JobResumeSearch[title]', '', ['class' => 'form-control', 'style'=>'']);
        echo '<span class="input-group-btn">';
        echo Html::submitButton('<i class="fa fa-search"></i>&nbsp;&nbsp;Найти', ['class' => 'btn-u']);
        echo '</span>';
        echo '</div>';
        echo Html::endForm();
    }
}