<?php
use yii\helpers\Html;
$this->title = 'Системные ресурсы';
$this->params['breadcrumbs'][] = [
    'label' => 'Сервер',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => Html::encode($this->title),
    'url' => '?r=server/index',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Носители информации',
    'icon' => 'fas fa-database',
    'class' => 'col-lg-6 col-md-12 col-sm-12 col-xs-12']);
foreach ($hardware->where("name = 'DiskDrive.Model'")->all() as $hdd):
    $hdd_temperature = $hardware->where("name = 'DiskDrive.Temperature' AND device = " . $hdd->device)->one()->value;
?>
<div class="row" style="position:relative;">
    <div style="position:absolute;left:10px;top:0px;">
        <img src="images/pictures/hdd-48.png" border="0" width="48" height="48" alt="">
    </div>
    <div style="margin-left:66px;margin-right:100px;">
        <h4><?= $hdd->value ?></h4>
    </div>
<?php if ($hdd_temperature <> "") {  ?>
    <div style="position:absolute;right:10px;top:0px;">
        <a href="?r=sysinfo/hdd&id=<?= $hdd->device ?>">
            <span class="btn btn-info btn-xs" style="margin-right: 10px; margin-top: 10px">
                <i class="glyphicon glyphicon-zoom-in icon-white"></i> подробно
            </span>
        </a>
    </div>
<?php } ?>
</div>
<div class="row">
    <label class="col-md-5 col-sm-5 col-xs-5 control-label text-right">Объем</label>
    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
<?= number_format($hardware->where("name = 'DiskDrive.Size' AND device = " . $hdd->device)->one()->value, 0, '', ' ') ?> гигабайт
    </div>
</div>
<?php $logical = $hardware->where("name = 'DiskDrive.LogicalDisks' AND device = " . $hdd->device)->one()->value;
    if ($logical <> "") {  ?>
<div class="row">
    <label class="col-md-5 col-sm-5 col-xs-5 control-label text-right">Содержит диски</label>
    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7"><?= $logical ?></div>
</div>
<?php } if ($hdd_temperature <> "") {  ?>
<div class="row">
    <label class="col-md-5 col-sm-5 col-xs-5 control-label text-right">Температура</label>
    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
<?= number_format($hdd_temperature, 0, '', ' ') ?>°С
    </div>
</div>
<?php } endforeach;
echo $this->render('..\..\layouts\_boxend');
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Вычислительные ресурсы',
    'icon' => 'fas fa-microchip',
    'class' => 'col-lg-6 col-md-12 col-sm-12 col-xs-12',
    'buttons' => [['url' => '?r=sysinfo/monitor', 'icon' => 'glyphicon-signal']]]); ?>
<div class="row" style="position:relative;">
    <div style="position:absolute;left:15px;top:0px;">
        <img src="images/pictures/motherboard-48.png" border="0" width="48" height="48" alt="">
    </div>
    <label class="col-md-5 col-sm-5 col-xs-5 control-label text-right">Системная плата</label>
    <div class="col-md-7 col-sm-7 col-xs-7">
<?= $hardware->where("name = 'BaseBoard.Manufacturer'")->one()->value ?>
<?= $hardware->where("name = 'BaseBoard.Product'")->one()->value ?>
    </div>
</div>
<div class="row">
    <label class="col-md-5 col-sm-5 col-xs-5 control-label text-right">Процессор</label>
    <div class="col-md-7 col-sm-7 col-xs-7">
<?= $hardware->where("name = 'Processor.Name'")->one()->value ?>
    </div>
</div>
<div class="row">
    <label class="col-md-5 col-sm-5 col-xs-5 control-label text-right">Кол-во ядер</label>
    <div class="col-md-7 col-sm-7 col-xs-7">
<?= $hardware->where("name = 'Processor.NumberOfCores'")->one()->value ?>
    </div>
</div>
<div class="row">
    <label class="col-md-5 col-sm-5 col-xs-5 control-label text-right">Режим работы</label>
    <div class="col-md-7 col-sm-7 col-xs-7">
<?= $hardware->where("name = 'Processor.AddressWidth'")->one()->value ?> бит
    </div>
</div>
<div class="row">
    <label class="col-md-5 col-sm-5 col-xs-5 control-label text-right">Макс. частота</label>
    <div class="col-md-7 col-sm-7 col-xs-7">
<?= number_format($hardware->where("name = 'Processor.MaxClockSpeed'")->one()->value, 0, '', ' ') ?> мегагерц
    </div>
