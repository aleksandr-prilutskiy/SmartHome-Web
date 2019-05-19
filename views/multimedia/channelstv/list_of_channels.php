<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = $title;
$this->params['breadcrumbs'][] = [
    'label' => 'Мультимедиа',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => 'Телевидение',
    'url' => '?r=channelstv/index/',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => Html::encode($this->title),
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$script = <<< JS
    var equal_height = 100;
    $(".panel").each(function(){if ($(this).height() > equal_height) { equal_height = $(this).height(); }});
    $(".panel").height(equal_height);
JS;
$this->registerJs($script, yii\web\View::POS_READY);
echo $this->render('..\..\layouts\_boxstart', [
    'title' => Html::encode($this->title),
    'icon' => 'fas fa-podcast']);
 ?>
<div class="row">
<?php if (count($channels) > 0 ) {
 foreach ($channels as $channel): ?>
    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 panel">
        <div class="row text-center">
            <div class="well col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
                <a href="index.php?r=tvchannels/info&id=<?= $channel->id ?>">
<?php if (file_exists(Yii::getAlias('@webroot')."/images/tv/".$channel->channel_id.".png")) { ?>
                    <img src="images\tv\<?= $channel->channel_id ?>.png" width="60" height="45">
<?php } else { ?>
                    <img src="images\no_image_80.jpg" width="60" height="45">
<?php } ?>
                </a>
                <div class="row text-center">
                    <h5><strong><a href="index.php?r=tvchannels/info&id=<?= $channel->id ?>"><?= $channel->name ?></a></strong></h5>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
<?php } ?>
<div class="row text-center">
<?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>
