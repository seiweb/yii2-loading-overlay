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
    public $color          = 'rgba(255, 255, 255, 0.8)';  // String
    public $custom         = '';                          // (String/DOM Element/jQuery Object)
    public $fade           = [];                          // (Array)
    public $fontawesome    = '';                          // (String)
    public $image          = '';                          // (String)
    public $imagePosition  = 'center center';             // (String)
    public $maxSize        = '80px';                      // (Integer/String)
    public $minSize        = '20px';                      // (Integer/String)
    public $resizeInterval = 0;                           // (Integer)
    public $size           = '50%';                       // (Integer/String)
    public $zIndex         = 9999;                        // (Integer)
    public $elementOverlay;
  
    public function init()
    {
        $bundle = LoadingOverlayAsset::register($this->getView());
        if ($this->image == '') $this->image = $bundle->baseUrl.'/src/loading.gif';
        $this->fade =  json_encode($this->fade);
        $this->setDefaults();
        $this->registerLoader();
    }

/**
 * Метод сборки скрипта установки начальных настроек лоадера и регистрация его в представлении
 */
    private function setDefaults()
    {
        $script = <<<JS
         $.LoadingOverlaySetup({
         color           : "{$this->color}",
         custom          : "{$this->custom}",
         fade            :  {$this->fade},
         fontawesome     : "{$this->fontawesome}",
         image           : "{$this->image}",
         imagePosition   : "{$this->imagePosition}",
         maxSize         : "{$this->maxSize}",
         minSize         : "{$this->minSize}",
         resizeInterval  :  {$this->resizeInterval},
         size            : "{$this->size}",
         zIndex          :  {$this->zIndex}
         });
JS;
        Yii::$app->view->registerJs($script);
    }

/**
 * Метод регистрации скрипта лоадера в представлении
 */
    private function registerLoader()
    {
//По селектору...
//         $script = <<<JS
// $("#test").click(function() {
//   $("#ttt").LoadingOverlay("show");

// // Here we might call the "hide" action 2 times, or simply set the "force" parameter to true:
// $("#ttt").LoadingOverlay("hide", true);
// });
// JS;


//Pjax...
        $script = <<< JS
var elementOverlay = "{$this->elementOverlay}";        

$(document).on('pjax:send', function() {

    if (elementOverlay != "") {
        $("{$this->elementOverlay}").LoadingOverlay("show"); //На элемент
    } else {
        $.LoadingOverlay("show"); //На всю страницу
    }

})
$(document).on('pjax:complete', function() {
    if (elementOverlay != "") {
        $("{$this->elementOverlay}").LoadingOverlay("hide", true); //На элемент
    } else {
        $.LoadingOverlay("hide"); //На всю страницу
    }
})
JS;
        Yii::$app->view->registerJs($script);
    }
}
