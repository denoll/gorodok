<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 20.07.2015
 * Time: 16:29
 */

namespace frontend\widgets;

use common\helpers\Functions;
use common\models\konkurs\Konkurs;
use common\models\konkurs\KonkursItem;
use Yii;
use yii\caching\DbDependency;
use yii\helpers\Html;
use \yii\bootstrap\Widget;
use common\models\letters\Letters;
use common\widgets\Arrays;

class KonkursMainWidget extends Widget
{
	public $count_item = 4;

	public function init()
	{
		parent::init();
	}

	public function run()
	{
		$konkurs = $this->getData();
		if (is_array($konkurs) && !empty($konkurs)) {
			echo '<table class="main-table">';
			echo '<th colspan="2">';
			echo '<span class="title-underblock title-bottom-border dark">';
			echo Html::a('Все конкурсы',['/konkurs/konkurs/index']);
			echo '</span>';
			echo '</th>';
			foreach ($konkurs as $item) {
				echo '<tr>';
				if($item['konkursWithCat']['show_img']){
					echo '<td class="table-img">';
					echo Html::a(\common\helpers\Thumb::imgWithOptions($item['base_url'], $item['img'], ['style' => 'width: 80px;']), ['/konkurs/konkurs/view', 'cat'=>$item['konkursWithCat']['cat']['slug'], 'id'=>$item['konkursWithCat']['slug']]);
					echo '</td>';
					echo '<td>';
					echo '<i class="small-text" >Название: </i>'. Html::a($item['name'], ['/konkurs/konkurs/view', 'cat'=>$item['konkursWithCat']['cat']['slug'], 'id'=>$item['konkursWithCat']['slug']], ['class' => '', 'style' => 'margin-left: 0px;', 'title' => 'Подробнее']);
					echo '<br><i class="small-text" >Конкурс:</i> ' . Html::a($item['konkursWithCat']['name'], ['/konkurs/konkurs/view/', 'cat' => $item['konkursWithCat']['cat']['slug'], 'id'=>$item['konkursWithCat']['slug']]);
					echo '<br><i class="small-text" >Категория:</i> ' . Html::a($item['konkursWithCat']['cat']['name'], ['/konkurs/konkurs/index/', 'cat' => $item['konkursWithCat']['cat']['slug']]);
					echo '</td>';
				}elseif($item['konkursWithCat']['show_des']){
					echo '<td>';
					echo '<i class="small-text" >Конкурс:</i> ' . Html::a($item['konkursWithCat']['name'], ['/konkurs/konkurs/view/', 'cat' => $item['konkursWithCat']['cat']['slug'], 'id'=>$item['konkursWithCat']['slug']]);
					echo '&nbsp;&nbsp;<i class="small-text" >Категория:</i> ' . Html::a($item['konkursWithCat']['cat']['name'], ['/konkurs/konkurs/index/', 'cat' => $item['konkursWithCat']['cat']['slug']]);
					echo '<br> <i class="small-text" >Название: </i>';
					echo Html::a($item['name'], ['/konkurs/konkurs/view', 'cat'=>$item['konkursWithCat']['cat']['slug'], 'id'=>$item['konkursWithCat']['slug']], ['class' => '', 'style' => 'margin-left: 0px;', 'title' => 'Подробнее']);
					echo '&nbsp;&nbsp;<i class="small-text" >Участник: </i>'.$item['user']['username'];
					echo '<hr class="no-margin">';
					echo Html::a(Functions::subString($item['description'], 80), ['/konkurs/konkurs/view', 'cat'=>$item['konkursWithCat']['cat']['slug'], 'id'=>$item['konkursWithCat']['slug']]);
					echo '<hr class="no-margin">';
					echo '</td>';
				}

				echo '</tr>';
			}
			echo '</table>';
		}
	}

	private function getData()
	{
		$data = Yii::$app->cache->get('konkurs_on_main');
		//$dependency = DbDependency::
		if(!$data){
			$data = KonkursItem::find()
				->joinWith('konkursWithCat')
				->with('user')
				->asArray()
				->where(['konkurs_item.status' => KonkursItem::STATUS_ACTIVE])
				->andWhere(['konkurs.status' => Konkurs::STATUS_ACTIVE])
				->orderBy(['id' => SORT_DESC])
				->limit($this->count_item)
				->all();
			Yii::$app->cache->set('konkurs_on_main',$data, Arrays::CASH_TIME);
		}
		return $data;
	}
}

