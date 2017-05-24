yii2-loading-overlay
================
Yii2 виджет-обертка для использования плагина [jQuery LoadingOverlay](https://gasparesganga.com/labs/jquery-loading-overlay/)  
Виджет предназначен для наложения картинки-лоадера на блок, при обработке Ajax запроса.

## Демонстрация работы

[Demo страничка jQuery LoadingOverlay](https://gasparesganga.com/labs/jquery-loading-overlay/)

## Установка

Запустить команду
``` json
php composer.phar require --prefer-dist timurmelnikov/yii2-loading-overlay "dev-master"
```

Добавить в секцию "require" файла composer.json:
``` json
{
    "require": {
        "timurmelnikov/yii2-loading-overlay": "dev-master"
    }
}
```
После добавления, выполнить команду: composer update

## Использование

Есть 2 способа использования:

### 1-й - просто подключаем jQuery LoadingOverlay к представление

В представлении, где будет использоваться yii2-loading-overlay, подключить:
``` php
use timurmelnikov\widgets\LoadingOverlayAsset;
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

Использовать, вместо стандартного Pjax, "оборачивая" в него, папример GridView:
``` php
<?php LoadingOverlayPjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

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

### Перечень возможных настроек

- "color"          - Свойство CSS background-color в формате rgba()
- "fade"           - Управление появлением / затуханием
- "fontawesome"    - Классы иконок Font Awesome (необходим Font Awesome, например - https://github.com/rmrevin/yii2-fontawesome)
- "image"          - URL картинки
- "imagePosition"  - Свойство CSS background-position, для настройки расположения изображения
- "maxSize"        - Максимальный размер в пикселях
- "minSize"        - Минимальный размер в пикселях
- "size"           - Размер изображения в процентах
- "zIndex"         - Свойство CSS z-index
- "elementOverlay" - Альтернативный DOM элемент наложения jQuery LoadingOverlay

Примечание: Свойство "fontawesome" , имеет более высокий преоритет, чем свойство "image". Если установлены 2 настройки "image" и "fontawesome", "image" - игнорируется, "fontawesome" - отображается.