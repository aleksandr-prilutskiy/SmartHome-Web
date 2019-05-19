<?php
use yii\helpers\Html;
$this->registerJsFile('js/xml.js', ['position' => yii\web\View::POS_HEAD]);
?>
<div class="site-login text-center">
    <h2 id="message">Выключение сервера...</h2>
    <img src="images\ajax-loader.gif" width="66" height="66" id="loader">
</div>

<script>
function server_shutdown(){
 var XMLHttp = GetXMLHttp();
 XMLHttp.open("GET", "?r=ajax/event&app=server&cmd=off", false);
 XMLHttp.send(null);
 while (true) {
  XMLHttp.open("GET", "?r=xml/device&id=1", false);
  XMLHttp.send(null);
  if (XMLHttp.status != 200) break;
 }
 document.getElementById('message').innerText='Сервер выключен.';
 document.getElementById('loader').remove();
}

function set_timer(){
 setTimeout(server_shutdown, 1000);
}

window.onload = set_timer;
</script>
