<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 18.07.2015
 * Time: 17:01
 */

namespace frontend\widgets;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use \yii\bootstrap\Widget;
use common\models\tags\Tags;

class TagsWidget extends Widget
{
	public function init()
	{
		parent::init();
	}

	public function run()
	{
		$tags = Tags::find()->where(['status' => 1])->limit(30)->orderBy('frequency DESC')->asArray()->all();
		echo '<div class="panel panel-u" style="margin-top: 7px;">';
		echo '<div class="panel-heading">';
		echo '<h3 class="panel-title" style="color: #fff; display: block;"><i class="fa fa-tags"></i>&nbsp;&nbsp;Теги</h3>';
		echo '</div>';
		echo '<div class="panel-body">';
		echo '<ul class="list-inline tags-v2 margin-bottom-50">';
		foreach ($tags as $tag) {
			echo '<li>';
			echo Html::a($tag['name'], ['/tags/tags/index', 'tag' => $tag['name']]);
			echo '</li>';
		}
		echo '</ul>';
		echo '<div class="heading heading-v4">';
		echo Html::a(' все теги ', ['/tags/tags/all-tags'], ['class' => 'btn-u btn-u-xs btn-block btn-u-default']);
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}
}