<?php
use yii\helpers\Html;
$this->registerJsFile('js/smarthome.js', ['position' => yii\web\View::POS_HEAD]);
?>
<div class="site-login text-center">
    <h2>Перезагрузка сервера...</h2>
    <img src="images\ajax-loader.gif" width="66" height="66">
</div>

<script>
function server_reboot(){
 var XMLHttp = GetXMLHttp();
 XMLHttp.open("GET", "?r=ajax/event&app=server&cmd=reboot", false);
 XMLHttp.send(null);
 while (true) {
  ms = new Date().getTime() + 1000;
  while (new Date() < ms){ }
  XMLHttp.open("GET", "?r=ajax/device", false);
  XMLHttp.send(null);
  if (XMLHttp.status != 200) break;
 }
 while (true) {
  ms = new Date().getTime() + 1000;
  while (new Date() < ms){ }
  XMLHttp.open("GET", "?r=ajax/device", false);
  XMLHttp.send(null);
  if (XMLHttp.status == 200) break;
 }
 document.location.replace("?");
}

function set_timer(){
 setTimeout(server_reboot, 1000);
}

window.onload = set_timer;
</script>
