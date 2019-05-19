<?php
use yii\helpers\Html;
$this->title = 'Производительность системы';
$this->params['breadcrumbs'][] = [
    'label' => 'Сервер',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => 'Системные ресурсы',
    'url' => '?r=sysinfo/index',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => Html::encode($this->title),
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Загрузка процессора (%)',
    'icon' => 'fas fa-chart-bar']);
?>
<div id="processor_load" class="center" style="height:300px"></div>
<?php echo $this->render('..\..\layouts\_boxend');
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Свободно оперативной памяти (Гигабайт)',
    'icon' => 'fas fa-chart-bar']); ?>
<div id="memory_load" class="center" style="height:300px"></div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>
<script src="js/jquery.flot.js"></script>
<script>
    var timemarks = [];
<?php
    echo 'timemarks.push([0,"сейчас"]);';
    for ($i = 2; $i < 32; $i = $i + 2) {
        $time = localtime(time() + 3 * 3600 - $i * 3600);
        echo 'timemarks.push(['.$i.',"'.$time[2].':'.(($time[1] < 10) ? '0'.$time[1] : $time[1]).'"]);';
    }
?>    
if ($("#processor_load").length) {
    var cpu_load = [];
<?php
    $i = 0;
    foreach ($processor as $item) {
        echo 'cpu_load.push(['.$i.','.$item.']);';
        $i = $i + 1;
    }
?>    
    var plot = $.plot($("#processor_load"),
        [{ data: cpu_load, label: ""}, ],
         { series: {  lines: { show: true  },
                      points: { show: true }},
           grid: { hoverable: true, clickable: true, backgroundColor: { colors: ["#fff", "#eee"] } },
           xaxis: { ticks: [[0, "сейчас"], [10, "10 мин"], [20, "20 мин"], [30, "30 мин"], [40, "40 мин"], [50, "50 мин"], [60, "60 мин"]] },
           yaxis: { min: 0, max: 100 },
           colors: ["#3C67A5"]
        });
}
</script>

<script>
if ($("#memory_load").length) {
    var ram_load = [];
<?php
$i = 0;
foreach ($memory as $item) {
    echo 'ram_load.push(['.$i.','.($item).']);';
    $i = $i + 1;
}
?>    
    var plot = $.plot($("#memory_load"),
        [{ data: ram_load, label: ""}, ],
         { series: {  lines: { show: true  },
                      points: { show: true }},
           grid: { hoverable: true, clickable: true, backgroundColor: { colors: ["#fff", "#eee"] } },
           xaxis: { ticks: [[0, "сейчас"], [10, "10 мин"], [20, "20 мин"], [30, "30 мин"], [40, "40 мин"], [50, "50 мин"], [60, "60 мин"]] },
           yaxis: { min: 0, max: <?= $totalRAM ?> },
           colors: ["#3C67A5"]
        });
}
</script>
