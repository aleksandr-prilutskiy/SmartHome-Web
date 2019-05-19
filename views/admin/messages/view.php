<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Отчет #'.$model->id;
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
            <div class="raw text-right">
                <button class="btn btn-primary" onclick="location='?r=messages/index&sort=-time'">Закрыть</button>
            </div>
<?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
<?= $form -> field($model, 'creator', [
    "template" => "<label>Устройство либо сервис</label>\n{input}\n{hint}\n{error}"
    ]) -> textarea(['rows' => 1]) ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
<?= $form -> field($model, 'event', [
    "template" => "<label>Название события</label>\n{input}\n{hint}\n{error}"
    ]) -> textarea(['rows' => 1]) ?>
                </div>
            </div>
<?= $form -> field($model, 'description', [
    "template" => "<label>Описание события</label>\n{input}\n{hint}\n{error}"
    ]) -> textarea(['rows' => 1]) ?>
<?= $form -> field($model, 'logfile', [
    "template" => "<label>Файл протокола</label>\n{input}\n{hint}\n{error}"
    ]) -> textarea(['rows' => 10]) ?>
<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

