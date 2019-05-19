<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = $title;
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
    'label' => Html::encode($this->title),
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->registerJsFile('js/smarthome.js',  ['position' => yii\web\View::POS_HEAD]);
echo $this->render('..\..\layouts\_boxstart', [
    'title' => Html::encode($this->title),
    'icon' => 'fas fa-music']);
if (count($tracks) == 0 ) { ?>
Ни одного музыкального файла не найдено.
<?php } else { ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-striped" style="margin-bottom:0">
            <thead>
                <tr>
                    <th></th>
                    <th class="hidden-xs"></th>
                    <th class="hidden-sm hidden-xs">№</th>
                    <th class="col-lg-6 col-md-6 col-sm-8 col-xs-8">Название</th>
                    <th class="col-lg-3 col-md-3 col-sm-4 col-xs-4">Исполнитель</th>
                    <th class="col-lg-3 col-md-3 hidden-sm hidden-xs">Альбом</th>
                    <th class="hidden-md hidden-sm hidden-xs">Время</th>
                </tr>
            </thead>
            <tbody>
<?php foreach ($tracks as $track):
$favorite = "far fa-heart";
if ($track->favorite) $favorite = "fas fa-heart"; ?>
                <tr>
                    <td>
<?php if ($is_local_ip) {
    echo $this->render('..\..\layouts\_playbutton', [
        'title' => 'Прослушать',
        'id' => $track->dlna_id,
        'dlna_url' => $dlna_url.$track->dlna_id.'.asx?fileext=.asx',
        'devices' => $devices]); } ?>
                    </td>
                    <td class="hidden-xs" id="favorite_<?= $track->dlna_id ?>" onclick="switch_my_favorite('<?= $track->dlna_id ?>');">
                        <i class="<?= $favorite ?>"></i>
                    </td>
                    <td class="text-right hidden-sm hidden-xs"><?= $track->track ?></td>
                    <td><?= $track->name ?></td>
                    <td><a href="?r=music/artist&id=<?= $track->artist ?>"><?= $track->artistname ?></a></td>
                    <td class="hidden-sm hidden-xs"><a href="?r=music/album&id=<?= $track->album ?>"><?= $track->albumname ?></a></td>
                    <td class="hidden-md hidden-sm hidden-xs text-center">
                        <?= intval($track->duration/60) ?>:<?= str_pad($track->duration % 60, 2, '0', STR_PAD_LEFT) ?>
                    </td>
                </tr>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row text-center">
<?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>
<?php } echo $this->render('..\..\layouts\_boxend'); ?>

<script>
window.onload = playon_buttons_setstate;
</script>
