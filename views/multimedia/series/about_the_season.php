<?php
use yii\helpers\Html;
use app\models\Movies_info;
use app\models\Config;
$this->title = $season->season_name;
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
    'label' => Html::encode($series->name_rus),
    'url' => '?r=series/info&id='.$series->tmdb_id,
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$img = 'no_image_255';
if (file_exists(Yii::getAlias('@webroot')."/images/series/".$series->tmdb_id.".jpg"))
 $img = 'series\\'.$series->tmdb_id;
if (file_exists(Yii::getAlias('@webroot')."/images/series/".$series->tmdb_id."-".$season->season_index.".jpg"))
 $img = 'series\\'.$series->tmdb_id."-".$season->season_index;
$this->registerJsFile('js/smarthome.js',  ['position' => yii\web\View::POS_HEAD]);
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Информация о сезоне',
    'icon' => 'fas fa-tv-retro']);
?>
<div class="row" style="position:relative;">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1><?= $series->name_rus ?> <i>(<?= $series->name ?>)</i></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <img src="images\<?= $img ?>.jpg" class="img-thumbnail" width="260" height="510">
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
<?php echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Список эпизодов',
    'icon' => 'fas fa-tasks',
    'buttons' => Yii::$app->user->identity->username == 'admin' ?
        [['onclick' => 'unmark_all();', 'icon' => 'glyphicon-eye-close'],
         ['onclick' => 'mark_all();', 'icon' => 'glyphicon-eye-open']] : '']); ?>
        <h2><?= $season->season_name ?></h2>
        <table class="table table-striped" style="margin-bottom:0">
            <thead>
                <tr>
                    <th class="text-center">Эпизоды</th>
                    <th></th>
                    <th>№</th>
                    <th class="col-sm-12">Название</th>
                </tr>
            </thead>
            <tbody>
<?php foreach ($files as $file):
    $checkmark = '~.gif';
    if ($file->browsed <> null) $checkmark = 'checkmark-24.png'; ?>
                <tr>
                    <td>
<?php if (Config::is_local_ip()) {
    echo $this->render('..\..\layouts\_playbutton', [
        'title' => 'Просмотреть',
        'id' => $file->dlna_id,
        'dlna_url' => Config::dlna_url().$file->dlna_id.'.xspf?fileext=.xspf',
        'devices' => $devices]); } ?>
                    </td>
                    <td id="checkmark_<?= $file->dlna_id ?>"><img src="images\<?= $checkmark ?>" width="24" height="24"></td>
                    <td class="text-right"><?php if ($file->episode_index > 0) { echo $file->episode_index; } ?></td>
                    <td><?= $file->episode_name ?></td>
                </tr>
<?php endforeach; ?>
            </tbody>
        </table>
<?php
echo $this->render('..\..\layouts\_boxend');
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Описание',
    'icon' => 'fas fa-tags']); ?>
        <div class="row">
<?php if (strlen($season->year) > 0){ ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <p><strong>Премьера сезона:</strong> <?= $season->year ?> год</p>
            </div>
<?php } if (strlen($season->description) > 0){ ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-justify">
                <p><strong>Общая информация</strong></p>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-justify">
                <p><img src="images\~.gif" width="40" height="1"><?= Movies_info::fixUTF8($season->description) ?></p>
            </div>
<?php } ?>
        </div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>
    </div>
</div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>

<script>
function mark_all(){
<?php foreach ($files as $file): ?>
 mark_this_browsed('<?= $file->dlna_id ?>');
<?php endforeach; ?>
}

function unmark_all(){
<?php foreach ($files as $file): ?>
 unmark_this_browsed('<?= $file->dlna_id ?>');
<?php endforeach; ?>
}
</script>

<script>
window.onload = playon_buttons_setstate;
</script>
