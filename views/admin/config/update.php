<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = $title;
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
<?php $form = ActiveForm::begin(); ?>
<?= $form -> field($model, 'name', [
    'template' => '<label>Имя переменной</label>{input}{hint}{error}'
    ])->input('text') ?>
<?= $form -> field($model, 'data', [
    'template' => '<label>Значение</label>{input}{hint}{error}'
    ])->input('text') ?>
            <div class="form-group text-center">
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                <button class="btn btn-danger" formaction="index.php?r=admconfig/index">Отменить</button>
            </div>
<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
