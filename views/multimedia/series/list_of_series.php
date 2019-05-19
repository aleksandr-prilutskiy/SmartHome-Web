<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = $title;
$this->params['breadcrumbs'][] = [
    'label' => 'Мультимедиа',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => 'Сериалы',
    'url' => '?r=series/index/',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
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
<?php foreach ($series as $one_series):
 $dirandfilename = Yii::getAlias('@webroot')."/images/series/".$one_series->tmdb_id;
 if (file_exists($dirandfilename.".jpg")) {
  $img = '"images\series\\'.$one_series->tmdb_id.'.jpg" width="180" height="255"';
 } else {
  $img = '"images\no_image_255.jpg" width="180" height="255"';
 } ?>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 fixhigth">
        <div class="row text-center">
            <a href="index.php?r=series/info&id=<?= $one_series->tmdb_id ?>">
                <img src=<?= $img ?> class="img-thumbnail">
            </a>
        </div>
        <div class="row text-center">
            <h5><strong><a href="index.php?r=series/info&id=<?= $one_series->tmdb_id ?>"><?= $one_series->name_rus ?></a></strong></h5>
        </div>
    </div>
<?php endforeach; ?>
</div>
<div class="row text-center">
<?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>
