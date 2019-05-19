<?php
use yii\helpers\Html;
use app\models\Movies_info;
$this->title = $movie->name_rus;
$this->params['breadcrumbs'][] = [
    'label' => 'Мультимедиа',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => 'Фильмы',
    'url' => '?r=movies/index/',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => $movie->year.' год',
    'url' => '?r=movies/search&year='.$movie->year,
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => Html::encode($this->title),
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->registerJsFile('js/smarthome.js',  ['position' => yii\web\View::POS_HEAD]);
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Информация о фильме',
    'icon' => 'fas fa-film']); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1><?= Movies_info::fixUTF8($movie->name_rus) ?> <i>(<?= Movies_info::fixUTF8($movie->name) ?>)</i></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
<?php
 $dirandfilename = Yii::getAlias('@webroot')."/images/movies/".$movie->id;
 if (file_exists($dirandfilename.".jpg")) {
  $img_path = '<img src="images\movies\\'.$movie->id.'.jpg" class="img-thumbnail" width="260" height="510">'; }
 else { $img_path = '<img src="images\no_image_255.jpg" class="img-thumbnail" width="360" height="510">'; }
 echo $img_path;
?>
            </div>
        </div>
<?php if ($movie->year <> 0) { ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h4><span class="glyphicon glyphicon-calendar"></span> <?= $movie->year ?> год</h4>
            </div>
        </div>
<?php } ?>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
<?php
if (count($files) > 0) {
    echo $this->render('..\..\layouts\_boxstart', [
        'title' => 'Информация о '.(count($files) > 1 ? 'файлах' : 'файле'),
        'icon' => 'fas fa-file-video']);
?>
<table class="table table-hover">
    <tbody>
<?php foreach ($files as $file):
    $is3d = FALSE;
    $res_x = 0;
    $res_y = 0;
    $resolution = $file->resolution;
    if (substr($resolution, -4, 4) == '[3D]') {
        $resolution = substr($resolution, 0, -4);
        $is3d = TRUE;
    }
    $pos = strpos($resolution, 'x');
    if ($pos) {
        $res_x = (int)substr($resolution, 0, $pos);
        $res_y = (int)substr($resolution, $pos + 1);
    }
?>
        <tr>
            <td valign="top">
                <table>
                    <tr>
                        <td valign="top">
<?php
        if ($is_local_ip)
            echo $this->render('..\..\layouts\_playbutton', [
                'title' => 'Просмотреть',
                'id' => $file->dlna_id,
                'dlna_url' => $dlna_url.$file->dlna_id.'.xspf?fileext=.xspf',
                'devices' => $devices]);
?>
                        </td>
                    </tr>
                    <tr><td><img src="images\~.gif" width="1" height="1" border="0"></td></tr>
                    <tr>
                        <td align="center">
<?php if ($is3d) { ?>
                            <img src="images\pictures\movie_3d-48.png" width="55" height="48" border="0">
<?php } elseif (($res_x == 3840) || ($res_y == 2160)) { ?>
                            <img src="images\pictures\movie_4k-48.png" width="75" height="48" border="0">
<?php } elseif (($res_x == 1920) || ($res_y == 1080)) { ?>
                            <img src="images\pictures\movie_1080p-48.png" width="60" height="48" border="0">
<?php } elseif (($res_x == 1280) || ($res_y == 720)) { ?>
                            <img src="images\pictures\movie_720p-48.png" width="61" height="48" border="0">
<?php } if (round($file->fps) == 60) { ?>
                            <img src="images\pictures\movie_60fps-32.png" width="32" height="32" border="0">
<?php } ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="100%">
                <table>
                    <tr>
                        <td width="100" class="text-right"><strong>Имя файла:</strong>&nbsp;</td>
                        <td><?= $file->filename ?></td>
                    </tr>
                    <tr>
<?php if ($file->resolution != '') { ?>
                    <tr>
                        <td width="100" class="text-right"><strong>Изображение:</strong>&nbsp;</td>
                        <td>
<?php echo $resolution.' точек';
if ($file->fps != 0) echo ',&nbsp;'.$file->fps.' кадров в секунду';
if ($file->videocodec != '')  echo ' (кодек: '.$file->videocodec.')'; ?>
                        </td>
                    </tr>
<?php } if ($file->audiocodec != '') { ?>
                    <tr>
                        <td width="100" class="text-right"><strong>Звук:</strong>&nbsp;</td>
                        <td>
<?php if ($file->audiochannels == 6) echo '5.1-канальный';
elseif ($file->audiochannels == 2) echo 'стерео';
elseif ($file->audiochannels == 1) echo 'моно';
elseif ($file->audiochannels != 0) echo $file->audiochannels. ' каналов';
echo ' (кодек: '.$file->audiocodec.')';?>
                        </td>
                    </tr>
<?php } if ($file->duration > 0) { ?>
                    <tr>
                        <td width="100" class="text-right"><strong>Продолжительность:</strong>&nbsp;</td>
                        <td><?= intval($file->duration / 3600) ?> час. 
                            <?= intval(($file->duration % 3600) / 60) ?> мин.
                            <?= $file->duration % 60 ?> сек.</td>
                    </tr>
<?php } ?>
                    <tr>
                        <td class="text-right"><strong>Размер:</strong>&nbsp;</td>
                        <td><?= round($file->filesize / 1048576, 2) ?> мегабайт</td>
                    </tr>
                </table>
            </td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>
<?php echo $this->render('..\..\layouts\_boxend'); }
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Описание фильма',
    'icon' => 'fas fa-tags']);
