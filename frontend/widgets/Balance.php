<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 30.10.2015
 * Time: 21:21
 */

namespace frontend\widgets;
use yii\helpers\Url;
use yii\helpers\Html;


class Balance
{
    public static function init()
    {
        $user = \Yii::$app->user->getIdentity();
        $account = $user['account'] == 0 || $user['account'] == null ||$user['account'] == '' ? 0 : $user['account'];
        echo '<div class="tag-box tag-box-v2" style="padding: 15px; height: 100px; margin-bottom: 5px; border: 1px solid #870000; background-color: #870000;">';
        echo '<a href="' . Url::Home() . 'account/index" style="">';
        echo '<h4 style="margin: 0px 0px 10px 0px; color: #fff;"><span style="margin-left: 2px;" class="icon-wallet" aria-hidden="true"></span>&nbsp;&nbsp;<i style="font-size: 0.9em !important;">Мой баланс:</i> <span id="account">'. $account .'</span> <i class="fa fa-ruble" style="font-size: 0.8em !important;"></i></h4></a>';
        echo Html::a('Пополнить &nbsp;&nbsp;<i class="fa fa-ruble"></i>',['/account/pay'],['class'=>'btn-u btn-brd btn-u-xs btn-brd-hover btn-u-light','style'=>'width: 100%; text-align: center; ']);
        echo '</div>';
    }
}