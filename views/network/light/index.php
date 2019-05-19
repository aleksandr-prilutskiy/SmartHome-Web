<?php
use yii\helpers\Html;
$this->registerCssFile('css/bootstrap-toggle.min.css');
$this->registerJsFile('js/smarthome.js', ['position' => yii\web\View::POS_HEAD]);
$this->registerJsFile('js/bootstrap-toggle.min.js', ['position' => yii\web\View::POS_END]);
$this->title = 'Освещение';
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
            <table class="table table-striped">
                <tbody>
<?php  foreach ($devices as $device): ?>
                    <tr>
                        <td>
                            <input id="switch_<?= $device->id ?>"
                                type="checkbox" data-toggle="toggle" data-size="large" disabled
                                data-onstyle="success" data-on="Вкл"
                                data-offstyle="danger" data-off="Выкл"
                                data-device="<?= $device->name ?>"
                                data-options="<?= $device->options ?>">
                        </td>
                        <td class="text-left" width="100%" onclick="location.href='?r=light/info&id=<?= $device->id ?>'" style="cursor: pointer;">
                            <?= $device->description ?>
                        </td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>
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
 var obj = document.getElementById('switch_' + id);
 if (obj == null) return;
 var XMLHttp = GetXMLHttp();
 XMLHttp.open('GET', '?r=ajax/event&cmd=on&device=' + encodeURIComponent(obj.getAttribute('data-device')), false);
 XMLHttp.send(null);
 $('#switch_' + id).bootstrapToggle('disable');
 skipcount = 2;
} // checkbox_on
    
function checkbox_off(id){
 var obj = document.getElementById('switch_' + id);
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
 var obj = document.getElementById('switch_' + id);
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
 var obj = document.getElementById('switch_' + id);
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

function loadstates(){
 if ((skipcount > 0) || showmodal) {
  skipcount = skipcount - 1;
  setTimeout(loadstates, 2000);
  return;
 }
 var XMLHttp = GetXMLHttp();
 XMLHttp.open("GET", "?r=ajax/device", false);
 XMLHttp.send(null);
 if (XMLHttp.status === 200) {
  var XML = XMLHttp.responseXML;
  var items = XML.getElementsByTagName("Devices");
  if (items) {
   for (var i = 0; i < items.length; i++) {
    var item = items.item(i);
    var id = item.getElementsByTagName("id").item(0).innerHTML;
    if (document.getElementById('switch_' + id) != null) {
     if (item.getElementsByTagName('state').item(0).innerHTML > 0)
      lamp_on(id);
     else
      lamp_off(id);
    }
   }
  }
 }
 setTimeout(loadstates, 2000);
} // loadstates

var skipcount = 0;
var showmodal = false;
window.onload = loadstates;
</script>
