<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Сериалы';
$this->params['breadcrumbs'][] = [
    'label' => 'Мультимедиа',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => '?r=series/index/',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$script = <<< JS
    var equal_height = 250;
    $(".panel").each(function(){if ($(this).height() > equal_height) { equal_height = $(this).height(); }});
    $(".panel").height(equal_height);
JS;
$this->registerJs($script, yii\web\View::POS_READY);
echo $this->render('..\..\layouts\_boxstart', [
    'title' => Html::encode($this->title),
    'icon' => 'fas fa-tv-retro']);
?>
<div class="row">
<?php
////echo $this->render('..\..\layouts\_wellblock', [
//    'title' => 'Избранное',
//    'image' => 'images\pictures\favorite-48.png']);
echo $this->render('..\..\layouts\_wellblock', [
    'title' => 'Все сериалы',
    'link' => '?r=series/all/',
    'image' => 'images\pictures\movies-48.png']);
echo $this->render('..\..\layouts\_wellblock', [
    'title' => 'Просмотренные',
    'link' => '?r=series/history/',
    'image' => 'images\pictures\browsed-48.png']);
if ($files_new > 0) echo $this->render('..\..\layouts\_wellblock', [
    'title' => 'Новое на сервере',
    'link' => '?r=series/new/',
    'image' => 'images\pictures\new-48.png',
    'notification' => $files_new]);
?>
</div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>
<?php echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Поиск',
    'icon' => 'fas fa-search']); ?>
<?php $form = ActiveForm::begin(); ?>
<div class="form-group">
    <label>Введите текст для поиска</label>
    <div class="input-group">
        <?= $form->field($form_model, 'searchstr', ['template' => '{input}'])
            ->textInput(array('placeholder' => '', 'class' => 'form-control')) ?>
        <span class="input-group-btn">
            <?= Html::submitButton('Найти', ['class' => 'btn btn-success']) ?>
        </span>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php echo $this->render('..\..\layouts\_boxend'); ?>
