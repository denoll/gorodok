<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 19.11.2015
 * Time: 20:05
 */

namespace frontend\widgets;
use Yii;
use \yii\bootstrap\Html;
use yii\base\Widget;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;
use \yii\bootstrap\BootstrapAsset;
use \yii\bootstrap\Dropdown;
use \yii\helpers\Url;
use common\models\Jobs\VResume;

class ProfileMenu extends Widget
{
    public function init()
    {
        parent::init();



    }

    public static function Menu(){
        $path = Url::current();
        $user = Yii::$app->user->getIdentity();
        $menu = '<div style="display: block; margin-bottom: 5px;">';
        if(stristr($path, 'jobs/index')){
            $menu .= Html::a('Расширенные сведения о себе', [Url::home() . 'jobs/job-profile/index'], ['class' => 'btn-u btn-u-dark-blue']);
        }else{
            $menu .= Html::a('Расширенные сведения о себе', [Url::home() . 'jobs/job-profile/index'], ['class' => 'btn-u btn-u-default']);
        }
        if(stristr($path, 'jobs/edu')){
            $menu .= Html::a('Сведения об образовании', [Url::home() . 'jobs/edu'], ['class' => 'btn-u btn-u-dark-blue']);
        }else{
            $menu .= Html::a('Сведения об образовании', [Url::home() . 'jobs/edu'], ['class' => 'btn-u btn-u-default']);
        }
        if(stristr($path, 'jobs/exp')){
            $menu .= Html::a('Опыт работы', [Url::home() . 'jobs/exp'], ['class' => 'btn-u btn-u-dark-blue']);
        }else{
            $menu .= Html::a('Опыт работы', [Url::home() . 'jobs/exp'], ['class' => 'btn-u btn-u-default']);
        }
        if(stristr($path, 'jobs/')){
            if(stristr($path, 'jobs/resume/my-resume')){
                $menu .= Html::a('Мои резюме',[Url::home().'jobs/resume/my-resume'],['class'=>'btn-u btn-u-dark-blue']);
            }else{
                $menu .= Html::a('Мои резюме',[Url::home().'jobs/resume/my-resume'],['class'=>'btn-u btn-u-default']);
            }
        }


        if($user->doctor && (!stristr($path, 'jobs/resume/my-resume')||!stristr($path, 'jobs/resume/update')||!stristr($path, 'jobs/resume/create'))){
            if(stristr($path, 'med/doctors/update')){
                $menu .= Html::a('Мои мед. данные', [Url::home() . 'med/doctors/update'], ['class' => 'btn-u btn-u-dark-blue']);
            }else{
                $menu .= Html::a('Мои мед. данные', [Url::home() . 'med/doctors/update'], ['class' => 'btn-u btn-u-default']);
            }
            if(stristr($path, 'med/doctors/my-serv')){
                $menu .= Html::a('Мои мед. услуги', [Url::home() . 'med/doctors/my-serv'], ['class' => 'btn-u btn-u-dark-blue']);
            }else{
                $menu .= Html::a('Мои мед. услуги', [Url::home() . 'med/doctors/my-serv'], ['class' => 'btn-u btn-u-default']);
            }

        }
        $menu .= '</div>';

        return $menu;
    }

}