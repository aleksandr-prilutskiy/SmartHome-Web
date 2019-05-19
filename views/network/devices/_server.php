<?php
echo $this->render('..\..\layouts\_boxstart', [
    'class' => 'col-lg-6 col-md-12 col-sm-12 col-xs-12',
    'title' => 'Управление сервером',
    'icon' => 'fas fa-server']);
?>
<table>
    <tr>
        <td width='125'>
            <div class="checkbox">
                <input id="server_off" type="checkbox" data-toggle="toggle" data-size="large" checked
                       data-onstyle="success" data-on="Вкл" data-offstyle="danger" data-off="Выкл">
            </div>
        </td>
        <td>Выключить сервер</td>
    </tr>
    <tr>
        <td><a href="#" class="btn btn-lg btn-primary btn-setting text-center reboot">RESET</a></td>
        <td>Перезагрузить сервер</td>
    </tr>
</table>
<?php echo $this->render('..\..\layouts\_boxend');
echo $this->render('..\..\layouts\_boxstart', [
    'class' => 'col-lg-6 col-md-12 col-sm-12 col-xs-12',
    'title' => 'Управление звуком',
    'icon' => 'fas fa-volume-up']);
?>
<table>
    <tr>
        <td width='120'>
            <div class="checkbox">
                <input id="sound_on_off" type="checkbox" data-toggle="toggle" data-size="large"
                       data-onstyle="success" data-on="Вкл" data-offstyle="danger" data-off="Выкл">
            </div>            
        </td>
        <td>Включение / отключение звука</td>
    </tr>
</table>
<?php echo $this->render('..\..\layouts\_boxend'); ?>

<div id="ModalBoxReboot" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Перезагрузить сервер</h4>
      </div>
      <div class="modal-body">
          Вы действительно хотите перезагрузить сервер?<br>
          Это действие займет некоторое время.<br>
          Во время перезагрузки сервера сервисы системы будут недоступны.
      </div>
      <div class="modal-footer">
          <a href="#" class="btn btn-default" data-dismiss="modal" onclick="showmodal = false;">Нет</a>
          <a href="#" class="btn btn-danger" data-dismiss="modal" onclick="location='?r=server/reboot/';">Да</a>
      </div>
    </div>
  </div>
</div>

<div id="ModalBoxShutdown" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Выключить сервер</h4>
      </div>
      <div class="modal-body">
          Вы действительно хотите выключить сервер?<br>
          Внимание!<br>
          После выключения сервера сервисы системы будут недоступны.<br>
          Удаленно включить сервер после выключения будет невозможно.
      </div>
      <div class="modal-footer">
          <a href="#" class="btn btn-default" data-dismiss="modal" onclick="checkbox_shutdown_skip();">Нет</a>
          <a href="#" class="btn btn-danger" data-dismiss="modal" onclick="location='?r=server/shutdown/'">Да</a>
      </div>
    </div>
  </div>
</div>

<script>
function checkbox_sound_on(){
 var XMLHttp = GetXMLHttp();
 XMLHttp.open("GET", "?r=ajax/event&app=server&cmd=unmute", false);
 XMLHttp.send(null);
 document.getElementById('sound_on_off').onchange = checkbox_sound_off;
// $('#switch-on-off').bootstrapToggle('disable');
} // checkbox_sound_on

function checkbox_sound_off(){
 showmodal = false;
 var XMLHttp = GetXMLHttp();
 XMLHttp.open("GET", "?r=ajax/event&app=server&cmd=mute", false);
 XMLHttp.send(null);
 document.getElementById('sound_on_off').onchange = checkbox_sound_on;
// $('#sound_on_off').bootstrapToggle('enable');
} // checkbox_sound_off

function load_data(){
 var XMLHttp = GetXMLHttp();
 XMLHttp.open("GET", "?r=ajax/device&id=<?= $device->id ?>", false);
 XMLHttp.send(null);
 if (XMLHttp.status === 200) {
  var XML = XMLHttp.responseXML;
  var items = XML.getElementsByTagName("Devices");
  if (items) {
   if (items.item(0).getElementsByTagName("state").item(0).innerHTML & 0x0002) {
    document.getElementById('sound_on_off').onchange = null;
    //$('#sound_on_off').bootstrapToggle('enable');
    $('#sound_on_off').bootstrapToggle('on');
    document.getElementById('sound_on_off').onchange = checkbox_sound_off;
    //$('#sound_on_off').bootstrapToggle('enable');
   } else {
    document.getElementById('sound_on_off').onchange = null;
    //$('#sound_on_off').bootstrapToggle('enable');
    $('#sound_on_off').bootstrapToggle('off');
    document.getElementById('sound_on_off').onchange = checkbox_sound_on;
    //$('#sound_on_off').bootstrapToggle('enable');
   }   
  }
 }
 setTimeout(load_data, 5000);
} // load_data

window.onload = load_data;
</script>
