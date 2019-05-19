<?php
use yii\helpers\Html;
use app\models\Movies_info;
use app\models\Series_files;
use app\models\Config;
$this->title = $series->name_rus;
$this->params['breadcrumbs'][] = [
    'label' => 'Мультимедиа',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => 'Сериалы',
    'url' => '?r=series/index/',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$poster = '<img src="images\no_image_255.jpg" class="img-thumbnail" width="360" height="510">';
if (file_exists(Yii::getAlias('@webroot')."/images/series/".$series->tmdb_id.".jpg"))
 $poster = '<img src="images\series\\'.$series->tmdb_id.'.jpg" class="img-thumbnail" width="260" height="510">';
$this->registerJsFile('js/smarthome.js',  ['position' => yii\web\View::POS_HEAD]);
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Информация о сериале',
    'icon' => 'fas fa-tv-retro']);
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1><?= $series->name_rus ?> <i>(<?= $series->name ?>) <?= $idx ?></i></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><?= $poster ?></div>
        </div>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
<?php echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Список сезонов',
    'icon' => 'fas fa-tasks']); ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-justify">
                <table class="table table-striped" style="margin-bottom:0">
                    <thead>
                        <tr>
                            <th class="col-lg-10 col-md-8 col-sm-6 col-xs-4">Название</th>
                            <th class="col-lg-1 col-md-2 col-sm-3 col-xs-4 text-center">Эпизодов</th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach ($seasons as $season):?>
                        <tr>
                            <td>
<?php if ($season->total_episodes > 0) { ?>
                                <a href="index.php?r=series/season&series=<?= $series->tmdb_id ?>&id=<?= $season->id ?>">
<?php } ?>
                                    <?= $season->season_name ?>
<?php if ($season->total_episodes > 0) { ?>
                                </a>
<?php } ?>
                            </td>
                            <td class="text-center"><?= $season->total_episodes ?></td>
                        </tr>
<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
<?php
echo $this->render('..\..\layouts\_boxend');
if (count($files) > 0) {
    echo $this->render('..\..\layouts\_boxstart', [
        'title' => 'Дополнительные материалы',
        'icon' => 'fas fa-file-video']); ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-justify">
                <table class="table table-striped" style="margin-bottom:0">
                    <tbody>
<?php foreach ($files as $file):
    $checkmark = '~.gif';
    if ($file->browsed <> null) $checkmark = 'checkmark-24.png';
?>
                        <tr>
                            <td class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
<?php if (Config::is_local_ip()) {
    echo $this->render('..\..\layouts\_playbutton', [
        'title' => 'Просмотреть',
        'id' => $file->dlna_id,
        'dlna_url' => Config::dlna_url().$file->dlna_id.'.xspf?fileext=.xspf',
        'devices' => $devices]);
} ?>
                            </td>
                            <td id="checkmark_<?= $file->dlna_id ?>"><img src="images\<?= $checkmark ?>" width="24" height="24"></td>
                            <td class="col-lg-10 col-md-10 col-sm-8 col-xs-6"><?= $file->episode_name ?></td>
                        </tr>
<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
<?php
echo $this->render('..\..\layouts\_boxend'); }
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Описание',
    'icon' => 'fas fa-tags']); ?>
        <div class="row">
<?php if (strlen($series->year) > 0){ ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <p><strong>Премьера первого сезона:</strong> <?= $series->year ?> год</p>
            </div>
<?php } if (strlen($series->сompleted) > 0){ ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <p><strong>Статус:</strong> <?php if ($series->сompleted == "1"){ echo "Завершен"; } else { echo "Продолжается"; } ?></p>
            </div>
<?php } if (strlen($series->description) > 0){ ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-justify">
                <p><strong>Общая информация</strong></p>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-justify">
                <p><img src="images\~.gif" width="40" height="1"><?= Movies_info::fixUTF8($series->description) ?></p>
            </div>
<?php } ?>
        </div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>
    </div>
</div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>

<script>
window.onload = playon_buttons_setstate;
</script>
