<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Список датчиков';
$this->registerJsFile('js/smarthome.js',  ['position' => yii\web\View::POS_HEAD]);
?>
<div class="box col-lg-offset-2 col-lg-8 col-md-offset-1 col-md-10 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'showHeader'=> false,
    'tableOptions' => ['class' => 'table table-condensed'],
    'emptyText' => 'Список датчиков пуст',
    'rowOptions' => function ($model, $key, $index, $grid) {
        return [
            'style' => 'cursor: pointer;',
            'onclick' => 'location.href="?r=sensors/info&topic='.$model->topic.'"'
        ];
     },
    'columns' => [
        ['format' => 'raw',
         'value' => function($model){ return $model->getIcon(16); },
        ],                    
        ['attribute'=>'description',
         'contentOptions' => ['width' => '100%'],
         'enableSorting' => false,
         'format'=>'text',
        ],
        ['format' => 'raw',
         'enableSorting' => false,
         'value' => function($model){
            return '<div id="value'.$model->id.'"></div>';
         },
        ],                    
    ],
]); ?>
        </div>
    </div>
</div>
<script>
function setvalues(){
 var XMLHttp = GetXMLHttp();
 XMLHttp.open("GET", "?r=ajax/sensor", false);
 XMLHttp.send(null);
 var nowdatatime = new Date().getTime();
 if (XMLHttp.status == 200) {
  var XML = XMLHttp.responseXML;
  var items = XML.getElementsByTagName("Sensors");
  if (items) {
   for (var i = 0; i < items.length; i++) {
    var item = items.item(i);
    var itemdatatime = new Date(item.getElementsByTagName("updated").item(0).innerHTML).getTime();
    if (Math.abs(nowdatatime - itemdatatime) < 3000000) {
     var field = document.getElementById('value' + item.getElementsByTagName("id").item(0).innerHTML);
     if (field != null)
      field.innerHTML = item.getElementsByTagName("value").item(0).innerHTML + '&nbsp;' +
       item.getElementsByTagName("units").item(0).innerHTML;
    }
   }
  }
 }
 setTimeout(setvalues, 5000);
}
window.onload = setvalues;
</script>
