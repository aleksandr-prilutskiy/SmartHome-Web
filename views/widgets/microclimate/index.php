<?php
use app\models\Sensors;
$temperature = Sensors::find()
    ->where('(options & 0x0001) != 0')
    ->andWhere('updated > DATE_SUB(CURDATE(),INTERVAL 1 HOUR)')
    ->average('value');
$humidity = Sensors::find()
    ->where('(options & 0x0002) != 0')
    ->andWhere('updated > DATE_SUB(CURDATE(),INTERVAL 1 HOUR)')
    ->average('value');
if (($temperature <> '') || ($humidity <> '')) { ?>
<div class="col-lg-3 col-md-3 col-sm-4 hidden-xs">
    <a title="Контроль климата" class="top-block" href="?r=sensors/climateinside/">
        <img class="media-object center" src="<?= $image ?>">
        <h4>Климат</h4>
        <div class="text-muted"><?= round($temperature, 1) ?> °C</div>
        <div class="text-muted">влажн. <?= round($humidity, 1) ?> %</div>
    </a>
</div>
<div class="hidden-lg hidden-md hidden-sm col-xs-6">
    <a title="<?= $description ?>" href="<?= $link ?>">
        <button class="btn btn-default btn-sm col-xs-10 col-xs-offset-1" style="margin-bottom: 5px;"><?= $title ?></button>
    </a>
</div>
<?php } ?>
