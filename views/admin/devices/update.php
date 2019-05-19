<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Devices;
use app\models\Config;
$this->title = $title;
$type = array();
$type[0] = 'Прочее устройство';
$type[1] = 'Сервер';
$type[2] = 'Устройство nooLite';
$type[3] = 'Телевизор';
$type[4] = 'Камера видеонаблюдения';
$type[5] = 'Устройство Arduino';
$binfiles = array();
$binfiles[''] = 'Нет';
$bindirpath = Config::find()->where("name = 'CommandFilesDir'")->one()->data;
if (file_exists($bindirpath)) {
    $bindir = dir($bindirpath);
    if ($bindir) {
        while (false !== ($name = $bindir->read())) {
            if ($name === '.' || $name === '..') continue;
            if (filetype($bindirpath . '\\' . $name) == "file") {
                if (substr(mb_strtolower($name), -4, 4) == ".exe") {
                    $command = substr($name, 0, -4);
                    $binfiles[$command] = $command;
                }
            }
        }
        $bindir->close();
    }
}
$iconfiles = array();
$iconfiles[''] = 'Нет';
$imagesdirpath = Yii::getAlias('@webroot')."/images/foorplan/devices";
$imagesdir = dir($imagesdirpath);
if ($imagesdir) {
    while (false !== ($name = $imagesdir->read()))
        if (filetype($imagesdirpath.'\\'.$name) == "file")
            if ((substr(mb_strtolower($name), -7, 7) == "-on.png")  && 
                (file_exists($imagesdirpath.'\\'.substr($name, 0, -7)."-on.png"))) {
                $filename = substr($name, 0, -7);
                $iconfiles[$filename] = $filename;
            }
    $imagesdir->close();
}
$imagesfiles = array();
$imagesfiles[''] = 'Нет';
$imagesdirpath = Yii::getAlias('@webroot')."/images/devices";
$imagesdir = dir($imagesdirpath);
if ($imagesdir) {
    while (false !== ($name = $imagesdir->read()))
        if (filetype($imagesdirpath.'\\'.$name) == "file")
            if (substr(mb_strtolower($name), -4, 4) == ".jpg") {
                $filename = substr($name, 0, -4);
                $imagesfiles[$filename] = $filename;
            }
    $imagesdir->close();
}
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
<?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
<?= $form->field($model, 'name', [
    "template" => "<label>Имя устройства</label>\n{input}\n{hint}\n{error}"
    ])->input('text') ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-left:40px;">
