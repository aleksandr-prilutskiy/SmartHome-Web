<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Sensors;
$this->title = $title;
$type = array();
$type[0] = 'Не определен';
$type[1] = 'Датчик температуры';
$type[2] = 'Датчик влажности';
$type[3] = 'Датчик газов';
$iconfiles = array();
$iconfiles[''] = 'Нет';
$imagesdirpath = Yii::getAlias('@webroot')."/images/foorplan/sensors";
if (file_exists($imagesdirpath)) {
    $imagesdir = dir($imagesdirpath);
    if ($imagesdir) {
        while (false !== ($name = $imagesdir->read())) {
            if ($name === '.' || $name === '..') continue;
            if (filetype($imagesdirpath . '\\' . $name) == "file") {
                if (substr(mb_strtolower($name), -4, 4) == ".png") {
                    $filename = substr($name, 0, -4);
                    $iconfiles[$filename] = $filename;
                }
            }
        }
        $imagesdir->close();
    }
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
        <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
            <?= $form->field($model, 'topic', [
                "template" => "<label>MQTT топик</label>\n{input}\n{hint}\n{error}",
                ])->input('text') ?>
        </div>
        <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
            <?= $form->field($model, 'description', [
                "template" => "<label>Описание</label>\n{input}\n{hint}\n{error}"
                ])->input('text') ?>
        </div>
    </div>
    <div class=" row">
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <?= $form->field($model, 'type', [
                "template" => "<label>Тип датчика</label>\n{input}\n{hint}\n{error}"
                ])-> dropDownList($type, ["id" => "sensor_type"]) ?>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <?= $form->field($model, 'units', [
                "template" => "<label>Единицы измерения</label>\n{input}\n{hint}\n{error}"
                ])->input('text') ?>
        </div>
    </div>
    <div class="row">
        <div class="row row col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <fieldset>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:40px;">
                    <legend>Настройка опций:</legend>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="padding-left:40px;">
                    <?= $form->field($model, 'av_temperature')
                        ->checkbox(['label' => 'Участвует в подсчете средней температуры в помещении']) ?>
                    <?= $form->field($model, 'av_humidity')
                        ->checkbox(['label' => 'Участвует в подсчете средней влажности в помещении']) ?>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="padding-left:40px;">
                    <?= $form->field($model, 'ex_temperature')
                        ->checkbox(['label' => 'Участвует в подсчете средней внешней температуры']) ?>
                    <?= $form->field($model, 'ex_humidity')
                        ->checkbox(['label' => 'Участвует в подсчете средней внешней влажности']) ?>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row">
        <div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <fieldset>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:40px;">
                    <legend>Отображение устройства на плане помещений:</legend>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div style="position:absolute;left:70px;top:25px;">
                        <img id="icon" src="images\~.gif" width="32" height="32">
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'map_icon', [
                        "template" => "<label>Изображение</label>\n{input}\n{hint}\n{error}",
                        ])->dropDownList($iconfiles, ["id" => "map_icon"]) ?>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'map_pos', [
                        "template" => "<label>Координаты</label>\n{input}\n{hint}\n{error}",
                        ])->input('text') ?>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="form-group text-center">
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        <button class="btn btn-danger" formaction="index.php?r=admsensors/index">Отменить</button>
    </div>
    <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
function drawmapicon() {
 var map_icon = document.getElementById('map_icon').value;
 if (map_icon == '') {
  document.getElementById('icon').src = 'images/~.gif';
 } else {
  document.getElementById('icon').src = 'images/foorplan/sensors/' + map_icon + '.png';
 }
}

function drawfields() {
 var mode = document.getElementById('field_mode').value;
 switch(mode) {
  case '1': // В виде графика
   document.getElementById('chart_mode' ).style.display = 'block';
   break;
  default:
   document.getElementById('chart_mode' ).style.display = 'none';
 }
}

function onLoad() {
 drawfields();
 drawmapicon();
}

window.onload = onLoad;
document.getElementById('map_icon').onchange = drawmapicon;
document.getElementById('field_mode').onchange = drawfields;
</script>
