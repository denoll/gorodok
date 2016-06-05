<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 05.02.2016
 * Time: 5:44
 */
$dir = \Yii::getAlias('@frt_dir/temp');


	if(file_exists($dir.'/weather.json')){
		unlink($dir.'/weather.json');
	}

	if(file_exists($dir.'/course.json')){
		unlink($dir.'/course.json');
	}

