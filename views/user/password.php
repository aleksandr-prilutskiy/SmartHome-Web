<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Изменение Вашего пароля';
?>
<div class="box col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
<?php
$form = ActiveForm::begin(['id' => 'form-signup']); ?>
                            <div class=" row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?= $form->field($model, 'password', [
    "template" => "<label>Новый пароль</label>\n{input}\n{hint}\n{error}"
    ])->passwordInput() ?>
                                </div>
                            </div>
                            <div class="form-group text-center">
<?= Html::submitButton('<i class="fa fa-check" aria-hidden="true"></i>&nbsp;Сохранить', ['class' => 'btn btn-success']) ?>
                                <button class="btn btn-danger" formaction="index.php">
                                    <i class="fa fa-times" aria-hidden="true"></i>&nbsp;Отмена
                                </button>
                            </div>
<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
