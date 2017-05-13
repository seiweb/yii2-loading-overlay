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
В представлении, где будет использоваться yii2-loading-overlay, подключить:
``` php
use timurmelnikov\widgets\LoadingOverlay;
```
Вывести виджет:
``` php
echo LoadingOverlay::widget([
    'elementOverlay'=> '#p0',
    'color'=>'rgba(255, 55, 255, 0.8)',
    //'image'=>'http://192.168.19.83/yii2-extenation/web/img/IMG_20170513_105214.jpg'
    ]);
```