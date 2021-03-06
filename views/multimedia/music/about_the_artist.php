<?php
use yii\helpers\Html;
$this->title = $albums[0]->Artistname;
$this->params['breadcrumbs'][] = [
    'label' => 'Мультимедиа',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => 'Музыка',
    'url' => '?r=music/index/',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
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
    'icon' => 'fas fa-music']);
?>
<div class="row">
<?php foreach ($albums as $album):
 $img = 'no_image_300';
 if (file_exists(Yii::getAlias('@webroot')."/images/music/album_".$album->hash.".jpg")) $img = 'music\album_'.$album->hash; ?>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 fixhigth">
        <div class="row text-center">
            <a href="index.php?r=music/album&id=<?= $album->id ?>">
                <img src="images\<?= $img ?>.jpg" class="img-thumbnail" width="300" height="300">
            </a>
        </div>
        <div class="row text-center">
            <h5><strong><a href="index.php?r=music/album&id=<?= $album->id ?>"><?= $album->albumname ?></a></strong></h5>
<?php if ( $album->year <> 0) { ?>
            <p>
                <span class="glyphicon glyphicon-calendar"></span>
                <strong><?= $album->year ?> год</strong>
            </p>
<?php } ?>
        </div>
    </div>
<?php endforeach; ?>
</div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>
