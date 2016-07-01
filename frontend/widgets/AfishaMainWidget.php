<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 20.07.2015
 * Time: 16:29
 */

namespace frontend\widgets;

use Yii;
use yii\helpers\Html;
use \yii\bootstrap\Widget;
use common\models\afisha\Afisha;
use common\widgets\Arrays;
use yii\caching\DbDependency;

class AfishaMainWidget extends Widget
{
	public $count_item = 4;

	public function init()
	{
		parent::init();
	}

	public function run()
	{
		$afisha = $this->getData();
		if (is_array($afisha) && !empty($afisha)) {
			echo '<table class="main-table">';
			echo '<th colspan="2">';
			echo '<span class="title-underblock title-bottom-border dark">Афиша</span>';
			echo '</th>';
			foreach ($afisha as $item) {
				echo '<tr>';
				echo '<td class="table-img">';
				echo Html::a(Avatar::imgAfisha($item['thumbnail'], '80px; border: 1px solid #c6c6c6; padding: 1px;'), ['/afisha/afisha/view', 'cat'=>$item['cat']['alias'], 'id'=>$item['alias']]);
				echo '</td>';
				echo '<td>';
				echo Html::a($item['title'], ['/afisha/afisha/view', 'cat'=>$item['cat']['alias'], 'id'=>$item['alias']], ['class' => '', 'style' => 'margin-left: 0px;', 'title' => 'Подробнее']);
				echo '<br><i class="small-text" >Категория:</i> ' . Html::a($item['cat']['name'], ['/afisha/afisha/index/', 'cat' => $item['cat']['alias']]);
				echo '<ul class="list-inline"><li class="tag-sign" style="margin-right: 5px;">Теги: </li>';
				foreach ($item['tags'] as $tag) {
					echo '<li class="tag-name">';
					echo Html::a($tag['name'], ['/tags/tags/index', 'tag' => $tag['name']], ['class' => '']);
					echo '</li>';
				}
				echo '</ul>';
				echo '</td>';
				echo '</tr>';
			}
			echo '</table>';
		}
	}

	private function getData()
	{
		$data = Yii::$app->cache->get('afisha_on_main');
		if(!$data){
			$data = Afisha::find()
				->select('title,alias,id,publish,thumbnail,id_cat')
				->with('tags')
				->with('cat')
				->asArray()
				->where(['status' => 1])
				->andWhere('(publish < NOW() AND (unpublish < NOW()OR unpublish IS NULL))')
				->orderBy(['publish' => SORT_DESC])
				->limit($this->count_item)
				->all();
			Yii::$app->cache->set('afisha_on_main',$data, Arrays::CASH_TIME);
		}
		return $data;
	}
}
