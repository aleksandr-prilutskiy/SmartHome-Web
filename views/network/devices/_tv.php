<?php
use app\models\Tv_channel;
use app\models\Tv_channel_map;
use app\models\Tv_program;
$channels = Tv_channel_map::find()
    ->leftJoin('tv_channel', 'tv_channel.channel_id = tv_channel_map.channel_id')
    ->where(['device' => $device->name])
    ->orderBy('id')
    ->all();
echo $this->render('..\..\layouts\_boxstart', [
    'class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12',
    'title' => 'Управление телевизором',
    'icon' => 'fas fa-gamepad']);
?>
<table>
    <tr>
        <td width='120'>
            <div class="checkbox">
                <input id="switch-on-off" type="checkbox" data-toggle="toggle" data-size="large" disabled
                    data-onstyle="success<?php if (!$device->option_can_off) { echo " disabled"; } ?>" data-on="Вкл"
                    data-offstyle="danger<?php if (!$device->option_can_on) { echo " disabled"; } ?>" data-off="Выкл">
            </div>
        </td>
        <td>Включение / выключение телевизора</td>
    </tr>
</table>
<div id="buttons" style="display: none">
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-2">
                    <a href="#" class="btn btn-primary btn-setting btn-block" onclick="send_command('channel_up');"><i class="fas fa-angle-double-up"></i></a><br>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-10 text-left" style="margin-top: 7px">Канал - следующий</div>
            </div>
            <div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-2">
                    <a href="#" class="btn btn-primary btn-setting btn-block" onclick="send_command('channel_down');"><i class="fas fa-angle-double-down"></i></i></a>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-10 text-left" style="margin-top: 7px">Канал - предыдущий</div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-2">
                    <a href="#" class="btn btn-primary btn-setting btn-block" onclick="send_command('volume_up');"><i class="fas fa-volume-up"></i></a><br>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-10 text-left" style="margin-top: 7px">Звук - громче</div>
            </div>
            <div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-2">
                    <a href="#" class="btn btn-primary btn-setting btn-block" onclick="send_command('volume_down');"><i class="fas fa-volume-down"></i></a><br>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-10 text-left" style="margin-top: 7px">Звук - тише</div>
            </div>
            <br>
            <div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-2">
                    <a href="#" class="btn btn-primary btn-setting btn-block" onclick="send_command('mute');"><i class="fas fa-volume-mute"></i></a>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-10 text-left">Включить / отключить звук</div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-2">
                    <a href="#" class="btn btn-primary btn-setting btn-block" onclick="send_command('play');"><i class="fas fa-play"></i></a><br>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-10 text-left" style="margin-top: 7px">Воспроизведение</div>
            </div>
            <div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-2">
                    <a href="#" class="btn btn-primary btn-setting btn-block" onclick="send_command('pause');"><i class="fas fa-pause"></i></a><br>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-10 text-left" style="margin-top: 7px">Пауза</div>
            </div>
            <div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-2">
                    <a href="#" class="btn btn-primary btn-setting btn-block" onclick="send_command('return');"><i class="fas fa-undo"></i></a>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-10 text-left" style="margin-top: 7px">Возврат / Отмена</div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->render('..\..\layouts\_boxend');
echo $this->render('..\..\layouts\_boxstart', [
    'class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12',
    'title' => 'Список каналов',
    'icon' => 'fas fa-clipboard-list',
    'buttons' => Yii::$app->user->identity->username == 'admin' ?
        [['url' => '?r=tv/setup&id='.$device->id, 'icon' => 'glyphicon-cog']] : '']);
?>
<table class="table table-striped">
    <tbody>
<?php  foreach ($channels as $channel):
$program = Tv_program::find()
    ->where(['channel_id' => $channel->channel_id])
    ->andWhere('stop > NOW()')
    ->orderBy('start')
    ->one();
$program_next = Tv_program::find()
    ->where(['channel_id' => $channel->channel_id])
    ->andWhere('start > NOW()')
    ->orderBy('start')
    ->one();
$program_next_time = date_parse_from_format("Y-m-d H:i:s", $program_next->start); ?>
        <tr>
            <td width="100">
                <a href="#" onclick="set_channel('<?= $channel->number ?>');">
<?php if (file_exists(Yii::getAlias('@webroot')."/images/tv/".$channel->channel_id.".png")) { ?>
                    <img src="images\tv\<?= $channel->channel_id ?>.png" width="60" height="45">
<?php } else { ?>
                    <img src="images\no_image_80.jpg" width="60" height="45">
<?php } ?>
                </a>
            </td>
            <td width="100%">
                <table>
<?php if ($program !== null) { ?>
                    <tr>
                        <td width = "70" class="text-right" valign="top"><strong>Сейчас</strong>&nbsp;</td>
                        <td><?= $program->name ?></td>
                    </tr>
<?php } if ($program_next !== null) { ?>
                    <tr>
                        <td class="text-right" valign="top"><strong><?= str_pad($program_next_time[hour], 2, '0', STR_PAD_LEFT).':'.
                            str_pad($program_next_time[minute], 2, '0', STR_PAD_LEFT) ?></strong>&nbsp;</td>
                        <td><?= $program_next->name ?></td>
                    </tr>
<?php } ?>
                </table>
            </td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>
