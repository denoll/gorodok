<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 19.07.2015
 * Time: 1:39
 */

namespace frontend\widgets;

use common\models\afisha\Afisha;
use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use \yii\bootstrap\Widget;


class AfishaSidebarWidget extends Widget
{
	public function init()
	{
		$model = Afisha::find()
			->with('cat')
			->where(['status' => 1])
			->andWhere('(publish < NOW() AND (unpublish < NOW()OR unpublish IS NULL))')
			->asArray()
			->orderBy(['publish' => SORT_DESC])
			->limit(5)
			->all();

		$path = Url::to('/afisha/afisha/view');
		echo '<div class="panel panel-u" style="margin-top: 10px;">';
		echo '<div class="panel-heading">';
		echo '<h3 class="panel-title" style="color: #fff; display: block;">Афиша</h3>';
		echo '</div>';
		echo '<div class="posts panel-body" style=" padding: 7px;">';
		foreach ($model as $item) {
			echo '<dl class="dl-horizontal">';
			echo '<dt>';
			echo '<a href="' . $path . '?id=' . $item['alias'] . '">';
			if ($item['thumbnail'] != null) {
				echo Html::img(Url::to('@frt_url/img/afisha/') . $item['thumbnail'], ['style' => '']);
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
}