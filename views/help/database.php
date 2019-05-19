<?php
use yii\helpers\Html;
$this->title = 'Структура базы данных';
$this->params['breadcrumbs'][] = [
    'label' => 'Справка',
    'url' => '?r=help/index'.$page,
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => Html::encode($this->title),
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
echo $this->render('..\layouts\_boxstart', [
    'title' => Html::encode($this->title),
    'icon' => 'fas fa-question']);
?>
<strong>2.1.1. Основные таблицы системы</strong><br>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-content text-left" data-original-title="">
            <strong>config</strong> - таблица настроек системных переменных.
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-down"></i></a>
            </div>
        </div>
        <div class="box-content text-left" style="display:none">
            <strong>id</strong> - индекс записи<br>
            <strong>name</strong> - наименование системной переменной<br>
            <strong>data</strong> - значение системной переменной<br>
        </div>
    </div>
    <div class="box-inner">
        <div class="box-content text-left" data-original-title="">
            <strong>shedule</strong> - таблица рассписания событий системы.
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-down"></i></a>
            </div>
        </div>
        <div class="box-content text-left" style="display:none">
            <strong>id</strong> - индекс записи<br>
            <strong>command</strong> - команда (должна совпадать с именем обработчика событий)<br>
            <strong>parameters</strong> - параметр или список параметров, передаваемых обработчику<br>
            <strong>mode</strong> - режим повторения событий<br>
            <strong>period</strong> - период повторения событий<br>
            <strong>next_time</strong> - дата и время следующего возникновения собития<br>
            <strong>description</strong> - описание события<br>
        </div>
    </div>
    <div class="box-inner">
        <div class="box-content text-left" data-original-title="">
            <strong>events</strong> - таблица событий системы.
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-down"></i></a>
            </div>
        </div>
        <div class="box-content text-left" style="display:none">
            <strong>id</strong> - индекс записи<br>
            <strong>event</strong> - код события<br>
            <strong>device</strong> - адрес устройства в системе<br>
            <strong>data</strong> - дополнительный параметр<br>
            <strong>status</strong> - статус обработки события:<br>
            &nbsp;0 = не обработано<br>
            &nbsp;1 = обработано<br>
            &nbsp;-1 = пропущено<br>
            <strong>time</strong> - дата и время создания (если на обработано) или обработки (если обработано) события<br>
        </div>
    </div>
    <div class="box-inner">
        <div class="box-content text-left" data-original-title="">
            <strong>system_log</strong> - таблица журнала событий системы.
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-down"></i></a>
            </div>
        </div>
        <div class="box-content text-left" style="display:none">
            <strong>id</strong> - индекс записи<br>
            <strong>creator</strong> - скрипт или устройство, породившее событие<br>
            <strong>event</strong> - код события<br>
            <strong>description</strong> - краткое описание события<br>
            <strong>logfile</strong> - копия файла журнала обработки события<br>
            <strong>error</strong> - признак ошибки (если 1 - ошибка в результате обработки события)<br>
            <strong>readed</strong> - признак прочтения (если 1 - отчет о событии был просмотрен)<br>
            <strong>time</strong> - дата и время обработки события<br>
        </div>
    </div>
</div>
<strong>2.1.2. Таблицы для работы с устройствами и датчиками в сети</strong><br>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            devices
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-down"></i></a>
            </div>
        </div>
        <div class="box-content text-left" style="display:none">
            - список устройств "Умного дома"<br>
            <strong>id</strong> - индекс устройства в системе<br>
            <strong>name</strong> - наименование устройства (должно быть уникально)<br>
            <strong>type</strong> - тип устройства (идентификатор типа)<br>
            <strong>description</strong> - краткое описание устройства<br>
            <strong>driver</strong> - имя обработчика событий (драйвера) устройства<br>
            Путь к каталогу драйверов устройств должен быть задан в записи 'CommandFilesDir' таблицы 'config'<br>
            <strong>addr</strong> - адрес устройства (ip или другой адрес в системе)<br>
            <strong>options</strong> - различные опции, используемые в системе (побитовая маска):<br>
            0x0001 - разрешена проверка устройства (команда PING или иным образом)<br>
            0x0002 - устройство может быть отключено дистанционно<br>
            0x0004 - устройство может быть включено дистанционно<br>
            0x0010 - разрешено прослушивание музыки на устройстве<br>
            0x0020 - разрешен просмотр видео на устройстве<br>
            <strong>state</strong> - состояние устройства:<br>
            0 - выключено<br>
            1 - включено<br>
            <strong>parameters</strong> - дополнительные параметры<br>
image
            <strong>map_icon</strong> - имя файла иконки для отображения устройства на плане помещений<br>
            <strong>map_pos</strong> - координаты (X:Y) отображения устройства на плане помещений<br>
            <strong>webpage</strong> - web-страница устройства<br>
            <strong>manufacture</strong> - ссылка на стрницу описания устройства на сайте производителя<br>
            <strong>manuals</strong> - фалы руководства или описания устройства<br>
            <strong>updated</strong> - дата и время последнего обновления записи<br>
        </div>
    </div>
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            sensors
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-down"></i></a>
            </div>
        </div>
        <div class="box-content text-left" style="display:none">
            - список датчиков "Умного дома"<br>
            <strong>id</strong> - индекс записи<br>
            <strong>description</strong> - краткое описание типа датчика<br>
            <strong>units</strong> - единицы измерения<br>
            <strong>value</strong> - последнее сохраненное значение<br>
            <strong>viewmode</strong> - режим отображения показаний датчика:<br>
            0 - в виде таблицы<br>
            1 - в виде графика<br>
            <strong>min</strong> - минимальное значение показаний датчика при отображении в виде графика<br>
            <strong>max</strong> - максимальное значение показаний датчика при отображении в виде графика<br>
            <strong>map_icon</strong> - имя файла иконки для отображения датчика на плане помещений<br>
            <strong>map</strong> - координаты (X:Y) отображения датчика на плане помещений<br>
            <strong>av_temperature</strong> - если =1, то участвует в расчете средней температуры в помещении<br>
            <strong>av_humidity</strong> - если =1, то участвует в расчете средней влажности в помещении<br>
            <strong>time</strong> - дата и время последнего обновления записи<br>
        </div>
    </div>
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            sensors_data
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-down"></i></a>
            </div>
        </div>
        <div class="box-content text-left" style="display:none">
            - значения показаний датчиков "Умного дома"<br>
            <strong>id</strong> - индекс записи<br>
            <strong>sensor</strong> - индекс датчика в системе "Умный дом"<br>
            <strong>value</strong> - значение<br>
            <strong>status</strong> - статус обработки полученных данных:<br>
            &nbsp;0 = не обработано<br>
            &nbsp;1 = обработано<br>
            &nbsp;-1 = пропущено<br>
            <strong>timestamp</strong> - дата и время последнего обновления записи<br>
        </div>
    </div>
</div>
<strong>2.1.3. Таблицы для мультимедиа контента</strong><br>
<p>
<strong>movies_files</strong> - таблица настроек системных переменных<br>
<strong>movies_info</strong> - <br>
<strong>movies_metadata</strong> - <br>
<strong>series_files</strong> - <br>
<strong>series_names</strong> - <br>
<strong>series_seasons</strong> - <br>
<strong>music_albums</strong> - <br>
<strong>music_artists</strong> - <br>
<strong>music_files</strong> - <br>
<strong>photo_albums</strong> - <br>
<strong>photo_files</strong> - <br>
<p>
<strong>2.1.4. Прочие таблицы</strong><br>
<p>
<strong>system_monitor</strong> - <br>
<strong>server_sysinfo</strong> - <br>
<strong>weather_forecast</strong> - <br>
</p>
<?php echo $this->render('..\layouts\_boxend'); ?>
