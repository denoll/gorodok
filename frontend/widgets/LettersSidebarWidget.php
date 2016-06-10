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
use yii\caching\DbDependency;
use common\models\letters\Letters;
use common\widgets\Arrays;


class LettersSidebarWidget extends Widget
{
	public $count_item = 5;

	public function init()
	{
		parent::init();
	}

	public function run()
	{
		$model = $this->getData();
		$path = Url::to('/letters/letters/view');
		echo '<div class="panel panel-u" style="margin-top: 10px;">';
		echo '<div class="panel-heading">';
		echo '<h3 class="panel-title" style="color: #fff; display: block;">';
		echo Html::a('Коллективные письма','/letters/letters/index',['class'=>'header-link']);
		echo '</h3>';
		echo '</div>';
		echo '<div class="posts panel-body" style=" padding: 7px;">';
		foreach ($model as $item) {
			echo '<dl class="dl-horizontal">';
			echo '<dt>';
			echo '<a href="' . $path . '?id=' . $item['alias'] . '">';
			if ($item['thumbnail'] != null) {
				echo Html::img(Url::to('@frt_url/img/letters/') . $item['thumbnail'], ['style' => '']);
			} else {
				echo Html::img(Url::to('@frt_url/img/no-img.png'), ['style' => '']);
			}
			echo '</a>';
			echo '</dt>';
			echo '<dd>';
			echo Html::a($item['title'], [$path, 'id' => $item['alias']], ['style' => 'font-size: 0.9em;']);
			echo '<br><i style="font-size: 0.9em; color: #aaa;">с&nbsp;' . Yii::$app->formatter->asDate($item['date_in'], 'long') . '</i>';
			echo '<br><i style="font-size: 0.9em; color: #aaa;">' . $item['cat']['name'] . '</i>';
			echo '</dd>';
			echo '</dl>';
		}
		echo '</div>';
		echo '</div>';
	}

	private function getData()
	{
		$dependency = new DbDependency();
		$dependency->sql = 'SELECT MAX(updated_at) FROM letters WHERE status = 1';
		return Letters::getDb()->cache(function ($db) {
			return Letters::find('SELECT title, alias, id, cat.name, cat.alias, ')
				->select('title,alias,id,publish,thumbnail,id_cat')
				->with('tags')
				->with('cat')
				->asArray()
				->where(['status' => 1])
				->andWhere('(publish < NOW() AND (unpublish < NOW()OR unpublish IS NULL))')
				->orderBy(['publish' => SORT_DESC])
				->limit($this->count_item)
				->all();
		}, Arrays::CASH_TIME, $dependency);
	}
}