$dlna_id = $movie->dlna_id;
$favorite = "far fa-heart";
if ($movie->favorite) $favorite = "fas fa-heart";
?>
        <div class="row">
            <label class="col-lg-3 col-md-4 col-sm-6 col-xs-12 control-label text-right">Жанр</label>
            <div class="col-lg-9 col-md-8 col-sm-6 col-xs-12"><?= $movie->genre ?></div>
        </div>
<?php if ($movie->director != '') { ?>
        <div class="row">
            <label class="col-lg-3 col-md-4 col-sm-6 col-xs-12 control-label text-right">Режисер</label>
            <div class="col-lg-9 col-md-8 col-sm-6 col-xs-12">
<?php $directors = explode(", ", $movie->director);
$counter = 0;
foreach ($directors as $director) {
 echo '<a href="?r=movies/search&director='.$director.'">'.Movies_info::fixUTF8($director).'</a>';
 $counter++;
 if($counter < count($directors)) echo ', ';
} ?>
            </div>
        </div>
<?php } if ($movie->actors != '') { ?>
        <div class="row">
            <label class="col-lg-3 col-md-4 col-sm-6 col-xs-12 control-label text-right">В ролях</label>
            <div class="col-lg-9 col-md-8 col-sm-6 col-xs-12">
<?php $actors = explode(", ", $movie->actors);
$counter = 0;
foreach ($actors as $actor) {
 echo '<a href="?r=movies/search&actor='.$actor.'">'.Movies_info::fixUTF8($actor).'</a>';
 $counter++;
 if($counter < count($actors)) echo ', ';
} ?>
            </div>
        </div>
<?php } ?>
        <div class="row">
            <div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <p><?= Movies_info::fixUTF8($movie->description) ?></p>
            </div>
        </div>
        <div class="row">
            <label class="col-lg-3 col-md-4 col-sm-6 col-xs-12 control-label text-right">Информация на сайте</label>
            <div class="col-lg-9 col-md-8 col-sm-6 col-xs-12">
                <a href="https://www.themoviedb.org/movie/<?= $movie->id ?>" target="_blank">https://www.themoviedb.org/movie/<?= $movie->id ?></a>
            </div>
        </div>
        <div style="position:absolute;left:40px;top:60px;" id="favorite_<?= $dlna_id ?>" onclick="switch_my_favorite('<?= $dlna_id ?>');">
            <i class="<?= $favorite ?> fa-2x"></i>
        </div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>
    </div>
</div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>

<script>
window.onload = playon_buttons_setstate;
</script>
