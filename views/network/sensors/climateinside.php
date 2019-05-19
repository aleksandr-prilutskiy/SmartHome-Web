<?php
use yii\helpers\Html;
$this->title = 'Климат в помещении';
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2>Средняя температура в помещении</h2>
        </div>
        <div class="box-content">
            <div id="temperature_chart" class="center" style="height:300px"></div>
        </div>
    </div>
</div>

<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2>Средняя влажность в помещении</h2>
        </div>
        <div class="box-content">
            <div id="humidity_chart" class="center" style="height:300px"></div>
        </div>
    </div>
</div>

<script src="js/jquery.flot.js"></script>
<script>
var timemarks = [
<?php
$i = 0;
foreach ($temperature as $item)
    if ($i++ % 5 == 0) {
        $timestamp = new DateTime($item->updated);
        echo '['.(count($temperature) - $i++).',"'.$timestamp->format('H:i').'"],';
    }
?>
];
var chart_data = [
<?php
$i = 1;
foreach ($temperature as $item)
    echo '['.(count($temperature) - $i++).','.$item->value.'],';
?>
];
var plot = $.plot($("#temperature_chart"),
 [{data:chart_data, label:""}],
 {series:{lines:{show:true},points:{show:true}},
  grid:{hoverable:true,clickable:true,backgroundColor:{colors:["#fff","#eee"]}},
  xaxis:{ticks:timemarks},
  yaxis:{min:0, max:40},
  colors: ["#3C67A5"],
 }
);

var timemarks = [
<?php
$i = 0;
foreach ($humidity as $item)
    if ($i++ % 5 == 0) {
        $timestamp = new DateTime($item->updated);
        echo '['.(count($humidity) - $i++).',"'.$timestamp->format('H:i').'"],';
    }
?>
];
var chart_data = [
<?php
$i = 1;
foreach ($humidity as $item)
    echo '['.(count($humidity) - $i++).','.$item->value.'],';
?>
];
var plot = $.plot($("#humidity_chart"),
 [{data:chart_data, label:""}],
 {series:{lines:{show:true},points:{show:true}},
  grid:{hoverable:true,clickable:true,backgroundColor:{colors:["#fff","#eee"]}},
  xaxis:{ticks:timemarks},
  yaxis:{min:0, max:40},
  colors: ["#3C67A5"],
 }
);
</script>
