<?php
use yii\helpers\Html;
$this->title = 'Настройки системы';
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
<strong>1.3.1. Администрирование системы</strong><br>
<p>
Настройка работы сисемы соуществляется через пункт меню <a href="?r=config/index">Администрирование -> Настройки системы</a>.<br>
<br>
Описание переменных:<br>
<strong>ServerAddr</strong> - IP-адрес сервера в локальной сети.<br>
<strong>LocalNetworkMask</strong> - адрес подсети 'домашей' локальной сети (часть IP-адреса, которая накладывается на маску подсети).<br>
Например: если адреса в сети 192.168.1.х, а маска подсети 255.255.255.0, то LocalNetworkMask = '192.168.1'.<br>
<strong>CommandFilesDir</strong> - путь к каталогу, в котором размещены утилиты.<br>

<strong>ServerDLNA</strong> - IP-адрес сервера DLNA.<br>
<strong>PortDLNA</strong> - порт сервера DLNA (используется вместе с 'ServerAddr').<br>
<strong>WebServerDir</strong> - <br>
<br>
<br>
WebServerDir', 'C:\\AppServ\\www\\web\\'<br>
MoviesDir', 'D:\\Movies\\'<br>
MusicDir', 'F:\\Music\\'<br>
SeriesDir', 'F:\\Series\\'<br>
PhotoDir', 'F:\\Foto\\По годам\\'<br>
ShareFileDir', 'G:\\Share\\'<br>
DDNS_Domains', 'prilutskiy.ddns.net'<br>
DDNS_User', 'prilutskiy'<br>
DDNS_Password', 'n91162'<br>
TMDB_API_Key', 'c8a6908cfae9058fc46a7dd8ceae34e7'<br>
WeatherCity', '524894'<br>
OpenWeatherMapAPIID', 'a9b68317aa26a37b16e9868bc314d420'<br>
TelegramToken', '493566984:AAHA9tD3lGsih0cBncJqXcig3E5nMRsOYmo'<br>
TelegramProxy', ''<br>
SMS_API_Key', ''<br>
</p>
<?php echo $this->render('..\layouts\_boxend'); ?>
