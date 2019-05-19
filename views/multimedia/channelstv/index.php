<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = 'Телевидение';
$this->params['breadcrumbs'][] = [
    'label' => 'Мультимедиа',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => Html::encode($this->title),
    'url' => '?r=channelstv/index',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
echo $this->render('..\..\layouts\_boxstart', [
    'title' => Html::encode($this->title),
    'icon' => 'fas fa-podcast']);
?>
<div class="row">
<?php
echo $this->render('..\..\layouts\_wellblock', [
    'title' => 'Избранное',
    'link' => '?r=channelstv/favorites/',
    'image' => 'images\pictures\favorite-48.png']);
echo $this->render('..\..\layouts\_wellblock', [
    'title' => 'Все каналы',
    'link' => '?r=channelstv/all/',
    'image' => 'images\pictures\movies-48.png']);
?>
</div>
<?php
echo $this->render('..\..\layouts\_boxend');
