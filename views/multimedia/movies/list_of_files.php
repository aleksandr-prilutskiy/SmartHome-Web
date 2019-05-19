<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = 'Список файлов';
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
$this->registerJsFile('js/smarthome.js',  ['position' => yii\web\View::POS_HEAD]);
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Список файлов без описания',
    'icon' => 'fas fa-film']);
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-striped" style="margin-bottom:0">
            <thead>
                <tr>
                    <th><img src="images\~.gif" width="140" height="1"></th>
                    <th class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Имя файла</th>
                </tr>
            </thead>
            <tbody>
<?php foreach ($files as $file): ?>
                <tr>
                    <td>
<?php if ($is_local_ip) {
    echo $this->render('..\..\layouts\_playbutton', [
        'title' => 'Просмотреть',
        'id' => $file->dlna_id,
        'dlna_url' => $dlna_url.$file->dlna_id.'.xspf?fileext=.xspf',
        'devices' => $devices]);
} ?>
                    </td>
                    <td><?= $file->filename ?></td>
                </tr>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row text-center">
<?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>

<script>
window.onload = playon_buttons_setstate;
</script>
