<?php
use yii\helpers\Html;
$this->title = 'Информация о жестком диске';
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
?>
<script src="js/jquery.flot.js"></script>
<?php
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Информация о жестком диске',
    'icon' => 'fas fa-hdd']);
?>
<div class="row" style="position:relative;">
    <div style="position:absolute;left:10px;top:0px;">
        <img src="images/pictures/hdd-48.png" border="0" width="48" height="48" alt="">
    </div>
    <div style="margin-left:66px;margin-right:100px;">
        <h4><?= $hdd->where("name = 'DiskDrive.Model'")->one()->value ?></h4>
    </div>
    <div class="row">
        <label class="col-md-2 col-sm-3 col-xs-4 control-label text-right">Объем</label>
        <div class="col-lg-10 col-md-9 col-sm-8 col-xs-7">
<?= number_format($hdd->where('name = \'DiskDrive.Size\'')->one()->value, 0, '', ' ') ?> гигабайт
        </div>
    </div>
    <div class="row">
        <label class="col-md-2 col-sm-3 col-xs-4 control-label text-right">Серийный номер</label>
        <div class="col-lg-10 col-md-9 col-sm-8 col-xs-7">
<?= $hdd->where('name = \'DiskDrive.SerialNumber\'')->one()->value ?>
        </div>
    </div>
    <div class="row">
        <label class="col-md-2 col-sm-3 col-xs-4 control-label text-right">Температура</label>
        <div class="col-lg-10 col-md-9 col-sm-8 col-xs-7">
<?= number_format($hdd->where('name = \'DiskDrive.Temperature\'')->one()->value, 0, '', ' ') ?>°С
        </div>
    </div>
</div>
<?php echo $this->render('..\..\layouts\_boxend');
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Измениение температуры жесткого диска',
    'icon' => 'fas fa-thermometer-half']); ?>
<div id="temperature_chart" class="center" style="height:300px"></div>
<?php echo $this->render('..\..\layouts\_boxend');
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Данные S.M.A.R.T.',
    'icon' => 'fas fa-shield-check']); ?>
<table class="table table-striped" style="margin-bottom:0">
    <thead>
        <tr>
            <th></th>
            <th class="col-lg-4 col-md-4 col-sm-4 col-xs-6" colspan="2">Атрибут</th>
            <th class="col-lg-1 col-md-1 col-sm-2 col-xs-2 text-center">Значение</th>
            <th class="col-lg-1 col-md-1 col-sm-2 col-xs-2 text-center">Худшее</th>
            <th class="col-lg-1 col-md-1 col-sm-2 col-xs-2 text-center">Пороговое</th>
            <th class="col-lg-5 col-md-5 col-sm-4 hidden-xs">Данные</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($smart as $item):
if ($item->error == 1) {$state_icon = '<span class="yellow"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>'; }
elseif ($item->error == 2) {$state_icon = '<span class="red"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>'; }
else { $state_icon = '<span class="green"><i class="fa fa-check-circle" aria-hidden="true"></i></span>'; } ?>
        <tr>
            <td><?= $state_icon ?></td>
            <td class="text-center"><?= $item->attr ?></td>
            <td>
