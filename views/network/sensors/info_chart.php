<?php
use yii\helpers\Html;
$this->title = $title;
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
            <div id="sensor_chart" class="center" style="height:300px"></div>
        </div>
    </div>
</div>

<script src="js/jquery.flot.js"></script>
<script>
var timemarks = [
<?php
$i = 0;
foreach ($data as $item)
    if ($i++ % 5 == 0) {
        $timestamp = new DateTime($item->updated);
        echo '['.(count($data) - $i++).',"'.$timestamp->format('H:i').'"],';
    }
?>
];
var chart_data = [
<?php
$i = 1;
foreach ($data as $item)
    echo '['.(count($data) - $i++).','.$item->value.'],';
?>
];
var plot = $.plot($("#sensor_chart"),
 [{data:chart_data, label:""}],
 {series:{lines:{show:true},points:{show:true}},
  grid:{hoverable:true,clickable:true,backgroundColor:{colors:["#fff","#eee"]}},
  xaxis:{ticks:timemarks},
  yaxis:{min:<?= $min ?>, max:<?= $max ?>},
  colors: ["#3C67A5"],
 }
);
</script>
