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
use common\models\service\Service;
use common\widgets\Arrays;
use yii\caching\DbDependency;

class ServiceMainWidget extends Widget
{
	public $count_item = 4;

	public function init()
	{
		parent::init();
	}

	public function run()
	{
		$service = $this->getData();
		if (is_array($service) && !empty($service)) {
			echo '<table class="main-table">';
			echo '<th colspan="2">';
			echo '<span class="title-underblock title-bottom-border dark">Услуги</span>';
			echo '</th>';
			foreach ($service as $item) {
				echo '<tr>';
				$path = '/service/service/view';
				echo '<td class="table-img">';
				echo Html::a(Avatar::imgService($item['main_img'], '80px; border: 1px solid #c6c6c6; padding: 1px;'), [$path, 'id' => $item['id']]);
				echo '</td>';
				echo '<td>';
				echo Html::a($item['name'], [$path, 'id' => $item['id']], ['class' => '', 'style' => 'margin-left: 0px;', 'title' => 'Подробнее']);
				if ($item['cost'] != '') {
					echo '<br><i class="small-text" style="margin-right: 5px;">Цена:</i><strong class="cost">' . number_format($item['cost'], 2, ',', ' ') . '</strong><i class="small-text" style="margin-left: 2px;">руб.</i>';
				}
				echo '<br><i class="small-text" >Категория:</i> ' . Html::a($item['cat']['name'], ['/service/service/index/', 'cat' => $item['cat']['alias']]);
				echo '</td>';
				echo '</tr>';
			}
			echo '</table>';
		}
	}

	private function getData()
	{
		$dependency = new DbDependency();
		$dependency->sql = 'SELECT MAX(updated_at) FROM service';
		return Service::getDb()->cache(function () {
			return Service::find()
				->select('name,id,id_cat,created_at,main_img,cost')
				->with('cat')
				->asArray()
				->where(['status' => 1])
				->orderBy(['created_at' => SORT_DESC])
				->limit($this->count_item)
				->all();
		}, Arrays::CASH_TIME, $dependency);
	}
}
