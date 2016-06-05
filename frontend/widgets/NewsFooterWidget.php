<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 19.07.2015
 * Time: 1:39
 */

namespace frontend\widgets;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use \yii\bootstrap\Widget;
use common\models\News;


class NewsFooterWidget extends Widget
{
    public function init()
    {
        $news_m = News::find()
            ->where(['status' => 1])
            ->andWhere('publish < NOW() AND unpublish > NOW() OR unpublish IS NULL')
            ->orderBy(['publish' => SORT_DESC])
            ->limit(3)
            ->all();

        $path = Url::home() . 'news/view';


        echo '<div class="posts">';
        echo '<div class="headline"><h2>Последние новости</h2></div>';
        foreach ($news_m as $news) {
            echo '<dl class="dl-horizontal">';
            echo '<dt>';
            echo '<a href="' . $path . '?id=' . $news->alias . '">';
            echo Html::img(Url::home() . 'img/news/thumb/' . $news->thumbnail, ['style' => '']);
            echo '</a>';
            echo '</dt>';
            echo '<dd>';
            echo Html::a($news->title, [$path, 'id' => $news->alias]);
            echo '<br><i>' . Yii::$app->formatter->asDate($news->publish, 'long') . '</i>';
            echo '</dd>';
            echo '</dl>';
        }
        echo '</div>';


    }
}