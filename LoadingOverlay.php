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

    public $color;          //"rgba(255, 255, 255, 0.8)"  (String)
    public $custom;         //""                          (String/DOM Element/jQuery Object)
    public $fade;           //true                        (Boolean/Integer/String/Array)
    public $fontawesome;    //""                          (String)
    public $image;          //"data:image/gif;base64,..." (String)
    public $imagePosition;  //"center center"             (String)
    public $maxSize;        //"100px"                     (Integer/String)
    public $minSize;        //"20px"                      (Integer/String)
    public $resizeInterval; //50                          (Integer)
    public $size;           //"50%"                       (Integer/String)
    public $zIndex;         //9999                        (Integer)

    public function init()
    {
        $bundle = LoadingOverlayAsset::register($this->getView());
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
         //color           : "rgba(70, 159, 44, 0.9)",
         //custom
         //fade            : [5000, 2000],
         //fontawesome
         image           : "http://192.168.19.83/yii2-extenation/web/img/IMG_20170513_105214.jpg",
         //imagePosition
         maxSize         : "80px",
         minSize         : "20px",
         resizeInterval  : 0,
         size            : "50%"
         //zIndex
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
$(document).on('pjax:send', function() {
  $("#p0").LoadingOverlay("show");

})
$(document).on('pjax:complete', function() {
    $("#p0").LoadingOverlay("hide", true);
  //alert('2');
})
JS;



        Yii::$app->view->registerJs($script);
    }
}