</div>
<div class="row">
    <label class="col-md-5 col-sm-5 col-xs-5 control-label text-right">Кэш 2-го уровня</label>
    <div class="col-md-7 col-sm-7 col-xs-7">
<?= $hardware->where("name = 'Processor.L2CacheSize'")->one()->value ?> килобайт
    </div>
</div>
<div class="row">
    <label class="col-md-5 col-sm-5 col-xs-5 control-label text-right">Кэш 3-го уровня</label>
    <div class="col-md-7 col-sm-7 col-xs-7">
<?= number_format($hardware->where("name = 'Processor.L3CacheSize'")->one()->value, 0, '', ' ') ?> килобайт
    </div>
</div>
<div class="row">
    <label class="col-md-5 col-sm-5 col-xs-5 control-label text-right">Всего оперативной памяти</label>
    <div class="col-md-7 col-sm-7 col-xs-7">
<?= $hardware->where("name = 'OperatingSystem.TotalVisibleMemorySize'")->one()->value ?> мегабайт
    </div>
</div>
<div class="row">
    <label class="col-md-5 col-sm-5 col-xs-5 control-label text-right">Всего виртуальной памяти</label>
    <div class="col-md-7 col-sm-7 col-xs-7">
<?= $hardware->where("name = 'OperatingSystem.TotalVirtualMemorySize'")->one()->value ?> мегабайт
    </div>
</div>
<?php
echo $this->render('..\..\layouts\_boxend');
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Сетевые подключения',
    'icon' => 'fas fa-plug',
    'class' => 'col-lg-6 col-md-12 col-sm-12 col-xs-12']);
foreach ($hardware->where("name = 'NetworkAdapter.Name'")->all() as $nic):
?>
<div class="row" style="position:relative;">
    <div style="position:absolute;left:15px;top:0px;">
        <img src="images/pictures/network-48.png" border="0" width="48" height="48" alt="">
    </div>
    <div style="margin-left:66px;">
        <h4><?= $nic->value ?></h4>
    </div>
</div>
<div class="row">
    <label class="col-md-5 col-sm-5 col-xs-5 control-label text-right">IP-адрес</label>
    <div class="col-md-7 col-sm-7 col-xs-7">
<?= str_replace('|', '<br>', $hardware->where("name = 'NetworkAdapter.IPAddress' AND device = " . $nic->device)->one()->value) ?>
    </div>
</div>
<div class="row">
    <label class="col-md-5 col-sm-5 col-xs-5 control-label text-right">MAC-адрес</label>
    <div class="col-md-7 col-sm-7 col-xs-7">
<?= $hardware->where("name = 'NetworkAdapter.MACAddress' AND device = " . $nic->device)->one()->value ?>
    </div>
</div>
<?php endforeach;
echo $this->render('..\..\layouts\_boxend');
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Операционная система',
    'icon' => 'fab fa-microsoft',
    'class' => 'col-lg-6 col-md-12 col-sm-12 col-xs-12']);
?>
<div class="row" style="position:relative;">
    <div class="hidden-xs" style="position:absolute;left:10px;top:0px;">
        <img src="images/pictures/operating_system-48.png" border="0" width="48" height="48" alt="">
    </div>
    <div style="margin-left:66px;">
        <h4><?= $hardware->where("name = 'OperatingSystem.Name'")->one()->value ?></h4>
    </div>
</div>
<div class="row">
    <label class="col-md-5 col-sm-5 col-xs-5 control-label text-right">Установка системы</label>
    <div class="col-md-7 col-sm-7 col-xs-7">
<?php
$install = $hardware->where("name = 'OperatingSystem.InstallDate'")->one()->value;
echo substr($install, 8, 2).":".substr($install, 10, 2)." ".substr($install, 6, 2).".".substr($install, 4, 2).".".substr($install, 0, 4);
?>
    </div>
</div>
<div class="row">
    <label class="col-md-5 col-sm-5 col-xs-5 control-label text-right">Загрузка системы</label>
    <div class="col-md-7 col-sm-7 col-xs-7">
<?php
$boot = $hardware->where("name = 'OperatingSystem.LastBootUpTime'")->one()->value;
echo substr($boot, 8, 2).":".substr($boot, 10, 2)." ".substr($boot, 6, 2).".".substr($boot, 4, 2).".".substr($boot, 0, 4);
?>
    </div>
</div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>
