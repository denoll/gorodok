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
	public $count_item = 5;

	public function init()
	{
		parent::init();
	}

	public function run()
	{
		$news = $this->getData();
		echo '<div class="panel panel-u" style="margin-top: 10px;">';
		echo '<div class="panel-heading">';
		echo '<h3 class="panel-title" style="color: #fff; display: block;">';
		echo Html::a('Последние новости', ['/news/news/index'], ['class' => 'header-link']);
		echo '</h3>';
		echo '</div>';
		echo '<div class="posts panel-body" style=" padding: 7px;">';
		foreach ($news as $item) {
			if ($item['thumbnail'] != null) {
				$img = Html::img(Url::to('@frt_url/img/news/') . $item['thumbnail'], ['style' => '']);
			} else {
				$img = Html::img(Url::to('@frt_url/img/no-img.png'), ['style' => '']);
			}
			echo '<dl class="dl-horizontal">';
			echo '<dt>';
			echo Html::a($img, ['/news/news/view', 'cat'=>$item['cat']['alias'], 'id'=>$item['alias']]);
			echo '</dt>';
			echo '<dd>';
			echo Html::a($item['title'], ['/news/news/view', 'cat'=>$item['cat']['alias'], 'id'=>$item['alias']], ['style' => 'font-size: 0.9em;']);
			echo '<br><i style="font-size: 0.9em; color: #aaa;">' . Yii::$app->dateFormat->getDateTime($item['publish']) . '</i>';
			echo '</dd>';
			echo '</dl>';
		}
		echo '</div>';
		echo '</div>';
	}

	private function getData()
	{
		$data = Yii::$app->cache->get('news_sidebar');
		if(!$data){
			$data = News::find()//получаем массив с новостями
			->select('title,alias,id,publish,thumbnail,id_cat')
				->with('cat')
				->asArray()
				->where(['status' => 1])
				->andWhere('(publish < NOW() AND (unpublish < NOW()OR unpublish IS NULL))')
				->orderBy(['publish' => SORT_DESC])
				->limit($this->count_item)
				->all();
			Yii::$app->cache->set('news_sidebar',$data, Arrays::CASH_TIME);
		}
		return $data;
	}
}
