<?php
use yii\helpers\Html;
$this->title = $album->artistname.' - '.$album->albumname;
$this->params['breadcrumbs'][] = [
    'label' => 'Мультимедиа',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => 'Музыка',
    'url' => '?r=music/index/',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => $album->artistname,
    'url' => '?r=music/artist&id='.$album->artist,
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/',
];
$this->params['breadcrumbs'][] = [
    'label' => $album->albumname,
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->registerJsFile('js/smarthome.js',  ['position' => yii\web\View::POS_HEAD]);
$this_device = null;
foreach ($devices as $device) { if ($device->addr == $_SERVER["REMOTE_ADDR"]) { $this_device = $device; }}
$img = '<img src="images\no_image_300.jpg" class="img-thumbnail" width="300" height="300">';
if (file_exists(Yii::getAlias('@webroot')."/images/music/album_".$album->hash.".jpg"))
    $img = '<img src="images\music\album_'.$album->hash.'.jpg" class="img-thumbnail" width="300" height="300">';
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Содержание альбома',
    'icon' => 'fas fa-music']);
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1><?= $this->title ?></i></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-4 hidden-sm hidden-xs">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><?= $img ?></div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
<?php if ( $album->year <> 0) { ?>
                <h4><i class="far fa-calendar-alt"></i>&nbsp;<?= $album->year ?> год</h4>
<?php } ?>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
        <table class="table table-striped" style="margin-bottom:0">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>№</th>
                    <th class="col-sm-12">Название</th>
                    <th class="hidden-xs hidden-sm hidden-md">Время</th>
                </tr>
            </thead>
            <tbody>
<?php foreach ($tracks as $track):
$favorite = "far fa-heart";
if ($track->favorite) $favorite = "fas fa-heart";
?>
                <tr>
                    <td>
<?php if ($is_local_ip) {
    echo $this->render('..\..\layouts\_playbutton', [
        'title' => 'Прослушать',
        'id' => $track->dlna_id,
        'dlna_url' => $dlna_url.$track->dlna_id.'.asx?fileext=.asx',
        'devices' => $devices,
        'this_device' => $this_device]);
} ?>
                    </td>
                    <td id="favorite_<?= $track->dlna_id ?>" onclick="switch_my_favorite('<?= $track->dlna_id ?>');"><i class="<?= $favorite ?>"></i></td>
                    <td class="text-right"><?= $track->track ?></td>
                    <td><?= $track->name ?></td>
                    <td class="hidden-xs hidden-sm hidden-md text-center">
                        <?= intval($track->duration/60) ?>:<?= str_pad($track->duration % 60, 2, '0', STR_PAD_LEFT) ?>
                    </td>
                </tr>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>

<script>
window.onload = playon_buttons_setstate;
</script>
