<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'css/style.css',
		'css/header.css',
		'css/footer.css',
		'plugins/animate.css',
		'plugins/line-icons/line-icons.css',
		'plugins/font-awesome/css/font-awesome.min.css',
		'css/helper.min.css',
		'css/pe-icon-set-transportation.min.css',
		'css/sky-forms.css',
		'css/site.css',
	];
	public $js = [
		'plugins/back-to-top.js',
		'plugins/smoothScroll.js',
		'js/app.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
	];
}
