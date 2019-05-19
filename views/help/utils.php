<?php
use yii\helpers\Html;
$this->title = 'Перечень утилит и команд';
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
<strong>2.3.1. Server</strong><br>
- управление сервером Умного дома и общее управление всей системой:<br>
&nbsp;<strong>Server.exe off</strong> - выключение сервера;<br>
&nbsp;<strong>Server.exe reboot</strong> - перезагрузка сервера;<br>
&nbsp;<strong>Server.exe mute</strong> - выключение звука;<br>
&nbsp;<strong>Server.exe unmute</strong> - включение звука;<br>
&nbsp;<strong>Server.exe play {filename}</strong> - проигрывание указанного файла.<br><br>
<strong>2.3.2. nooLite</strong><br>
- управление устройствами <strong>nooLite</strong>:<br>
&nbsp;<strong>NooLite.exe on #{addr}</strong> - включение исполнительного модуля с номером <i>{addr}</i>;<br>
&nbsp;<strong>NooLite.exe off  #{addr}</strong> - выключение исполнительного модуля с номером <i>{addr}</i>;<br>
&nbsp;<strong>NooLite.exe switch #{addr}</strong> - переключение исполнительного модуля с номером <i>{addr}</i> (если был включен - выключить, если выключен - влючить);<br>
&nbsp;<strong>NooLite.exe temporary_on #{addr} {time}</strong> - временное включение исполнительного модуля на <i>{time}</i> секунд.<br><br>
<strong>2.3.3. SysInfo</strong><br>
- получение информации об апаратных ресурсах сервера.<br><br>
<strong>2.3.4. SMART</strong><br>
- диагностики состояния жестких.<br><br>
<strong>2.3.5. Movies</strong><br>
- добавление в базу данных информации о фильмах, размещенных на сервере:<br>
&nbsp;<strong>Movies.exe update</strong> - Выполнить обновление данных.<br><br>
<strong>2.3.6. Music</strong><br>
- добавление в базу данных информации о музыке, размещенной на сервере:<br>
&nbsp;<strong>Music.exe update</strong> - Выполнить обновление данных.<br><br>
<strong>2.3.7. Series</strong><br>
- добавление в базу данных информации о сериалах, размещенных на сервере:<br>
&nbsp;<strong>Series.exe update</strong> - Выполнить обновление данных.<br><br>
<strong>2.3.8. Photo</strong><br>
- добавление в базу данных информации о фотографиях, размещенных на сервере:<br>
&nbsp;<strong>Photo.exe update</strong> - Выполнить обновление данных.<br><br>
<strong>2.3.9. TV_Program</strong><br>
- загрузки програмы телевизионных передач:<br>
<strong>2.3.10. SamsungTV</strong><br>
- управление телевизовами <strong>Samsung</strong>:<br>
&nbsp;<strong>Samsung.exe off {addr}</strong> - выключение телевизора;<br>
&nbsp;<strong>Samsung.exe play {addr} {id}</strong> - проиграть на телевизоре медиаконтент (видео или музыку);<br>
&nbsp;<strong>Samsung.exe channel_up {addr}</strong> - переключение на следующий канал;<br>
&nbsp;<strong>Samsung.exe channel_down {addr}</strong> - переключение на предыдущий канал;<br>
&nbsp;<strong>Samsung.exe channel {addr} {channel}</strong> - преключение на канал с заданым номером;<br>
&nbsp;<strong>Samsung.exe volume_up {addr}</strong> - увеличение громкости;<br>
&nbsp;<strong>Samsung.exe volume_down {addr}</strong> - уменьшение громкости;<br>
&nbsp;<strong>Samsung.exe mute {addr}</strong> - отключение громкости;<br>
&nbsp;<strong>Samsung.exe play {addr}</strong> - запуск воспроизведения;<br>
&nbsp;<strong>Samsung.exe pause {addr}</strong> - остановка воспроизведения;<br><br>
&nbsp;<strong>Samsung.exe return</strong> - отмена текущего действия (возврат в основное состояние).<br><br>
<strong>2.3.11. Telegram</strong><br>
- отправка сообщений в мессенджер "<strong>Telegram</strong>":<br>
&nbsp;<strong>Telegram.exe send {id} {text}</strong> - отправка сообщения <i>{text}</i> пользователю <i>{id}</i> (или группе пользователей, чьи id указанны через запятую).<br><br>
<strong>2.3.12. SMS</strong><br>
- отправка SMS-сообщения на определенный телефонный номер:<br>
&nbsp;<strong>SMS.exe send {phone_nubmer} {text}</strong> - отправка сообщения <i>{text}</i> на телефон с номером <i>{phone_nubmer}</i>.<br><br>
<strong>2.3.13. Weather</strong><br>
- получение информации о прогнозе погоды.<br><br>
<strong>2.3.14. DDNS</strong><br>
- обновление учетной записи <strong>DDNS</strong>.<br><br>
<strong>2.3.15. CleanDB</strong><br>
- очистка базы данных (удаление записей с истекшим сроком хранения).<br><br>
<?php echo $this->render('..\layouts\_boxend'); ?>
