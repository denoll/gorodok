<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 19.07.2015
 * Time: 1:39
 */

namespace frontend\widgets;

use Yii;
use yii\caching\DbDependency;
use yii\helpers\Url;
use yii\helpers\Html;
use \yii\bootstrap\Widget;
use common\models\news\News;
use common\widgets\Arrays;

class NewsSidebarWidget extends Widget
{
    public function init()
    {
        $dependency = new DbDependency();
        $dependency->sql = 'SELECT MAX(modifyed_at) FROM news';
        $news = News::getDb()->cache(function ($news){
            return News::find()//получаем массив с новостями
            ->select('title,alias,id,publish,thumbnail,id_cat')
                ->asArray()
                ->where(['status' => 1])
                ->andWhere('(publish < NOW() AND (unpublish < NOW()OR unpublish IS NULL))')
                ->orderBy(['publish' => SORT_DESC])
                ->limit(5)
                ->all();
        }, Arrays::CASH_TIME, $dependency);

        $path = Url::to('/news/news/view');
        echo '<div class="panel panel-u" style="margin-top: 10px;">';
        echo '<div class="panel-heading">';
        echo '<h3 class="panel-title" style="color: #fff; display: block;">Последние новости</h3>';
        echo '</div>';
        echo '<div class="posts panel-body" style=" padding: 7px;">';
        foreach ($news as $item) {
            echo '<dl class="dl-horizontal">';
            echo '<dt>';
            echo '<a href="' . $path . '?id=' . $item['alias'] . '">';
            if($item['thumbnail'] != null){
                echo Html::img(Url::to('@frt_url/img/news/') . $item['thumbnail'], ['style' => '']);
            }else {
                echo Html::img(Url::to('@frt_url/img/no-img.png'), ['style' => '']);
            }
            echo '</a>';
            echo '</dt>';
            echo '<dd>';
            echo Html::a($item['title'], [$path, 'id' => $item['alias']],['style'=>'font-size: 0.9em;']);
            echo '<br><i style="font-size: 0.9em; color: #aaa;">' . Yii::$app->formatter->asDate($item['publish'], 'long') . '</i>';
            echo '</dd>';
            echo '</dl>';
        }
        echo '</div>';
        echo '</div>';
    }
}