<?= $form->field($model, 'type', [
    "template" => "<label>Тип устройства</label>\n{input}\n{hint}\n{error}",
    ])-> dropDownList($type, ["id" => "device_type"]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?= $form->field($model, 'description', [
    "template" => "<label>Описание устройства</label>\n{input}\n{hint}\n{error}"
    ])->input('text') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" id="div_driver">
<?= $form->field($model, 'driver', [
    "template" => "<label>Драйвер</label>\n{input}\n{hint}\n{error}"
    ])->dropDownList($binfiles) ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
<?= $form->field($model, 'addr', [
    "template" => "<label>Адрес устройства</label>\n{input}\n{hint}\n{error}"
    ])->input('text') ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" id="div_parameters">
<?= $form->field($model, 'parameters', [
    "template" => "<label id=\"label_parameters\"></label>\n{input}\n{hint}\n{error}"
    ])->input('text') ?>
                </div>
            </div>

    <div class="row" id="div_options">
        <div class="row row col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <fieldset>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:40px;">
                    <legend>Настройка опций:</legend>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="padding-left:40px;">
                    <?= $form->field($model, 'option_ping')
                        ->checkbox(['label' => 'Разрешена проверка устройства (команда PING или иным образом)']) ?>
                    <?= $form->field($model, 'option_can_off')
                        ->checkbox(['label' => 'Устройство может быть отключено дистанционно']) ?>
                    <?= $form->field($model, 'option_can_on')
                        ->checkbox(['label' => 'Устройство может быть включено дистанционно']) ?>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="padding-left:40px;">
                    <?= $form->field($model, 'option_play_music')
                        ->checkbox(['label' => 'Разрешено прослушивание музыки на устройстве']) ?>
                    <?= $form->field($model, 'option_play_video')
                        ->checkbox(['label' => 'Разрешен просмотр видео на устройстве']) ?>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row">
        <div class="row col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <fieldset>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:40px;">
                    <legend>Отображение на плане помещений:</legend>
                </div>
                <div class="col-lg-4 col-md-2 col-sm-12 col-xs-12">
                    <div style="position:absolute;left:25px;top:25px;">
                        <img id="icon_on" src="images\~.gif" width="32" height="32">
                    </div>
                    <div style="position:absolute;left:70px;top:25px;">
                        <img id="icon_off" src="images\~.gif" width="32" height="32">
                    </div>
                </div>
                <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'map_icon', [
                        "template" => "<label>Изображение</label>\n{input}\n{hint}\n{error}",
                        ])->dropDownList($iconfiles, ["id" => "map_icon"]) ?>
                </div>
                <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'map_pos', [
                        "template" => "<label>Координаты</label>\n{input}\n{hint}\n{error}",
                        ])->input('text') ?>
                </div>
            </fieldset>
        </div>
        <div class="row col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <fieldset>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:40px;">
                    <legend>Изображение устройства:</legend>
                </div>
                <div class="col-lg-offset-1 col-lg-8 col-md-offset-1 col-md-8 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'image', [
                        "template" => "<label>Файл с изображеним устройства</label>\n{input}\n{hint}\n{error}",
                        ])->dropDownList($imagesfiles) ?>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row" id="div_urls">
        <div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <?= $form->field($model, 'webpage', [
                    "template" => "<label>Web-страница устройства</label> <i>(или несколько, через ';', можно 'имя=url')</i>\n{input}\n{hint}\n{error}"
                    ])->input('text') ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <?= $form->field($model, 'manufacture', [
                    "template" => "<label>Описание устройства на сайте производителя</label>n<img src=\"images\~.gif\" width=\"27\" height=\"20\">{input}\n{hint}\n{error}"
                    ])->input('text') ?>
            </div>
        </div>
<!-- $model->manuals
    <div class="row row col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $form->field($model, 'manuals')->fileInput() ?>
            <button class="btn btn-default" formaction="index.php?r=devices/setup">
                <i class="fa fa-times" aria-hidden="true"></i>&nbsp;Загрузить
            </button>
        </div>
    </div>
 -->
    </div>
    <div class="form-group text-center">
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        <button class="btn btn-danger" formaction="index.php?r=admdevices/index">Отменнить</button>
    </div>    
    <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
function drawmapicon() {
 var map_icon = document.getElementById('map_icon').value;
 if (map_icon == '') {
  document.getElementById('icon_on').src = 'images/~.gif';
  document.getElementById('icon_off').src = 'images/~.gif';
 } else {
  document.getElementById('icon_on').src = 'images/foorplan/devices/' + map_icon + '-on.png';
  document.getElementById('icon_off').src = 'images/foorplan/devices/' + map_icon + '-off.png';
 }
}

function drawfields() {
 var type = document.getElementById('device_type').value;
 switch(type) {
  case '1': // Server
   document.getElementById('div_driver').style.display = 'none';
   document.getElementById('div_options').style.display = 'none';
   document.getElementById('div_parameters').style.display = 'none';
   document.getElementById('div_urls').style.display = 'block';
   break;
  case '2': // NooLite
   document.getElementById('div_driver').style.display = 'none';
   document.getElementById('div_options').style.display = 'none';
   document.getElementById('div_parameters').style.display = 'block';
   document.getElementById('label_parameters').innerHTML='Канал привязки';
   document.getElementById('div_urls').style.display = 'none';
   break;
  default:
   document.getElementById('div_driver').style.display = 'block';
   document.getElementById('div_options').style.display = 'block';
   document.getElementById('div_parameters').style.display = 'block';
   document.getElementById('label_parameters').innerHTML='Дополнительные параметры';
   document.getElementById('div_urls').style.display = 'block';
 }
}

function onLoad() {
 drawfields();
 drawmapicon();
}

window.onload = onLoad;
document.getElementById('map_icon').onchange = drawmapicon;
document.getElementById('device_type').onchange = drawfields;
</script>
