Yii2 виджет-обертка для [jQuery LoadingOverlay](https://gasparesganga.com/labs/jquery-loading-overlay/) 
================

[![Latest Stable Version](https://poser.pugx.org/timurmelnikov/yii2-loading-overlay/v/stable)](https://packagist.org/packages/timurmelnikov/yii2-loading-overlay)
[![Latest Unstable Version](https://poser.pugx.org/timurmelnikov/yii2-loading-overlay/v/unstable)](https://packagist.org/packages/timurmelnikov/yii2-loading-overlay)
[![Total Downloads](https://poser.pugx.org/timurmelnikov/yii2-loading-overlay/downloads)](https://packagist.org/packages/timurmelnikov/yii2-loading-overlay)
[![License](https://poser.pugx.org/timurmelnikov/yii2-loading-overlay/license)](https://packagist.org/packages/timurmelnikov/yii2-loading-overlay)

Виджет предназначен для наложения картинки-лоадера на блок, при обработке Ajax запроса.

## Скриншоты

Наименование | Скриншот | Настройки
------------ | ------------- | -------------
Pjax с Gridview | ![Pjax с Gridview](https://lh3.googleusercontent.com/56-cBPgQluR8iKO61PfDxorOOwLKQ-hUqYHD_Uuw63LA3QsYByPlJdF393WVq0kVAHqTFh7vUQG0P2LZ7oaKun9J05iYjB6JmtuVgdKONNgIrAN6wheoRbXhJIzt7P2rYjJBcg) | 'color'=> 'rgba(102, 255, 204, 0.2)', 'fontawesome' => 'fa fa-spinner fa-spin'
Pjax с произвольным блоком | ![Pjax с произвольным блоком](https://lh3.googleusercontent.com/vrVhhcYB0sT-9GxE4Jx78K7XoN6Rh6E442sL190I4Gvv-e00zT4pShSZ4RHwfnePVhOqa-2RW0ePF1OcPXQb6YkhL74KFqzfSatFoJ0GNPBdHHY0wGtQAEsERHtt3QWCX8sqjw) | 'color'=> 'rgba(255, 102, 255, 0.3)'

## Демонстрация работы

[Demo страничка jQuery LoadingOverlay](https://gasparesganga.com/labs/jquery-loading-overlay/)

## Установка

Запустить команду
``` json
php composer.phar require --prefer-dist timurmelnikov/yii2-loading-overlay "~1.0.0"
```

Добавить в секцию "require" файла composer.json:
``` json
{
    "require": {
        "timurmelnikov/yii2-loading-overlay": "~1.0.0"
    }
}
```
После добавления, выполнить команду: composer update

## Использование

Есть 2 способа использования:

### 1-й - просто подключаем jQuery LoadingOverlay к представлению

В представлении, где будет использоваться yii2-loading-overlay, подключить:
``` php
timurmelnikov\widgets\LoadingOverlayAsset::register($this);
```

Далее, использовать обычный JavaScript, для отображения/скрытия jQuery LoadingOverlay, руководствуясь  [документацией jQuery LoadingOverlay](https://gasparesganga.com/labs/jquery-loading-overlay/), например так:
``` php
<?php

//Код на JavaScript (heredoc-синтаксис)
$script = <<< JS

    //Настройки (можно не использовать, тогда - все по умолчанию)
    $.LoadingOverlaySetup({
        color           : "rgba(0, 0, 0, 0.4)",
        maxSize         : "80px",
        minSize         : "20px",
        resizeInterval  : 0,
        size            : "50%"
    });

    //Наложение jQuery LoadingOverlay на элемент с ID #p0, при отправке AJAX-запроса
    $(document).ajaxSend(function(event, jqxhr, settings){
        $("#p0").LoadingOverlay("show");
    });

    //Скрытие jQuery LoadingOverlay на элемент с ID #p0, после выполнения AJAX-запроса
    $(document).ajaxComplete(function(event, jqxhr, settings){
        $("#p0").LoadingOverlay("hide");
    });

JS;

//Подключение скрипта в представлении
$this->registerJs($script, yii\web\View::POS_READY);

?>
```

### 2-й - работа с Pjax

Класс LoadingOverlayPjax, является расширением стандартного yii\widgets\Pjax и наследует все его поведение.

В представлении, где будет использоваться Pjax, подключить:
``` php
use timurmelnikov\widgets\LoadingOverlayPjax;
```

Использовать, вместо стандартного Pjax, "оборачивая" в него, например GridView (Скриншот 1):
``` php
<?php LoadingOverlayPjax::begin([
'color'=> 'rgba(102, 255, 204, 0.2)',
'fontawesome' => 'fa fa-spinner fa-spin'
]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'phone',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php LoadingOverlayPjax::end(); ?>
```

## Настройки

Для настроек, использовать публичные свойства класса LoadingOverlayPjax, например:
``` php
<?php LoadingOverlayPjax::begin([
    'color'=> 'rgba(255, 255, 44, 0.8)', //Настраиваем цвет
    'elementOverlay' => '#element'       //Картинка лоадера, наложится на DOM элемент с id="element"
]); ?>
...
<?php LoadingOverlayPjax::end(); ?>
```

### Перечень настроек (свойств)

Свойство | Описание
------------ | -------------
color | Свойство CSS background-color в формате rgba()
fade | Управление появлением / затуханием
fontawesome | Классы иконок Font Awesome (необходим Font Awesome, например - https://github.com/rmrevin/yii2-fontawesome)
image | URL картинки
imagePosition" | Свойство CSS background-position, для настройки расположения изображения
maxSize | Максимальный размер в пикселях
minSize | Минимальный размер в пикселях
size | Размер изображения в процентах
zIndex | Свойство CSS z-index
elementOverlay | Альтернативный DOM элемент наложения jQuery LoadingOverlay

Примечание: Свойство "fontawesome" , имеет более высокий преоритет, чем свойство "image". Если установлены 2 настройки "image" и "fontawesome", "image" - игнорируется, "fontawesome" - отображается.