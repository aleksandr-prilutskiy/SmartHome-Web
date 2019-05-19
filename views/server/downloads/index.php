<?php
use yii\helpers\Html;
$this->title = 'Загрузки';
$this->params['breadcrumbs'][] = [
    'label' => Html::encode($this->title),
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
echo $this->render('..\..\layouts\_boxstart', [
    'title' => Html::encode($this->title),
    'icon' => 'fas fa-download']);
?>

<?php foreach ($dir->files as $file): ?>
    <?= $file ?><br>
<?php endforeach; ?>
<?php echo $this->render('..\..\layouts\_boxend'); ?>
