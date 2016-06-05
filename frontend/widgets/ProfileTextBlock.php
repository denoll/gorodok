<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 08.02.2016
 * Time: 3:47
 */

namespace frontend\widgets;
use Yii;

class ProfileTextBlock
{

	public function init($text,$header = null){
		if (!empty($text)) {
			$str  = '<div class="tag-box tag-box-v4" style="text-align: center;">';
			$header != null ? $str .= '<h4 style="margin: 0;">'.$header.'</h4>' : '';
			$str .= '<p style="margin: 0;">'.$text.'</p>';
			$str .= '</div>';
			return $str;
		}else return false;
	}
}