<?php echo $this->render('..\..\layouts\_boxend'); ?>

<div id="ModalBoxShutdown" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Выключить сервер</h4>
      </div>
      <div class="modal-body">
          Вы действительно хотите выключить телевизор?<br>
<?php if (!$device->option_can_on) { ?>
          Удаленно включить телевизор после выключения будет невозможно.
<?php } ?>
      </div>
      <div class="modal-footer">
          <a href="#" class="btn btn-default" data-dismiss="modal" onclick="checkbox_off_confirm_skip();">Нет</a>
          <a href="#" class="btn btn-danger" data-dismiss="modal" onclick="checkbox_off();">Да</a>
      </div>
    </div>
  </div>
</div>

<script>
function set_channel($channel){
 var XMLHttp = GetXMLHttp();
 XMLHttp.open('GET', "?r=ajax/event&cmd=channel&device=<?= $device->name ?>&param="+$channel, false);
 XMLHttp.send(null);
}

function send_command($cmd){
 var XMLHttp = GetXMLHttp();
 XMLHttp.open('GET', "?r=ajax/event&cmd="+$cmd+"&device=<?= $device->name ?>", false);
 XMLHttp.send(null);
}

function checkbox_on(){
 var XMLHttp = GetXMLHttp();
 XMLHttp.open("GET", "?r=ajax/event&cmd=on&device=<?= urlencode($device->name) ?>", false);
 XMLHttp.send(null);
 document.getElementById('buttons' ).style.display = 'block';
<?php if ($device->option_can_off) { ?>
<?php if (!$device->option_can_on) { ?>
    document.getElementById('switch-on-off').onchange = checkbox_off_confirm;
<?php } else { ?>
    document.getElementById('switch-on-off').onchange = checkbox_off;
<?php } ?>
 $('#switch-on-off').bootstrapToggle('enable');
<?php } else {?>
 document.getElementById('switch-on-off').onchange = null;
 $('#switch-on-off').bootstrapToggle('disable');
<?php } ?>
 skipcount = 2;
}

function checkbox_off(){
 showmodal = false;
 var XMLHttp = GetXMLHttp();
 XMLHttp.open("GET", "?r=ajax/event&cmd=off&device=<?= urlencode($device->name) ?>", false);
 XMLHttp.send(null);
 document.getElementById('buttons' ).style.display = 'none';
<?php if ($device->option_can_on) { ?>
 document.getElementById('switch-on-off').onchange = checkbox_on;
 $('#switch-on-off').bootstrapToggle('enable');
<?php } else {?>
 document.getElementById('switch-on-off').onchange = null;
 $('#switch-on-off').bootstrapToggle('disable');
<?php } ?>
 skipcount = 2;
}

function checkbox_off_confirm(){
 showmodal = true;
 $("#ModalBoxShutdown").modal('show');
}

function checkbox_off_confirm_skip(){
 $('#switch-on-off').bootstrapToggle('on');
 showmodal = false;
}

function load_data(){
 if ((skipcount > 0) || showmodal) {
  skipcount = skipcount - 1;
  setTimeout(loadXML, 5000);
  return;
 }
 var XMLHttp = GetXMLHttp();
 XMLHttp.open("GET", "?r=ajax/device&id=<?= $device->id ?>", false);
 XMLHttp.send(null);
 if (XMLHttp.status === 200) {
  var XML = XMLHttp.responseXML;
  var items = XML.getElementsByTagName("Devices");
  if (items) {
   if (items.item(0).getElementsByTagName("state").item(0).innerHTML > 0) {
    document.getElementById('buttons' ).style.display = 'block';
    document.getElementById('switch-on-off').onchange = null;
    $('#switch-on-off').bootstrapToggle('enable');
    $('#switch-on-off').bootstrapToggle('on');
<?php if ($device->option_can_off) { ?>
<?php if (!$device->option_can_on) { ?>
    document.getElementById('switch-on-off').onchange = checkbox_off_confirm;
<?php } else { ?>
    document.getElementById('switch-on-off').onchange = checkbox_off;
<?php } ?>
    $('#switch-on-off').bootstrapToggle('enable');
<?php } else { ?>
    $('#switch-on-off').bootstrapToggle('disable');
<?php } ?>
   } else {
    document.getElementById('buttons' ).style.display = 'none';
    document.getElementById('switch-on-off').onchange = null;
    $('#switch-on-off').bootstrapToggle('enable');
    $('#switch-on-off').bootstrapToggle('off');
<?php if ($device->option_can_on) { ?>
    document.getElementById('switch-on-off').onchange = checkbox_on;
    $('#switch-on-off').bootstrapToggle('enable');
<?php } else {?>
    $('#switch-on-off').bootstrapToggle('disable');
<?php } ?>
   }
  }
 }
 setTimeout(load_data, 5000);
} // load_data

var skipcount = 0;
var showmodal = false;
window.onload = load_data;
</script>
