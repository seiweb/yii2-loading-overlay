yii2-loading-overlay
================
Yii2 расширение для подключения плагина jQuery LoadingOverlay  
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
После редактирования файла выполнить команду `composer update`

## Использование
В представлении, где будет использоваться yii2-loading-overlay, подключить:
``` php
use timurmelnikov\widgets\LoadingOverlay;
```
Вывести виджет:
``` php
echo LoadingOverlay::widget([
    //Параметры...
]);
```