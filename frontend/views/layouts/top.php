<?php
use yii\helpers\Url;
use yii\helpers\Html;

use frontend\widgets\Avatar;

$this->registerJsFile('https://cdn.jsdelivr.net/jquery.goodshare.js/3.2.4/goodshare.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<!-- Topbar -->
<div class="topbar-v1">
    <div class="container">
        <div class="row">
            <div class="col-md-2 side_left top-left-block" style="min-width: 205px;">
                <ul class="list-inline top-v1-data" style="float: none; text-align: left;">
                    <li style="width: 38px; text-align: center; padding: 0;">
                        <a href="#" class="goodshare" style="display: block; padding: 6px 11px;" data-type="fb" title="Поделиться в Facebook"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li style="width: 38px; text-align: center; padding: 0;">
                        <a href="#" class="goodshare" style="display: block; padding: 6px 11px;" data-type="vk" title="Поделиться В контакте"><i class="fa fa-vk"></i></a>
                    </li>
                    <li style="width: 38px; text-align: center; padding: 0;">
                        <a href="#" class="goodshare" style="display: block; padding: 6px 11px;" data-type="ok" title="Поделиться в Одноклассниках"><i class="fa fa-odnoklassniki"></i></a>
                    </li>
                    <li style="width: 38px; text-align: center; padding: 0;">
                        <a href="#" class="goodshare" style="display: block; padding: 6px 11px;" data-type="tw" title="Поделиться в Twitter"><i class="fa fa-twitter"></i></a>
                    </li>
                    <li style="width: 38px; text-align: center; padding: 0;">
                        <a href="#" class="goodshare" style="display: block; padding: 6px 11px;" data-type="li" title="Поделиться в LinkedIn"><i class="fa fa-linkedin"></i></a>
                    </li>

                </ul>
            </div>
            <div class="col-md-3 no-side top-center-block">
                   <?= \frontend\widgets\CurseWidget::init()?>
                   <?= \frontend\widgets\WeatherWidget::init(); ?>
            </div>
            <div class="col-md-7 top-right-block">
                <ul class="list-inline top-v1-data">
                    <li><?= Html::a('<i class="fa fa-globe"></i>&nbsp;&nbsp;новости',['/news/news/index']) ?></li>
                    <li><?= Html::a('<i class="fa fa-heartbeat"></i>&nbsp;&nbsp;форум',['/forum/forum/index']) ?></li>
                    <?php if (Yii::$app->user->isGuest) {?>
                        <li><?= Html::a('Регистрация',[Url::home().'site/signup']) ?></li>
                        <li><?= Html::a('Войти',[Url::home().'site/login']) ?></li>
                    <?php }else{ ?>
                        <li><?= Html::a(Avatar::init().'&nbsp;&nbsp;в личный кабинет',[Url::home().'profile/index'],['style'=>'']) ?></li>
                        <li>Вы вошли как: &nbsp;<?= Yii::$app->user->identity->username ?></li>
                        <li><?= Html::a('Выйти',[Url::home().'site/logout']) ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Topbar -->