<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User: Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 27.07.2016
 * Time: 19:34
 */

namespace frontend\widgets;


use yii\bootstrap\Html;
use yii\bootstrap\Widget;

class SocialButtons extends Widget
{
	public $text;

	public function init()
	{
		$str  = '<table><tr><td><i class="small-text" style="margin-right: 8px;">'.$this->text.'</i></td>';
		$str .= '<td><div class="btn-group">';
		$str .= Html::a('<i class="fa fa-facebook"></i>',null,['data-type' => 'fb', 'class' => 'goodshare btn btn-facebook', 'title' => 'Поделиться в Facebook']);
		$str .= Html::a('<i class="fa fa-vk"></i>',null,['data-type' => 'vk', 'class' => 'goodshare btn btn-vk', 'title' => 'Поделиться В контакте']);
		$str .= Html::a('<i class="fa fa-odnoklassniki"></i>',null,['data-type' => 'ok', 'class' => 'goodshare btn btn-ok', 'title' => 'Поделиться в Одноклассниках']);
		$str .= Html::a('<i class="fa fa-twitter"></i>',null,['data-type' => 'tw', 'class' => 'goodshare btn btn-twitter', 'title' => 'Поделиться в Twitter']);
		$str .= Html::a('<i class="fa fa-linkedin"></i>',null,['data-type' => 'li', 'class' => 'goodshare btn btn-linkedin', 'title' => 'Поделиться в LinkedIn']);
		$str .= '</div></td>';
		$str .= '</table></tr>';
		parent::init();
		echo $str;
	}
}
