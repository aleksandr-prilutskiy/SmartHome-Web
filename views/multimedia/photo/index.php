<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\assets\PhotoAsset;
PhotoAsset::register($this);
$this->title = 'Фотографии';
$this->params['breadcrumbs'][] = [
    'label' => 'Мультимедиа',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => Html::encode($this->title),
    'url' => '?r=photo/index/',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
if ($album == 'new') {
    $this->title = 'Новое';
    $this->params['breadcrumbs'][] = [
        'label' => Html::encode($this->title),
        'url' => '?r=photo/new/',
        'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
    ];
} elseif ($album->id <> 0) {
    foreach ($albums as $dir):
        $subdir = $dir->dir.'\\';
        if (substr($album->dir, 0, strlen($subdir)) == $subdir) {
            $this->params['breadcrumbs'][] = [
                'label' => Html::encode($dir->name),
                'url' => 'index.php?r=photo/albums&album='.$dir->id,
                'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
            ];
        }
    endforeach;
    $this->title = $album->name;
    $this->params['breadcrumbs'][] = [
        'label' => $this->title,
        'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
    ];
}
$script = <<< JS
var equal_height = 100;
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
    'icon' => 'fas fa-camera-alt']);
?>
<div class="row">
<?php if ($subalbums != '') {
    foreach ($subalbums as $subalbum): ?>
    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 fixhigth">
        <div class="row text-center">
            <a href="index.php?r=photo/albums&album=<?= $subalbum->id ?>">
                <img src="images\folder-photos.png" class="img-fluid" width="100" height="100">
            </a>
        </div>
        <div class="row text-center">
            <h5><strong><a href="index.php?r=photo/albums&album=<?= $subalbum->id ?>"><?= $subalbum->name ?></a></strong></h5>
        </div>
    </div>
<?php endforeach; }
foreach ($files as $file):
    if (file_exists(Yii::getAlias('@webroot').'/images/photo/'.$file->hash.'.jpg') &&
        file_exists(Yii::getAlias('@webroot').'/images/photo/thumbs/'.$file->hash.'.jpg')){ ?>
    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 fixhigth">
        <div class="row text-center" data-code="example-1">
            <a href="images/photo/<?= $file->hash ?>.jpg"
               data-toggle="lightbox" data-type="image" data-gallery="photogallery"
               data-title="<?= $file->filename ?>" data-footer="<?= $file->width ?>x<?= $file->hight ?>"
               data-width="<?= $file->width ?>" data-height="<?= $file->hight ?>">
                <img src="images\photo\thumbs\<?= $file->hash ?>.jpg" class=img-fluid">
            </a>
        </div>
        <div class="row text-center">
            <h5><strong><?= substr($file->filename, strripos($file->filename, "\\") + 1) ?></strong></h5>
        </div>
    </div>
<?php } else { ?>
    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 fixhigth">
        <div class="row text-center" data-code="example-1">
            <img src="images\file_not_found.png" class=img-fluid">
        </div>
        <div class="row text-center">
            <h5><strong><?= substr($file->filename, strripos($file->filename, "\\") + 1) ?></strong></h5>
        </div>
    </div>
<?php } endforeach; ?>
</div>
<div class="row text-center">
<?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>

<script type="text/javascript">
$(document).ready(function ($) {
   $(document).on('click', '[data-toggle="lightbox"]:not([data-gallery="navigateTo"]):not([data-gallery="example-gallery-11"])', function(event) {
      event.preventDefault();
      return $(this).ekkoLightbox({
         leftArrow: "<div class=\"text-left\"><i class=\"fa fa-arrow-circle-left\" aria-hidden=\"true\"></i></div>",
         rightArrow:"<div class=\"text-right\"><i class=\"fa fa-arrow-circle-right\" aria-hidden=\"true\"></i></div>",
         onShown: function() {
            if (window.console) {
               return console.log('Checking our the events huh?');
            }
         },
         onNavigate: function(direction, itemIndex) {
            if (window.console) {
               return console.log('Navigating '+direction+'. Current item: '+itemIndex);
            }
         }
      });
   });
});
</script>