<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Авторизация на сайте';
?>
<div class="site-login">
    <div class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Заполните следующие поля для входа на сайт:</p>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
        <?= $form->field($model, 'username', [
                "template" => "<label>Имя пользователя</label>{input}\n{hint}\n{error}"
                ])->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'password', [
                "template" => "<label>Пароль</label>{input}\n{hint}\n{error}"
                ])->passwordInput() ?>
        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "{input} <strong>Запомнить меня</strong></div>\n<div class=\"col-lg-8\">{error}",
        ]) ?>
        <div class="col-lg-offset-4 col-lg-4 col-md-offset-4 col-md-4 col-sm-offset-5 col-sm-3 col-xs-offset-4 col-xs-4">
            <?= Html::submitButton('Вход', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
