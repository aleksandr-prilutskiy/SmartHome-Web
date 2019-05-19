<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Музыка';
$this->params['breadcrumbs'][] = [
    'label' => 'Мультимедиа',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => Html::encode($this->title),
    'url' => '?r=music/index/',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
echo $this->render('..\..\layouts\_boxstart', [
    'title' => Html::encode($this->title),
    'icon' => 'fas fa-music']);
?>
<div class="row">
<?php
echo $this->render('..\..\layouts\_wellblock', [
    'title' => 'Избранное',
    'link' => '?r=music/favorites/',
    'image' => 'images\pictures\favorite-48.png']);
echo $this->render('..\..\layouts\_wellblock', [
    'title' => 'Исполнители',
    'link' => '?r=music/artists/',
    'image' => 'images\pictures\music-artists-48.png']);
echo $this->render('..\..\layouts\_wellblock', [
    'title' => 'Все альбомы',
    'link' => '?r=music/albums/',
    'image' => 'images\pictures\music-albums-48.png']);
echo $this->render('..\..\layouts\_wellblock', [
    'title' => 'Прослушано',
    'link' => '?r=music/history/',
    'image' => 'images\pictures\browsed-48.png']);
if ($files_lost > 0) echo $this->render('..\..\layouts\_wellblock', [
    'title' => 'Без альбомов',
    'description' => 'Файлы, без информации об альбоме',
    'link' => '?r=music/lost/',
    'image' => 'images\pictures\file_audio-48.png',
    'notification' => $files_lost]);
if ($files_new > 0) echo $this->render('..\..\layouts\_wellblock', [
    'title' => 'Новое на сервере',
    'link' => '?r=music/new/',
    'image' => 'images\pictures\new-48.png',
    'notification' => $files_new]);
?>
</div>
<?php
echo $this->render('..\..\layouts\_boxend');
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Поиск',
    'icon' => 'fas fa-search']);
$form = ActiveForm::begin(); ?>
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
<?php ActiveForm::end();
echo $this->render('..\..\layouts\_boxend'); ?>                
