<?php
/**
 * Created by denoll.
 * User: denoll
 * Date: 14.08.2015
 * Time: 19:44
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\models\users\User;
use common\models\ForumTheme;

$this->params['left'] = true;
$this->params['right'] = true;
if (!empty($forum_cat->m_description)) {
    $this->registerMetaTag(['content' => Html::encode($forum_cat->m_description), 'name' => 'description']);
}
if (!empty($forum_cat->m_keyword)) {
    $this->registerMetaTag(['content' => Html::encode($forum_cat->m_keyword), 'name' => 'keywords']);
}
$this->title = $forum_cat->name;

$path = Url::home() . 'forum/theme/';

$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="forum-default-index">
    <?php if (!is_null($forum_cat)) { ?>

            <div style="width: 100%; margin: 0px auto 5px auto; padding: 3px 3px; border-bottom: 1px solid #ccc; border-top: 1px solid #ccc;">
                <?php if (!Yii::$app->user->isGuest) { ?>
                    <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-plus']) . ' &nbsp; Новая тема', ['create'], [
                        'class' => 'btn-u btn-xs btn-u-dark',
                        /*'data' => [
                            'method' => 'post',
                            'params' => [
                                'id_cat'=>$forum_cat->id ,
                            ],
                        ],*/
                    ]) ?>
                    <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-mail-reply']) . ' &nbsp; Назад к списку форумов', ['index'], [
                        'class' => 'btn-u btn-xs btn-brd btn-u-default',
                    ]) ?>
                <?php } else { ?>
                    <div class="tag-box tag-box-v4">
                        <h4 style="text-align: center;">Зарегистрируйтесь, и Вы сможете создавать новые темы и оставлять сообщения.</h4>
                    </div>

                <?php } ?>
            </div>

            <h1 style="margin: 0px auto 5px auto;"><?= $forum_cat->name ?></h1>

            <p><i style="font-size: 0.95em;"> <?= $forum_cat->description ?> </i></p>

            <?php if (is_array($forum_theme)) { ?>
                <ul class="forum_theme">
                    <?php foreach ($forum_theme as $fth) { ?>
                        <?php if ($forum_cat->id == $fth->id_cat) { ?>
                            <?php if ($fth->to_top) { ?>
                                <li class="list-forum-theme list-top" style="">
                                    <i style="font-size: 0.9em;">Тема:&nbsp;&nbsp; </i>
                                    <?= Html::a($fth->name . '&nbsp;&nbsp; ' . Html::tag('i', '', ['class' => 'fa fa-arrow-circle-o-right']), [$path, 'id' => $fth->alias], ['class' => 'forum_theme_name label label-light']) ?>
                                    <?= $fth->status == '2' ? '&nbsp; <i style="font-size: 0.7em; color: #3E5687;">Тема закыта!</i>' : '' ?>
                                    <table style="margin-top: 5px;">
                                        <tr>
                                            <td><i style="padding-left: 0px; font-size: 0.85em;">Просмотров: <?= $fth->views ?></i></td>
                                            <td><i style="padding-left: 20px; font-size: 0.85em;">Сообщений: <?= $fth->message_count ?></i></td>
                                            <?php if ($fth->id_author == Yii::$app->user->id || User::isAdmin()) { ?>
                                                <td style="padding-left: 20px;">
                                                    <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-pencil']), ['update', 'id' => $fth->id], ['title' => 'Редактировать тему', 'class' => 'btn btn-xs btn-default']) ?>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    </table>
                                    <div style="margin-left:-3px; padding: 5px; width: 100%;">
                                        <?php
                                        if (!empty($fth->tags)) {
                                            echo '<i style="margin-right: 15px; font-size: 0.85em;">Теги: </i>';
                                            foreach ($fth->tags as $tag) {
                                                echo Html::a($tag['name'],['/tags/tags/index','tag'=>$tag['name']],['class'=>'tags tag_btn', 'style'=>'font-size: 0.9em;']);
                                            }
                                        }
                                        ?>
                                    </div>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    <?php foreach ($forum_theme as $fth) { ?>
                        <?php if ($forum_cat->id == $fth->id_cat) { ?>
                            <?php if (!$fth->to_top) { ?>
                                <li class="list-forum-theme" style="">
                                    <i style="font-size: 0.9em;">Тема:&nbsp;&nbsp; </i>
                                    <?= Html::a($fth->name . '&nbsp;&nbsp; ' . Html::tag('i', '', ['class' => 'fa fa-arrow-circle-o-right']), [$path, 'id' => $fth->alias], ['class' => 'forum_theme_name label label-light']) ?>
                                    <?= $fth->status == '2' ? '&nbsp; <i style="font-size: 0.7em; color: #3E5687;">Тема закыта!</i>' : '' ?>
                                    <table style="margin-top: 5px;">
                                        <tr>
                                            <td><i style="padding-left: 0px; font-size: 0.85em;">Просмотров: <?= $fth->views ?></i></td>
                                            <td><i style="padding-left: 20px; font-size: 0.85em;">Сообщений: <?= $fth->message_count ?></i></td>
                                            <?php if ($fth->id_author == Yii::$app->user->id || User::isAdmin()) { ?>
                                                <td style="padding-left: 20px;">
                                                    <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-pencil']), ['update', 'id' => $fth->id], ['title' => 'Редактировать тему', 'class' => 'btn btn-xs btn-default']) ?>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    </table>
                                    <div style="margin-left:-3px; padding: 5px; width: 100%;">
                                        <?php
                                        if (!empty($fth->tags)) {
                                            echo '<i style="margin-right: 15px; font-size: 0.85em;">Теги: </i>';
                                            foreach ($fth->tags as $tag) {
                                                echo Html::a($tag['name'],['/tags/tags/index','tag'=>$tag['name']],['class'=>'tags tag_btn', 'style'=>'font-size: 0.9em;']);
                                            }
                                        }
                                        ?>
                                    </div>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <h3>В данной категории пока нет тем.</h3>
            <?php } ?>

        <div class="text-center">
            <?php
            echo LinkPager::widget([
                'pagination' => $pages,
            ]);
            ?>
        </div>


    <?php } ?>
</div>