<?php switch ($item->attr) {
    case 1:
        echo "Raw Read Error Rate";
        break;
    case 2:
        echo "Throughput Performance";
        break;
    case 3:
        echo "Spin Up Time";
        break;
    case 4:
        echo "Start/Stop Count";
        break;
    case 5:
        echo "Retired Block Count";
        break;
    case 6:
        echo"Read Channel Margin";
        break;
    case 7:
        echo"Seek Error Rate";
        break;
    case 8:
        echo"Seek Time Performance";
        break;
    case 9:
        echo"Power On Hours (POH)";
        break;
    case 10:
        echo"Spin-Up Retry Count";
        break;
    case 11:
        echo"Recalibration Retries";
        break;
    case 12:
        echo"Device Power Cycle Count";
        break;
    case 13:
        echo"Soft Read Error Rate";
        break;
    case 174:
        echo"Unexpected Power Loss Count";
        break;
    case 175:
        echo"Maximum Program Fail Count";
        break;
    case 176:
        echo"Maximum Erase Fail Count";
        break;
    case 177:
        echo"Endurance Used";
        break;
    case 178:
        echo"Used Reserved Block Count";
        break;
    case 179:
        echo"Used Reserved Block Count";
        break;
    case 180:
        echo"End to End Error Detection Rate";
        break;
    case 181:
        echo"Program Fail Count";
        break;
    case 182:
        echo"Erase Fail Count";
        break;
    case 183:
        echo"SATA Downshift Count";
        break;
    case 184:
        echo"End to End Error Detection Count";
        break;
    case 187:
        echo"Uncorrectable Error Count";
        break;
    case 188:
        echo"Command Timeout Count";
        break;
    case 189:
        echo"SSD Health Flags";
        break;
    case 190:
        echo"Airflow Temperature / SATA Error Counter";
        break;
    case 191:
        echo"G-Sense Error Rate";
        break;
    case 192:
        echo"Power-Off Retract Count";
        break;
    case 193:
        echo"Load/Unload Cycle";
        break;
    case 194:
        echo"HDD Temperature";
        break;
    case 195:
        echo"ECC Uncorrectable Error Rate";
        break;
    case 196:
        echo"Reallocation Event Count";
        break;
    case 197:
        echo"Current Pending Sector Count";
        break;
    case 198:
        echo"Uncorrectable Sector Count";
        break;
    case 199:
        echo"UltraDMA CRC Error Count";
        break;
    case 200:
        echo"Write Error Rate";
        break;
    case 201:
        echo"Uncorrectable Soft Read Error Rate (UECC)";
        break;
    case 202:
        echo"Data Address Mark Errors";
        break;
    case 203:
        echo"Run Out Cancel";
        break;
    case 204:
        echo"Soft ECC Correction Rate";
        break;
    case 205:
        echo"Thermal Asperity Rate";
        break;
    case 206:
        echo"Flying Height";
        break;
    case 207:
        echo"Spin High Current";
        break;
    case 208:
        echo"Spin Buzz";
        break;
    case 209:
        echo"Offline Seek Performance";
        break;
    case 220:
        echo"Disk Shift";
        break;
    case 221:
        echo"G-Sense Error Rate";
        break;
    case 222:
        echo"Loaded Hours";
        break;
    case 223:
        echo"Load/Unload Retry Count";
        break;
    case 224:
        echo"Load Friction";
        break;
    case 225:
        echo"Load/Unload Cycle Count";
        break;
    case 226:
        echo"Load-in Time";
        break;
    case 227:
        echo"Torque Amplification Count";
        break;
    case 228:
        echo"Power-Off Retract Countк";
        break;
    case 230:
        echo"GMR Head Amplitudeк";
        break;
    case 231:
        echo"SSD Life Left (%)";
        break;
    case 234:
        echo"Vendor Specific";
        break;
    case 240:
        echo"Head Flying Hours";
        break;
    case 241:
        echo"Lifetime Writes from Host";
        break;
    case 242:
        echo"Lifetime Reads from Host";
        break;
    case 245:
        echo"Vendor Specific";
        break;
    case 250:
        echo"NAND Read Retries";
        break;
    case 254:
        echo"Free Fall Protection";
        break;
    default:
        echo "Unknown";
} ?>
            </td>
            <td class="text-center"><?= $item->value ?></td>
            <td class="text-center"><?= $item->worst ?></td>
            <td class="text-center"><?= $item->threshold ?></td>
            <td class="hidden-xs"><?= $item->raw ?></td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>
<?php echo $this->render('..\..\layouts\_boxend'); ?>
<script>
    var timemarks = [];
<?php
    echo 'timemarks.push([0,"сейчас"]);';
    for ($i = 2; $i < 32; $i = $i + 2) {
        $time = localtime(time() + 3 * 3600 - $i * 3600);
        echo 'timemarks.push(['.$i.',"'.$time[2].':'.(($time[1] < 10) ? '0'.$time[1] : $time[1]).'"]);';
    }
?>    
if ($("#temperature_chart").length) {
    var chart_data = [];
<?php
$i = 0;
foreach ($temperature as $item) {
    echo 'chart_data.push(['.$i.','.$item.']);';
    $i = $i + 1;
}
?>    
    var plot = $.plot($("#temperature_chart"),
        [{ data: chart_data, label: ""}, ],
         { series: {  lines: { show: true  },
                      points: { show: true }},
           grid: { hoverable: true, clickable: true, backgroundColor: { colors: ["#fff", "#eee"] } },
           xaxis: { ticks: timemarks<?= $id ?> },
           yaxis: { min: 20, max: 80 },
           colors: ["#3C67A5"]
        });
}
</script>
