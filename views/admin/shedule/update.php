<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use app\models\Config;
$this->title = $title;
$app_list = array();
$app_list['@'] = '@';
$app_list['nooLite'] = 'nooLite';
$bindirpath = Config::find()->where("name = 'CommandFilesDir'")->one()->data;
if (file_exists($bindirpath)) {
    $bindir = dir($bindirpath);
    if ($bindir) {
        while (false !== ($name = $bindir->read())) {
            if ($name === '.' || $name === '..') continue;
            if (filetype($bindirpath . '\\' . $name) == "file") {
                if (substr(mb_strtolower($name), -4, 4) == ".exe") {
                    $command = substr($name, 0, -4);
                    $app_list[$command] = $command;
                }
            }
        }
    $bindir->close();
    }
}
$devices_list = array();
$devices_list[''] = '';
foreach ($devices as $device) $devices_list[ $device->name] = $device->name;
$modes_list = array();
$modes_list[0] = 'Один раз';
$modes_list[1] = 'С интервалом';
$modes_list[2] = 'Каждый час';
$modes_list[3] = 'Ежедневно';
$modes_list[4] = 'Еженедельно';
$modes_list[5] = 'Ежемесячно';
$modes_list[6] = 'Ежемегодно';
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
<?php $form = ActiveForm::begin(); ?>
            <div class=" row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?= $form->field($model, 'enable')
    ->checkbox(['label' => 'Событие по рассписанию разрешено']) ?>
                </div>
            </div>
            <div class=" row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
<?= $form->field($model, 'application', [
    "template" => "<label>Приложение (утилита)</label>\n{input}\n{hint}\n{error}"
    ])->dropDownList($app_list) ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
<?= $form->field($model, 'command', [
    "template" => "<label>Команда</label>\n{input}\n{hint}\n{error}"
    ])->input('text') ?>
                </div>
            </div>
            <div class=" row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
<?= $form->field($model, 'device', [
    "template" => "<label>Устройство</label>\n{input}\n{hint}\n{error}"
    ])->dropDownList($devices_list) ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
<?= $form->field($model, 'parameters', [
    "template" => "<label>Параметры</label>\n{input}\n{hint}\n{error}"
    ])->input('text') ?>
                </div>
            </div>
            <div class=" row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
<?= $form->field($model, 'mode', [
    "template" => "<label>Режим повторения события</label>\n{input}\n{hint}\n{error}",
    ])->dropDownList($modes_list, ["id" => "field_mode"]) ?>
                </div>
                <div id="field_period" class="col-lg-4 col-md-6 col-sm-12 col-xs-12" style="display: none">
<?= $form -> field($model, 'period', [
    "template" => "<label>Период (в секундах)</label>\n{input}\n{hint}\n{error}"
    ])->input('text') ?>
                </div>
                <div id="field_timer" class="col-lg-4 col-md-6 col-sm-12 col-xs-12" style="display: none">
<?= $form->field($model, 'next_time', [
    "template" => "<label>Время выполнения события</label>\n{input}\n{hint}\n{error}"
    ])->widget(DateTimePicker::classname(), [
        'id' => 'widget_timer',
        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'todayBtn' => true,
            'format' => 'yyyy/mm/dd hh:ii:00',
            'language' => 'ru'
        ]
    ]) ?>
                </div>
            </div>
<?= $form -> field($model, 'description', [
    "template" => "<label>Описание </label>\n{input}\n{hint}\n{error}"
    ]) -> textarea(['rows' => 3]) ?>
            <div class="form-group text-center">
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                <button class="btn btn-danger" formaction="index.php?r=shedule/index">Отменить</button>
            </div>
<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
function FormDrawFields() {
 var mode = document.getElementById('field_mode').value;
 switch(mode) {
  case '0': // Один раз
   document.getElementById('field_period' ).style.display = 'none';
   document.getElementById('field_timer' ).style.display = 'block';
   break;
  case '1': // С интервалом
   document.getElementById('field_period' ).style.display = 'block';
   document.getElementById('field_timer' ).style.display = 'none';
   break;
  case '2': // Каждый час
   document.getElementById('field_period' ).style.display = 'none';
   document.getElementById('field_timer' ).style.display = 'block';
   break;
  case '3': // Ежедневно
   document.getElementById('field_period' ).style.display = 'none';
   document.getElementById('field_timer' ).style.display = 'block';
   break;
  case '4': // Еженедельно
   document.getElementById('field_period' ).style.display = 'none';
   document.getElementById('field_timer' ).style.display = 'block';
   break;
  case '5': // Ежемесячно
   document.getElementById('field_period' ).style.display = 'none';
   document.getElementById('field_timer' ).style.display = 'block';;
   break;
  case '6': // Ежемегодно
   document.getElementById('field_period' ).style.display = 'none';
   document.getElementById('field_timer' ).style.display = 'block';
   break;
  default:
   document.getElementById('field_period' ).style.display = 'none';
   document.getElementById('field_timer' ).style.display = 'none';
 }
}
window.onload = FormDrawFields;
document.getElementById('field_mode').onchange = FormDrawFields;
</script>
