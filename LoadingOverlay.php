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
    /**
    * @var string CSS background-color property. Use rgba() to set the opacity
    * String
    */
    public $color = 'rgba(255, 255, 255, 0.8)';
    /**
    * @var string A DOM element, jQuery object or plain HTML to append to the LoadingOverlay
    * String/DOM Element/jQuery Object
    */
    public $custom = '';
    /**
    * @var array Controls the fade in and fade out durations
    * Boolean/Integer/String/Array
    */
    public $fade = [];
    /**
    * @var string Class(es) of the Font Awesome icon to use
    * String
    */
    public $fontawesome = '';
    /**
    * @var string URL of the image to show
    * String
    */
    public $image = '';
    /**
    * @var string This option is mapped directly to CSS background-position property to customize the position of the image
    * String
    */
    public $imagePosition = 'center center';
    /**
    * @var string Maximun size of image in pixels
    * Integer/String
    */
    public $maxSize = '80px';
    /**
    * @var string Minimun size of image in pixels
    * Integer/String
    */
    public $minSize = '20px';
    /**
    * @var integer Specifies an interval in milliseconds to resize and reposition the LoadingOverlay according to its container
    * Integer
    */
    public $resizeInterval = 0;
    /**
    * @var string Size of image in percentage
    * Integer/String
    */
    public $size = '50%';
    /**
    * @var integer Use this to explicitly set a z-index for the overlay
    * Integer
    */
    public $zIndex = 9999;
    /**
    * @var string
    * Он-же Идентификатор экземпляра...
    */
    public $elementOverlay; //Нужна доработка...


  

    public function init()
    {
        $bundle = LoadingOverlayAsset::register($this->getView());
        if ($this->image == '') {
            $this->image = $bundle->baseUrl.'/src/loading.gif';
        }
        $this->fade =  json_encode($this->fade);



        $this->setDefaults();
        $this->registerLoader();
    }

/**
 * Метод сборки скрипта установки начальных настроек лоадера и регистрация его в представлении
 */
    private function setDefaults() //Нужна доработка...
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
    private function registerLoader() //Нужна доработка...
    {

//Перехват любого AJAX запроса...
        $script = <<<JS
$(document).ajaxSend(function(event, jqxhr, settings){
    $("{$this->elementOverlay}").LoadingOverlay("show");
});
$(document).ajaxComplete(function(event, jqxhr, settings){
    $("{$this->elementOverlay}").LoadingOverlay("hide");
});
JS;


// Перехват Pjax...
//        $script = <<< JS
// var elementOverlay = "{$this->elementOverlay}";        
// $(document).on('pjax:send', function() {
//     if (elementOverlay != "") {
//         $("{$this->elementOverlay}").LoadingOverlay("show"); //На элемент
//     } else {
//         $.LoadingOverlay("show"); //На всю страницу
//     }
// })
// $(document).on('pjax:complete', function() {
//     if (elementOverlay != "") {
//         $("{$this->elementOverlay}").LoadingOverlay("hide", true); //На элемент
//     } else {
//         $.LoadingOverlay("hide"); //На всю страницу
//     }
// })
// JS;
        Yii::$app->view->registerJs($script, yii\web\View::POS_READY, $this->elementOverlay);
    }
}
