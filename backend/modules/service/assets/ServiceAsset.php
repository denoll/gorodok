<?php

namespace app\modules\service\assets;

use yii\web\AssetBundle;


	/**
 * Class GoodsAsset
 * @package assets
 */
class ServiceAsset extends AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = '@backend/modules/service/assets';

    /**
     * @var array
     */
    public $js = [
        'js/ajax.js',
    ];

    public $css = [
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
