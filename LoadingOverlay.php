<?php
/**
 * @link https://github.com/timurmelnikov/yii2-loading-overlay
 * @copyright Copyright (c) 2017 Timur Melnikov
 * @license MIT
 */

namespace timurmelnikov\widgets;

use Yii;
use yii\base\Widget;

/**
 * @author Timur Melnikov <melnilovt@gmail.com>
 */
class LoadingOverlay extends Widget
{

    public $loadingType = 1;

    public function init()
    {

        $view = $this->getView();
        $bundle = LoadingOverlayAsset::register($view);
    }
}
