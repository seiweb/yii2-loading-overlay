<?php
/**
 * @link https://github.com/timurmelnikov/yii2-loading-overlay
 * @copyright Copyright (c) 2017 Timur Melnikov
 * @license MIT
 */

namespace timurmelnikov\widgets;

use Yii;
use yii\widgets\Pjax;
use yii\web\View;

/**
 * Расширение стандартного класса Yii2 Pjax для использования jQuery LoadingOverlay
 */
class LoadingOverlayPjax extends Pjax
{
 
    /**
    * @var string Свойство CSS background-color в формате rgba()
    */
    public $color = 'rgba(255, 255, 255, 0.8)';
    /**
    * @var array Управление появлением / затуханием
    */
    public $fade = [];
    /**
    * @var string Классы иконок Font Awesome
    */
    public $fontawesome = '';
    /**
    * @var string URL картинки
    */
    public $image = '';
    /**
    * @var string Свойство CSS background-position, для настройки расположения изображения
    */
    public $imagePosition = 'center center';
    /**
    * @var integer string Максимальный размер в пикселях
    */
    public $maxSize = '80px';
    /**
    * @var integer string Минимальный размер в пикселях
    */
    public $minSize = '20px';
    /**
    * @var integer string Размер изображения в процентах
    */
    public $size = '50%';
    /**
    * @var integer Свойство CSS z-index
    */
    public $zIndex = 9999;
    /**
    * @var string Альтернативный DOM элемент наложения jQuery LoadingOverlay
    */
    public $elementOverlay = '';
    
    private  $_bundle = '';


    /**
    * Метод вызова виджета
    */
    public function run()
    {
        parent::run();
        $this->_bundle=LoadingOverlayAsset::register($this->getView());
        $this->convertFormats();
        $this->registerLoaderOverlay();
    }

    /**
    * Метод преобразования форматов переменных для заполнения настроек
    */
    private function convertFormats()
    {
        if ($this->image == '') {
            $this->image = $this->_bundle->baseUrl.'/src/loading.gif';
        }
        if ($this->fontawesome != '') {
            $this->image = '';
        }
        $this->fade =  json_encode($this->fade);
        if (gettype($this->maxSize) == 'string') {
            $this->maxSize = '"'.$this->maxSize.'"';
        }
        if (gettype($this->minSize) == 'string') {
            $this->minSize = '"'.$this->minSize.'"';
        }
        if (gettype($this->size) == 'string') {
            $this->size = '"'.$this->size.'"';
        }
    }

    /**
    * Метод регистрации экземпляров скрипта jQuery LoadingOverlay в представлении
    */
    private function registerLoaderOverlay()
    {
        if (YII_DEBUG) {
            $script = <<< JS

    $(document).on('pjax:send', function(event) {

        setup =  new Object();
        setup["$this->id"] = {
            color           : "$this->color",
            fade            :  $this->fade,
            fontawesome     : "$this->fontawesome",
            image           : "$this->image",
            imagePosition   : "$this->imagePosition",
            maxSize         :  $this->maxSize,
            minSize         :  $this->minSize,
            size            :  $this->size,
            zIndex          :  $this->zIndex
        };

    if ("$this->id" === event.target.id) {
        if ("$this->elementOverlay" === "") {
                $("#"+"$this->id").LoadingOverlay("show", setup[event.target.id]);
            } else {
                $("$this->elementOverlay").LoadingOverlay("show", setup[event.target.id]);
            }
        }
    })

    $(document).on('pjax:complete', function(event) {
        if ("$this->id" === event.target.id) {
            if ("$this->elementOverlay" === "") {
                $("#"+"$this->id").LoadingOverlay("hide");
            } else {
                $("$this->elementOverlay").LoadingOverlay("hide");
            }
        }
    })

JS;
        } else {
            $script = <<< JS
$(document).on('pjax:send', function(event) { setup = new Object(); setup["$this->id"] = { color : "$this->color", fade : $this->fade, fontawesome : "$this->fontawesome", image : "$this->image", imagePosition : "$this->imagePosition", maxSize : $this->maxSize, minSize : $this->minSize, size : $this->size, zIndex : $this->zIndex }; if ("$this->id" === event.target.id) { if ("$this->elementOverlay" === "") { $("#"+"$this->id").LoadingOverlay("show", setup[event.target.id]); } else { $("$this->elementOverlay").LoadingOverlay("show", setup[event.target.id]); } } })
$(document).on('pjax:complete', function(event) { if ("$this->id" === event.target.id) { if ("$this->elementOverlay" === "") { $("#"+"$this->id").LoadingOverlay("hide"); } else { $("$this->elementOverlay").LoadingOverlay("hide"); } } })
JS;
        }
        Yii::$app->view->registerJs($script, View::POS_READY, $this->id);
    }
}
