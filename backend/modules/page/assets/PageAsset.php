<?php
namespace app\modules\page\assets;

use yii\web\AssetBundle;


	/**
 * Class GoodsAsset
 * @package assets
 */
class PageAsset extends AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = '@backend/modules/page/assets';

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
