<?php
use yii\helpers\Html;
$this->title = 'Хранилище';
$this->params['breadcrumbs'][] = [
    'label' => 'Сервер',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => Html::encode($this->title),
    'url' => '?r=storage/index',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
foreach ($hdds->where("name = 'LogicalDisk.Name'")->all() as $hdd):
    echo $this->render('..\..\layouts\_boxstart', [
        'title' => 'Диск '.$hdds->where("name = 'LogicalDisk.Name' AND device = ".$hdd->device)->one()->value,
        'icon' => 'fas fa-hdd',
        'class' => 'col-lg-6 col-md-12 col-sm-12 col-xs-12']);
?>
<div class="row" style="position:relative;">
    <div style="position:absolute;left:10px;top:0px;">
        <img src="images\pictures\hdd-48.png" border="0" alt="">
    </div>
    <div class="media-body">
        <div class="row">
            <label class="col-lg-6 col-md-6 col-sm-6 col-xs-6 control-label text-right">Размер</label>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
<?= number_format($hdds->where("name = 'LogicalDisk.Size' AND device = " . $hdd->device)->one()->value, 0, '', ' ') ?> гигабайт
            </div>
        </div>
        <div class="row">
            <label class="col-lg-6 col-md-6 col-sm-6 col-xs-6 control-label text-right">Система</label>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
<?= $hdds->where("name = 'LogicalDisk.FileSystem' AND device = " . $hdd->device)->one()->value ?>
            </div>
        </div>
        <div class="row">
            <label class="col-lg-6 col-md-6 col-sm-6 col-xs-6 control-label text-right">Занято</label>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
<?= number_format($hdds->where("name = 'LogicalDisk.Size' AND device = " . $hdd->device)->one()->value -
    $hdds->where("name = 'LogicalDisk.FreeSpace' AND device = " . $hdd->device)->one()->value, 0, '', ' ') ?> гигабайт
            </div>
        </div>
        <div class="row">
            <label class="col-lg-6 col-md-6 col-sm-6 col-xs-6 control-label text-right">Свободно</label>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
<?= number_format($hdds->where("name = 'LogicalDisk.FreeSpace' AND device = " . $hdd->device)->one()->value, 0, '', ' ') ?> гигабайт
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="media-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="progress progress-striped">
                <div role="name" style="width: <?php
$hdsize = $hdds->where("name = 'LogicalDisk.Size' AND device = " . $hdd->device)->one()->value.ToInt;
$hdfree = $hdds->where("name = 'LogicalDisk.FreeSpace' AND device = " . $hdd->device)->one()->value.ToInt;
if ($hdsize > 0) {
    echo (100 - 100 * $hdfree / $hdsize) . '%;"';
    if ($hdfree / $hdsize < 0.075) {
        echo ' class="progress-bar progress-bar-danger"';
    }
    elseif ($hdfree / $hdsize < 0.15) {
        echo ' class="progress-bar progress-bar-warning"';
    }
    else {
        echo ' class="progress-bar progress-bar-success"';
    }
}
else {
    echo '0%;" class="progress-bar"';
}
?>">
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo $this->render('..\..\layouts\_boxend');
endforeach;
?>
