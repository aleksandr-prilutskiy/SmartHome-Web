<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Список устройств';
$this->registerJsFile('js/smarthome.js',  ['position' => yii\web\View::POS_HEAD]);
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'tableOptions' => ['class' => 'table table-condensed'],
    'emptyText' => 'Список устройств пуст',
    'rowOptions' => function ($model, $key, $index, $grid) {
        return [
            'style' => 'cursor: pointer;',
            'onclick' => 'location.href="?r=devices/info&id='.$model->id.'"'
        ];
     },
    'columns' => [
        ['format' => 'raw',
         'value' => function($model){
            return '<img src="images/~.gif" width="24" height="24" alt="" id="img'.$model->id.'">';
         },
        ],                    
        ['format' => 'raw',
         'value' => function($model){ return $model->getIcon(16); },
        ],                    
        ['attribute'=>'name',
         'label'=>'Имя устройства',
         'format'=>'text',
        ],
        ['attribute'=>'description',
         'label'=>'Описание устройства',
         'headerOptions' => ['width' => '100%', 'class' => 'hidden-sm hidden-xs'],
         'contentOptions' => ['class' => 'hidden-sm hidden-xs'],
         'format'=>'text',
        ],
    ],
]); ?>
        </div>
    </div>
</div>
<script>
function refreshimages(){
 var XMLHttp = GetXMLHttp();
 XMLHttp.open("GET", "?r=ajax/device", false);
 XMLHttp.send(null);
 if (XMLHttp.status == 200) {
  var XML = XMLHttp.responseXML;
  var items = XML.getElementsByTagName("Devices");
  if (items) {
   for (var i = 0; i < items.length; i++) {
    var item = items.item(i);
    var img = document.getElementById('img'+item.getElementsByTagName("id").item(0).innerHTML);
    if (img != null) {
     if (item.getElementsByTagName("state").item(0).innerHTML > 0)
      img.setAttribute('src', 'images/on.png');
     else
      img.setAttribute('src', 'images/off.png');
    }
   }
  }
 }
 setTimeout(refreshimages, 5000);
}

window.onload = refreshimages;
</script>
