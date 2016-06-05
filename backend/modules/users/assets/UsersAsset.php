<?php

namespace app\modules\users\assets;

use yii\web\AssetBundle;


	/**
 * Class UsersAsset
 * @package yii2mod\rbac\assets
 */
class UsersAsset extends AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = '@backend/modules/users/assets';


    /**
     * @var array
     */
    public $js = [
        'js/users.js',
	    'js/yamaps.js',
    ];

    public $css = [
		'css/flags-iso/16/flags.css'
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
