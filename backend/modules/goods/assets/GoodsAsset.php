<?php

namespace app\modules\goods\assets;

use yii\web\AssetBundle;


	/**
 * Class GoodsAsset
 * @package assets
 */
class GoodsAsset extends AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = '@backend/modules/goods/assets';

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
