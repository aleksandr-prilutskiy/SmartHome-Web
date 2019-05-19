<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Config;
$this->title = $title;
$app_list = array();
$app_list['@'] = '@';
$bindirpath = Config::find()->where("name = 'CommandFilesDir'")->one()->data;
$bindir = dir($bindirpath);
if (file_exists($bindirpath)) {
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
$commands = array();
$commands['@'] = '@';
$bindirpath = Config::find()
    ->where("name = 'CommandFilesDir'")
    ->one()
    ->data;
$bindir = dir($bindirpath);
if ($bindir) {
    while (false !== ($name = $bindir->read())) {
        if ($name === '.' || $name === '..') continue;
        if (filetype($bindirpath . '\\' . $name) == "file") {
            if (substr(mb_strtolower($name), -4, 4) == ".exe") {
                $command = substr($name, 0, -4);
                $commands[$command] = $command;
            }
        }
    }
    $bindir->close();
}
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
    ->checkbox(['label' => 'Сценарий разрешен']) ?>
                </div>
            </div>
            <div class=" row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?= $form->field($model, 'rules', [
    "template" => "<label>Правило срабатывания сценария</label>\n{input}\n{hint}\n{error}"
    ])->textarea(['rows' => 1]) ?>
                </div>
            </div>
            <div class=" row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
<?= $form->field($model, 'delay', [
    "template" => "<label>Задержка срабатывания (сек)</label>\n{input}\n{hint}\n{error}"
    ])->input('text') ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
<?= $form->field($model, 'timeout', [
    "template" => "<label>Таймаут срабатывания (сек)</label>\n{input}\n{hint}\n{error}"
    ])->input('text') ?>
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
<?= $form -> field($model, 'description', [
    "template" => "<label>Описание </label>\n{input}\n{hint}\n{error}"
    ]) -> textarea(['rows' => 1]) ?>
            <div class="form-group text-center">
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                <button class="btn btn-danger" formaction="index.php?r=scripts/index">Отменить</button>
            </div>
<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
