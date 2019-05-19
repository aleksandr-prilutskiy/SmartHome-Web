<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\Config;
$this->title = $title;
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
$this->registerJsFile('js/smarthome.js',  ['position' => yii\web\View::POS_HEAD]);
echo $this->render('..\..\layouts\_boxstart', [
    'title' => $header,
    'icon' => 'fas fa-tv-retro']);
?>
<div class="row">
<?php if (count($files) == 0) { ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Ничего не найдено
    </div>
<?php } else { ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-striped" style="margin-bottom:0">
            <thead>
                <tr>
                    <th class="text-center"></th>
                    <th></th>
                    <th class="col-lg-4 col-md-4 col-sm-4 col-xs-4">Сериал</th>
                    <th class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Сезон</th>
                    <th>№</th>
                    <th class="col-lg-5 col-md-5 col-sm-5 col-xs-5">Название эпизода</th>
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
                    <td id="checkmark_<?= $episode->dlna_id ?>">
                        <img src="images\<?= $checkmark ?>" width="24" height="24">
                    </td>
                    <td>
                        <a href="?r=series/info&id=<?= $file->tmdb_id ?>"><?= $file->series_name ?></a>
                    </td>
                    <td width="10%">
                        <a href="?r=series/season&series=<?= $file->tmdb_id ?>&id=<?= $file->season ?>"><?= $file->season_name ?></a>
                    </td>
                    <td class="text-right"><?php if ($file->episode_index > 0) { echo $file->episode_index; } ?></td>
                    <td width="60%"><?= $file->episode_name ?></td>
                </tr>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php } ?>
</div>
<div class="row text-center">
<?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>

<script>
window.onload = playon_buttons_setstate;
</script>

