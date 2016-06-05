<?php
use yii\helpers\Html;
use \yii\helpers\Url;
use yii\helpers\HtmlPurifier;
?>
<div class="comment" style="display: table; content: ' '; margin-bottom: 5px; width: 100%;">

        <div class="col-sm-2 side_left" style="padding: 5px; max-width: 80px;">
                <?= \frontend\widgets\Avatar::userAvatar($model['user']['avatar'],'60px; border: 1px solid #c6c6c6; border-radius: 50% !important; padding: 1px; ') ?>
        </div>
        <div class="col-sm-10" style="border: 1px solid #D9D9D9; padding: 1px 7px; margin: 0px;">
            <p style="margin: 2px 0;">
                <?= $model['user']['username'] ? '<i class="small-text">Автор:&nbsp;'. $model['user']['username'].'</i>' : ''?>
                <i class="small-text">&nbsp;<?= \Yii::$app->formatter->asDate($model['created_at'], 'long') ?></i>
            </p>
            <div class="container-fluid" style="margin-left:5px; padding: 5px; width: 100%;">
                <?= nl2br($model['text']) ?>
            </div>
        </div>
</div>