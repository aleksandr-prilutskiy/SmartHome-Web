<?php
use yii\helpers\Html;
$this->title = 'План помещений';
$this->registerJsFile('js/smarthome.js',  ['position' => yii\web\View::POS_HEAD]);
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
            <table class="table table-striped">
                <div style="position:relative;">
                    <img src="images\foorplan\blueprint.jpg" alt="" border="0">
<?php
foreach ($devices as $device):
 $img = $device->map_icon;
 if ($img == '') continue;
 if ((!file_exists(Yii::getAlias('@webroot')."/images/foorplan/devices/".$img."-off.png")) ||
     (!file_exists(Yii::getAlias('@webroot')."/images/foorplan/devices/".$img."-on.png"))) continue;
 $x = 0;
 $y = 0;
 $mapstr = $device->map_pos;
 if ($mapstr != '') {
  $pos = stripos($mapstr, ':');
  if ($pos != FALSE) {
   $x = substr($mapstr, 0, $pos);
   $y = substr($mapstr, $pos + 1);
  }
 }
?>
    <div style="position:absolute;left:<?= $x ?>px;top:<?= $y ?>px;">
        <img id="device_<?= $device->id ?>"
             title="<?= $device->description ?>"
             src="images/foorplan/devices/<?= $img ?>-off.png"
             border="0"
             data-imgon="images/foorplan/devices/<?= $img ?>-on.png"
             data-imgoff="images/foorplan/devices/<?= $img ?>-off.png"
             data-device="<?= $device->name ?>"
             data-options="<?= $device->options ?>"
             style="cursor:default;">
        <img id="reload_img_<?= $device->id ?>"
             src="images\foorplan\reload.png" width="16" height="16"
             style="position:inherit;left:16px;top:16px;">
    </div>
<?php endforeach;
foreach ($sensors as $sensor):
 $x = 0; $y = 0;
 $mapstr = $sensor->map_pos;
 if ($mapstr != '') {
  $pos = stripos($mapstr, ':');
  if ($pos != FALSE) {
   $x = substr($mapstr, 0, $pos);
   $y = substr($mapstr, $pos + 1);
  }
 }
?>
    <div style="position:absolute;left:<?= $x ?>px;top:<?= $y ?>px;">
        <a href="?r=sensors/info&id=<?= $sensor->id ?>" title="<?= $sensor->description ?>">
<?php echo $sensor->getIcon(24, 'sensor'.$sensor->id); ?>
            <font size="3" color="black"><strong><?= $sensor->value ?><?= $sensor->units ?></strong></font>
        </a>
    </div>
<?php endforeach; ?>
</div>

<script>
function device_click_on(id){
 var device = document.getElementById('device_' + id);
 if (device == null) return;
 var device_name = device.getAttribute('data-device');
 if (device_name == null) return;
 var XMLHttp = GetXMLHttp();
 XMLHttp.open('GET', '?r=ajax/event&cmd=on&device=' + encodeURIComponent(device_name), false);
 XMLHttp.send(null);
 device.src = device.getAttribute('data-imgon');
 device.style.cursor = "default";
 var reload = document.getElementById('reload_img_' + id);
 if (reload) reload.src ='images/foorplan/reload.png';
 skipcount = 1;
 device.setAttribute('onclick', '');
} // device_click_on

function device_click_off(id){
 var device = document.getElementById('device_' + id);
 if (device == null) return;
 var device_name = device.getAttribute('data-device');
 if (device_name == null) return;
 var XMLHttp = GetXMLHttp();
 XMLHttp.open('GET', '?r=ajax/event&cmd=off&device=' + encodeURIComponent(device_name), false);
 XMLHttp.send(null);
 device.src = device.getAttribute('data-imgoff');
 device.style.cursor = "default";
 var reload = document.getElementById('reload_img_' + id);
 if (reload) reload.src ='images/foorplan/reload.png';
 skipcount = 1;
 device.setAttribute('onclick', '');
} // device_click_off

function device_set_state_on(id){
 var device = document.getElementById('device_' + id);
 if (device == null) return;
 var options = device.getAttribute('data-options');
 if (options & 0x0002) {
  device.setAttribute('onclick', 'device_click_off(' + id + ');');
  device.style.cursor = "pointer";
 }
 else device.setAttribute('onclick', '');
 device.src = device.getAttribute('data-imgon');
 var reload = document.getElementById('reload_img_' + id);
 if (reload) reload.src ='images/~.gif';
} // device_set_state_on

function device_set_state_off(id){
 var device = document.getElementById('device_' + id);
 if (device == null) return;
 var options = device.getAttribute('data-options');
 if (options & 0x0004) {
  device.setAttribute('onclick', 'device_click_on(' + id + ');');
  device.style.cursor = "pointer";
 }
 else device.setAttribute('onclick', '');
 device.src = device.getAttribute('data-imgoff');
 var reload = document.getElementById('reload_img_' + id);
 if (reload) reload.src ='images/~.gif';
} // device_set_state_off

function loadstates(){
 if (skipcount > 0) {
  skipcount = skipcount - 1;
  setTimeout(loadstates, 2000);
  return;
 }
 var XMLHttp = GetXMLHttp();
 XMLHttp.open('GET', '?r=ajax/device', false);
 XMLHttp.send(null);
 if (XMLHttp.status == 200) {
  var XML = XMLHttp.responseXML;
  var items = XML.getElementsByTagName('Devices');
  if (items) {
   for (var i = 0; i < items.length; i++) {
    var item = items.item(i);
    var id = item.getElementsByTagName('id').item(0).innerHTML;
    var device = document.getElementById('device_' + id);
    if (device != null) {
     if (item.getElementsByTagName('state').item(0).innerHTML > 0)
      device_set_state_on(id);
     else
      device_set_state_off(id);
    }
   }
  }
 }
 setTimeout(loadstates, 2000);
} // load_data

var skipcount = 0;
window.onload = loadstates;
</script>
