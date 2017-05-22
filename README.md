yii2-loading-overlay
================
Yii2 расширение-обертка для подключения плагина jQuery LoadingOverlay  
Расширение предназначено для наложения картинки Ajax загрузки на блок, при обработке Ajax запроса.

# Плагин, еще не готов!!!

## Демонстрация работы
[Demo страничка плагина](https://gasparesganga.com/labs/jquery-loading-overlay/)

## Установка
Добавить в секцию "require" файла composer.json:
``` json
{
    "require": {
        "timurmelnikov/yii2-loading-overlay": "dev-master"
    }
}
```

## Использование

Есть 2 способа пользоваться расширениеем:

1-й - просто подключаем jQuery LoadingOverlay к представление

В представлении, где будет использоваться yii2-loading-overlay, подключить:
``` php
use timurmelnikov\widgets\LoadingOverlayAsset;
```

Далее, использовать обычный JavaScript, для отображения/скрытия jQuery LoadingOverlay, руководствуясь  [документацией jQuery LoadingOverlay](https://gasparesganga.com/labs/jquery-loading-overlay/), например так:
``` php
<?php

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

2-й - способ - Pjax

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
            'phone',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php LoadingOverlayPjax::end(); ?>
```


## Настройки (не готово...)

Свойство "fontawesome" работает, если к проекту подключен Font Awesome. Например - https://github.com/rmrevin/yii2-fontawesome