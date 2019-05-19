<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = 'Исполнители';
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
echo $this->render('..\..\layouts\_boxstart', [
    'title' => Html::encode($this->title),
    'icon' => 'fas fa-music']);
?>
<table class="table table-striped">
    <thead class="hidden-xs">
        <tr>
            <th width="100%">Имя / название</th>
            <th class="hidden-xs hidden-sm">Альбомов</th>
            <th class="hidden-xs hidden-sm">Композиций</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($artists as $artist): ?>
        <tr>
            <td><a href="index.php?r=music/artist&id=<?= $artist->id ?>"><?= $artist->artistname ?></a></td>
            <td class="hidden-xs hidden-sm" align="center"><?= $artist->total_albums ?></td>
            <td class="hidden-xs hidden-sm" align="center"><?= $artist->total_tracks ?></td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>
<div class="row text-center">
<?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>
