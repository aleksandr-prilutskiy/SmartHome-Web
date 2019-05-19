<?php
use yii\helpers\Html;
$this->title = 'Справка';
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
<h4>Содержание</h4>
<strong>Описание системы</strong><br>
- Общая информация<br>
- Устройства<br>
- Настройки системы<br>
- Обработка событий<br>
<br>
<strong>Справочная информация</strong><br>
- Структура базы данных<br>
- Работа с модулями nooLite<br>
- Перечень утилит и команд<br>
<a href="?r=help/index&page=links">- Полезные ссылки</a><br>
<a href="?r=help/index&page=about">- О версии</a><br>
        </div>
    </div>
</div>