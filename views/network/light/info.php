<?php
use yii\helpers\Html;
$this->title = 'Информация об устройстве nooLite';
$view = '';
$dir = Yii::getAlias('@app').'\views\network\devices\\';
$img = '<img src="images\no_image_255.jpg" class="img-thumbnail" width="360" height="510">';
if ($device->image <> '') {
    $path = Yii::getAlias('@webroot').'/images/devices/'.$device->image.'.jpg';
    if (file_exists($path)) $img = str_replace('no_image_255.jpg', '\devices\\'.$device->image.'.jpg', $img);
}
$this->registerCssFile('css/bootstrap-toggle.min.css');
$this->registerJsFile('js/smarthome.js', ['position' => yii\web\View::POS_HEAD]);
$this->registerJsFile('js/bootstrap-toggle.min.js', ['position' => yii\web\View::POS_END]);
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs text-center"><?= $img ?></div>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                    <div class="box-inner">
                        <table class="table table-striped table-condensed">
                            <tbody>
                                <tr>
                                    <td class="text-right">Наименование:</td>
                                    <td width="100%"><?= $device->name ?></td>
                                </tr>
                                <tr>
                                    <td class="text-right">Описание:</td>
                                    <td><?= $device->description ?></td>
                                </tr>
<?php if ($device->addr <> '') { ?>
                                <tr>
                                    <td class="text-right">Адрес:</td>
                                    <td><?= $device->addr ?></td>
                                </tr>
<?php } if ($device->parameters <> '') { ?>
                                <tr>
                                    <td class="text-right">Канал привязки:</td>
                                    <td><?= $device->parameters ?></td>
                                </tr>
<?php } if ($device->webpage <> '') { $links = explode(";", $device->webpage); ?>
                                <tr>
                                    <td class="text-right">Web-интерфейс:</td>
                                    <td>
<?php foreach ($links as $link):
    $str = explode("=", $link);
    if (count($str) > 1) { $link_name = $str[0]; $link_url = $str[1];} 
    else { $link_name = 'ссылка'; $link_url = $str[0];} ?>
                                        <a href="<?= $link_url ?>" target="_blanc"><?= $link_name ?></a><br>
<?php endforeach; ?>
                                    </td>
                                </tr>
<?php } if ($device->manufacture <> '') { $links = explode(";", $device->manufacture); ?>
                                <tr>
                                    <td class="text-right">Сайт производителя:</td>
                                    <td>
<?php foreach ($links as $link):
    $str = explode("=", $link);
    if (count($str) > 1) { $link_name = $str[0]; $link_url = $str[1];} 
    else { $link_name = 'ссылка'; $link_url = $str[0];} ?>
                                        <a href="<?= $link_url ?>" target="_blanc"><?= $link_name ?></a><br>
<?php endforeach; ?>
                                    </td>
                                </tr>
<?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8 col-sm-12 col-xs-12 text-center">
                        <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                                <h2>Управление</h2>
                            </div>
                            <br>
                            <input id="switch"
                                type="checkbox" data-toggle="toggle" data-size="large" disabled
                                data-onstyle="success" data-on="Вкл"
                                data-offstyle="danger" data-off="Выкл"
                                data-device="<?= $device->name ?>"
                                data-options="<?= $device->options ?>">
                            <br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="ModalBoxConfirm" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Выключить устройство</h4>
      </div>
      <div class="modal-body">
          Вы действительно хотите выключить выбранное устройство?<br>
          Внимание!<br>
          После выключения, удаленно включить это устройство будет невозможно.
      </div>
      <div class="modal-footer">
          <a href="#" class="btn btn-default modal-button-cancel" data-dismiss="modal" onclick="">Нет</a>
          <a href="#" class="btn btn-danger modal-button-ok" data-dismiss="modal" onclick="">Да</a>
      </div>
    </div>
  </div>
</div>

<script>
function checkbox_on(id){
 var obj = document.getElementById('switch');
 if (obj == null) return;
 var XMLHttp = GetXMLHttp();
 XMLHttp.open('GET', '?r=ajax/event&cmd=on&device=' + encodeURIComponent(obj.getAttribute('data-device')), false);
 XMLHttp.send(null);
 $('#switch_' + id).bootstrapToggle('disable');
 skipcount = 2;
} // checkbox_on
    
function checkbox_off(id){
 var obj = document.getElementById('switch');
 if (obj == null) return;
 var XMLHttp = GetXMLHttp();
 XMLHttp.open('GET', '?r=ajax/event&cmd=off&device=' + encodeURIComponent(obj.getAttribute('data-device')), false);
 XMLHttp.send(null);
 skipcount = 2;
 $('#switch_' + id).bootstrapToggle('disable');
 showmodal = false;
} // checkbox_off

function checkbox_off_confirm(id){
 showmodal = true;
 var modal = $(document.getElementById('ModalBoxConfirm'));
 modal.find('.modal-button-ok').attr('onclick', 'checkbox_off(' + id + ')');
 modal.find('.modal-button-cancel').attr('onclick', 'lamp_on(' + id + ')');
 $("#ModalBoxConfirm").modal('show');
} // checkbox_off_confirm

function lamp_on(id){
 var obj = document.getElementById('switch');
 if (obj == null) return;
 obj.onchange = null;
 $('#switch_' + id).bootstrapToggle('enable');
 $('#switch_' + id).bootstrapToggle('on');
 var options = obj.getAttribute('data-options');
 if (options & 0x0002) {
  if (options & 0x0004)
   obj.setAttribute('onchange', 'checkbox_off(' + id + ')');
  else
   obj.setAttribute('onchange', 'checkbox_off_confirm(' + id + ')');
 } else $('#switch_' + id).bootstrapToggle('disable');
 showmodal = false;
} // lamp_on

function lamp_off(id){
 var obj = document.getElementById('switch');
 if (obj == null) return;
 obj.onchange = null;
 $('#switch_' + id).bootstrapToggle('enable');
 $('#switch_' + id).bootstrapToggle('off');
 var options = obj.getAttribute('data-options');
 if (options & 0x0004)
  obj.setAttribute('onchange', 'checkbox_on(' + id + ')');
 else
  $('#switch_' + id).bootstrapToggle('disable');
 showmodal = false;
} // lamp_off

function loadstate(){
 if ((skipcount > 0) || showmodal) {
  skipcount = skipcount - 1;
  setTimeout(loadstate, 2000);
  return;
 }
 var XMLHttp = GetXMLHttp();
 XMLHttp.open("GET", "?r=ajax/device&id=<?= $device->id ?>", false);
 XMLHttp.send(null);
 if (XMLHttp.status === 200) {
  var XML = XMLHttp.responseXML;
  var items = XML.getElementsByTagName("Devices");
  if (items) {
   for (var i = 0; i < items.length; i++) {
    var item = items.item(i);
    var id = item.getElementsByTagName("id").item(0).innerHTML;
    if (document.getElementById('switch') != null) {
     if (item.getElementsByTagName('state').item(0).innerHTML > 0)
      lamp_on(id);
     else
      lamp_off(id);
    }
   }
  }
 }
 setTimeout(loadstate, 2000);
} // loadstates

var skipcount = 0;
var showmodal = false;
window.onload = loadstate;
</script>
