<?php
/**
 * @link https://github.com/timurmelnikov/yii2-loading-overlay
 * @copyright Copyright (c) 2017 Timur Melnikov
 * @license MIT
 */

namespace timurmelnikov\widgets;

use yii\web\AssetBundle;

/**
 * @author Timur Melnikov <melnilovt@gmail.com>
 */
class LoadingOverlayAsset extends AssetBundle
{
    public $sourcePath = '@vendor/timurmelnikov/yii2-showloading/assets';


    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        parent::init();
        $this->js[] = YII_DEBUG ? 'js/jquery.showLoading.js' : 'js/jquery.showLoading.min.js';
    }
}
