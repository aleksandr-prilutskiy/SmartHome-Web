<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\Movies_info;
$this->title = 'Коллекции фильмов';
$this->params['breadcrumbs'][] = [
    'label' => 'Мультимедиа',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => 'Фильмы',
    'url' => '?r=movies/index/',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];

$this->params['breadcrumbs'][] = [
    'label' => Html::encode($this->title),
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$script = <<< JS
var equal_height = 300;
$(".fixhigth").each(function(){
    if ($(this).height() > equal_height) {
        equal_height = $(this).height(); 
    }
});
$(".fixhigth").height(equal_height);
JS;
$this->registerJs($script, yii\web\View::POS_READY);
echo $this->render('..\..\layouts\_boxstart', [
    'title' => Html::encode($this->title),
    'icon' => 'fas fa-film']);
?>
<div class="row">
<?php if (count($collections) == 0) { ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Ничего не найдено
    </div>
<?php } else { foreach ($collections as $collection):
$dirandfilename = Yii::getAlias('@webroot')."/images/movies/collections/".$collection->id.".jpg";
$img = 'no_image_200';
if (file_exists($dirandfilename)) $img = 'movies\collections\\'.$collection->id; ?>
    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 fixhigth">
        <div class="row text-center">
            <a href="index.php?r=movies/viewcollection&id=<?= $collection->id ?>">
                <img src="images\<?= $img ?>.jpg" class="img-thumbnail" width="200" height="300">
            </a>
        </div>
        <div class="row text-center">
            <h5><strong><a href="index.php?r=movies/viewcollection&id=<?= $collection->id ?>"><?= Movies_info::fixUTF8($collection->name) ?></a></strong></h5>
        </div>
    </div>
<?php endforeach; } ?>
</div>
<div class="row text-center">
<?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>
