<?php
use yii\helpers\Html;
$this->registerCssFile('css/bootstrap-toggle.min.css');
$this->registerJsFile('js/smarthome.js', ['position' => yii\web\View::POS_HEAD]);
$this->registerJsFile('js/bootstrap-toggle.min.js', ['position' => yii\web\View::POS_END]);
$this->title = 'Телевизоры';
foreach ($devices as $device): ?>
            <div class="box col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box-inner">
                    <div class="box-header well" data-original-title="">
                        <h2><?= $device->name ?></h2>
                    </div>
                    <div class="box-content" style="height:220px;">
                        <a title="description" class="top-block" href="index.php?r=tv/info&id=<?= $device->id ?>">
                            <img id="tv_<?= $device->id ?>" class="media-object center"
                                 src="images\pictures\tv_off-128.png" border="0"
                                 data-imgon="images\pictures\tv_on-128.png"
                                 data-imgoff="images\pictures\tv_off-128.png">
                            <?= $device->description ?>
                        </a>
                    </div>
                </div>
            </div>
<?php endforeach; ?>

<script>
function load_data(){
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
    var obj = document.getElementById('tv_' + id);
    if (obj != null) {
     if (item.getElementsByTagName('state').item(0).innerHTML > 0)
        obj.src = obj.getAttribute('data-imgon');
     else
        obj.src = obj.getAttribute('data-imgoff');
    }
   }
  }
 }
 setTimeout(load_data, 5000);
}

window.onload = load_data;
</script>
