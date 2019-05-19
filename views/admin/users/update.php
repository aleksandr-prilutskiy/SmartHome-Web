<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = $title;
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <div class=" row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
<?= $form->field($model, 'username', [
    "template" => "<label>Имя пользователя</label>\n{input}\n{hint}\n{error}",
    ]) -> textInput(['autofocus' => true, "id" => "input_username"]) ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
<?= $form->field($model, 'password', [
    "template" => "<label>Пароль</label>\n{input}\n{hint}\n{error}"
    ])->passwordInput() ?>
                </div>
            </div>
<?= $form->field($model, 'description', [
    "template" => "<label>Описание</label>\n{input}\n{hint}\n{error}"
    ]) -> textInput() ?>
            <div class="form-group text-center">
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                <button class="btn btn-danger" formaction="index.php?r=admusers/index">Отменить</button>
            </div>
<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
