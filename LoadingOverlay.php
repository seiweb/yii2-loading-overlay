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

    public $color;          //  : "rgba(255, 255, 255, 0.8)"    // String
    public $custom;         //  : ""                            // String/DOM Element/jQuery Object
    public $fade;           //  : true                          // Boolean/Integer/String/Array
    public $fontawesome;    //  : ""                            // String
    public $image;          //  : "data:image/gif;base64,..."   // String
    public $imagePosition;  //  : "center center"               // String
    public $maxSize;        //  : "100px"                       // Integer/String
    public $minSize;        //  : "20px"                        // Integer/String
    public $resizeInterval; //  : 50                            // Integer
    public $size;           //  : "50%"                         // Integer/String
    public $zIndex;         //  : 9999                          // Integer






    public function init()
    {
        $view = $this->getView();
        $bundle = LoadingOverlayAsset::register($view);
        $this->registerLoadingOverlay();
    }



/**
 * Метод регистрации готового скрипта лоадера в представлении
 */
    private function registerLoadingOverlay()
    {

                $script = <<<JS
$("#test").click(function() {
  $("#ttt").LoadingOverlay("show", {
    //size: 0,
    //image: "http://127.0.0.1/yii2-extenation/web/img/ajax-loader.gif"
});


// Here we might call the "hide" action 2 times, or simply set the "force" parameter to true:
$("#ttt").LoadingOverlay("hide", true);
});
JS;

//Подключение JavaScript

        Yii::$app->view->registerJs($script);
    }
}
