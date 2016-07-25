<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User: Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 25.07.2016
 * Time: 16:23
 */

namespace frontend\widgets;

use yii\bootstrap\Html;
use yii\bootstrap\Widget;

class LinkPage extends Widget
{
	public $url = [ ];
	public $text = null;
	public $options = [ ];

	public function init()
	{
		if ( empty($this->text) || empty($this->url) ) return null;
		echo Html::a($this->text, $this->url, $this->options);
		return true;
	}

}
