<?php
use yii\helpers\Html;
$this->title = 'Информация об устройстве';
$view = '';
$dir = Yii::getAlias('@app').'\views\network\devices\\';
$img = '<img src="images\no_image_255.jpg" class="img-thumbnail" width="360" height="510">';
if ($device->image <> '') {
    $path = Yii::getAlias('@webroot').'/images/devices/'.$device->image.'.jpg';
    if (file_exists($path)) $img = str_replace('no_image_255.jpg', '\devices\\'.$device->image.'.jpg', $img);
}
$this->registerCssFile('css/bootstrap-toggle.min.css');
$this->registerJsFile('js/smarthome.js', ['position' => yii\web\View::POS_HEAD]);
$this->registerJsFile('js/bootstrap-toggle.min.js', ['position' => yii\web\View::POS_END]);
echo $this->render('..\..\layouts\_boxstart', [
    'title' => Html::encode($this->title),
    'icon' => 'fas fa-'.$fa_icon,
    'buttons' => Yii::$app->user->identity->username == 'admin' ?
        [['url' => '?r=devices/update&id='.$device->id, 'icon' => 'glyphicon-cog']] : '']);
?>
<div class="row">
    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
        <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs text-center"><?= $img ?></div>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
<?php echo $this->render('..\..\layouts\_boxstart', [
        'title' => 'Общая информация',
        'icon' => 'fas fa-info']); ?>
        <div class="row">
            <label class="col-lg-3 col-md-4 col-sm-6 hidden-xs control-label text-right">Наименование устройства</label>
            <div class="col-lg-9 col-md-8 col-sm-6 col-xs-12"><?= $device->name ?></div>
        </div>
        <div class="row">
            <label class="col-lg-3 col-md-4 col-sm-6 hidden-xs control-label text-right">Описание устройства</label>
            <div class="col-lg-9 col-md-8 col-sm-6 col-xs-12"><?= $device->description ?></div>
        </div>
<?php if (($device->addr <> '') and (substr($device->addr, 0, 1) <> "@")) { ?>
        <div class="row">
            <label class="col-lg-3 col-md-4 col-sm-6 hidden-xs control-label text-right">Адрес устройства</label>
            <div class="col-lg-9 col-md-8 col-sm-6 col-xs-12"><?= $device->addr ?></div>
        </div>
<?php } if ($device->webpage <> '') {
    $links = explode(";", $device->webpage); ?>
        <div class="row">
            <label class="col-lg-3 col-md-4 col-sm-6 hidden-xs control-label text-right">Web-интерфейс</label>
            <div class="col-lg-9 col-md-8 col-sm-6 hidden-xs">
<?php foreach ($links as $link):
    $str = explode("=", $link);
    if (count($str) > 1) { $link_name = $str[0]; $link_url = $str[1];} 
    else { $link_name = 'ссылка'; $link_url = $str[0];} ?>
                <a href="<?= $link_url ?>" target="_blanc"><?= $link_name ?></a><br>
<?php endforeach; ?>
            </div>
        </div>
<?php } if ($device->manufacture <> '') { ?>
        <div class="row">
            <label class="col-lg-3 col-md-4 col-sm-6 hidden-xs control-label text-right">Сайт производителя</label>
            <div class="col-lg-9 col-md-8 col-sm-6 hidden-xs">
                <a href="<?= $device->manufacture ?>" target="_blanc">перейти</a>
            </div>
        </div>
<?php }
echo $this->render('..\..\layouts\_boxend');

if ($device->type == 'server') {
    if (Yii::$app->user->identity->username == 'admin') {
        echo $this->render('_server', ['device' => $device]);
    }
} else if ($device->type == 'tv') {
    echo $this->render('_tv', ['device' => $device]);
} else if ($device->option_can_on || $device->option_can_off) {
echo $this->render('..\..\layouts\_boxstart', [
        'title' => 'Управление устройством',
        'icon' => 'fas fa-info']);
echo $this->render('..\..\layouts\_on_off_switch', ['device' => $device]);
echo $this->render('..\..\layouts\_boxend'); }
echo $this->render('..\..\layouts\_boxend'); ?>
