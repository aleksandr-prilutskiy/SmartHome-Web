<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Movies_info;
$this->title = 'Фильмы';
$this->params['breadcrumbs'][] = [
    'label' => 'Мультимедиа',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => Html::encode($this->title),
    'url' => '?r=movies/index/',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$script = <<< JS
var equal_height = 100;
$(".thumbnail").each(function(){
    if ($(this).height() > equal_height) {
        equal_height = $(this).height(); 
    }
});
$(".thumbnail").height(equal_height);
JS;
$this->registerJs($script, yii\web\View::POS_READY);
$aYears = ["" => "Любой"];
for ($i =  date('Y'); $i >= 1990; $i--) { $aYears[$i] = $i.' год';}
for ($i =  198; $i > 195; $i--) { $aYears[$i] = $i.'0 - '.$i.'9 годы';}
$aYears['0'] = 'до 1960 года';
$aGenres = ["" => "Любой"];
foreach ($genres as $genre) { $aGenres[$genre->value] = $genre->value; }
$aResolutions = ["" => "Любое"];
$aResolutions["hd"] = "HD (1280×720 точек)";
$aResolutions["full_hd"] = "FullHD (1920×1080 точек)";
$aResolutions["4k"] = "4K (4096×3072 точек)";
$aResolutions["60fps"] = "60 кадров в секунду";
$aResolutions["3d"] = "3D";
echo $this->render('..\..\layouts\_boxstart', [
    'title' => Html::encode($this->title),
    'icon' => 'fas fa-film']);
?>
<div class="row">
<?php
echo $this->render('..\..\layouts\_wellblock', [
    'title' => 'Избранное',
    'link' => '?r=movies/favorites/',
    'image' => 'images\pictures\favorite-48.png']);
echo $this->render('..\..\layouts\_wellblock', [
    'title' => 'Коллекции',
    'link' => '?r=movies/collections/',
    'image' => 'images\pictures\video_playlist-48.png']);
echo $this->render('..\..\layouts\_wellblock', [
    'title' => 'Все фильмы',
    'link' => '?r=movies/all/',
    'image' => 'images\pictures\movies-48.png']);
echo $this->render('..\..\layouts\_wellblock', [
    'title' => 'Просмотрено',
    'link' => '?r=movies/history/',
    'image' => 'images\pictures\browsed-48.png']);
if ($files_lost > 0) echo $this->render('..\..\layouts\_wellblock', [
    'title' => 'Без описания',
    'description' => 'Видеофайлы, описание которых не найдено',
    'link' => '?r=movies/lost/',
    'image' => 'images\pictures\file_video-48.png',
    'notification' => $files_lost]);
if ($files_new > 0) echo $this->render('..\..\layouts\_wellblock', [
    'title' => 'Новое на сервере',
    'link' => '?r=movies/new/',
    'image' => 'images\pictures\new-48.png',
    'notification' => $files_new]);
?>
</div>
<?php
echo $this->render('..\..\layouts\_boxend');
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Поиск',
    'icon' => 'fas fa-search']);
$form = ActiveForm::begin();
?>
<div class="form-group">
    <label>Введите текст для поиска</label>
    <div class="input-group">
<?= $form->field($form_model, 'searchstr', ['template' => '{input}'])->textInput(array('placeholder' => '', 'class' => 'form-control')) ?>
        <span class="input-group-btn">
            <?= Html::submitButton('Найти', ['class' => 'btn btn-success']) ?>
        </span>
    </div>
<?php ActiveForm::end() ?>
    <br>
<?php $form = ActiveForm::begin() ?>
    <table>
        <tr>
            <td>
                <div class="input-group">
                    <?= $form->field($form_model, 'year', [
                        'template' => '<label>Год выхода</label>{input}'
                    ])->dropDownList($aYears); ?>
                </div>
            </td>
            <td><img src="images\~.gif" width="20" height="1"></td>
            <td>
                <div class="input-group">
                    <?= $form->field($form_model, 'genre', [
                        'template' => '<label>Жанр</label>{input}'
                    ])->dropDownList($aGenres); ?>
                </div>
            </td>
            <td><img src="images\~.gif" width="20" height="1"></td>
            <td>
                <div class="input-group">
                    <?= $form->field($form_model, 'resolution', [
                        'template' => '<label>Качество изображения</label>{input}'
                    ])->dropDownList($aResolutions); ?>
                </div>
            </td>
            <td><img src="images\~.gif" width="20" height="1"></td>
            <td>
                <div class="input-group">
                    <span class="input-group-btn">
                        <?= Html::submitButton('Найти', ['class' => 'btn btn-success']) ?>
                    </span>
                </div>
        </tr>
    </table>
</div>
<?php ActiveForm::end();
echo $this->render('..\..\layouts\_boxend');
echo $this->render('..\..\layouts\_boxstart', [
    'title' => 'Фильмы дня',
    'icon' => 'fas fa-birthday-cake']); ?>
<div class="row">
<?php foreach ($moviesofday as $movieofday):
 $dirandfilename = Yii::getAlias('@webroot')."/images/movies/".$movieofday->value.".jpg";
 if (file_exists($dirandfilename)) { $img_path = 'movies\\'.$movieofday->value; }
 else { $img_path = 'no_image_200'; }
 $movieinfo = Movies_info::find()
    ->where(['id' => $movieofday->value])
    ->one();
?>
    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 fixhigth">
        <div class="row text-center">
            <a href="index.php?r=movies/info&id=<?= $movieofday->value ?>">
                <img src="images\<?= $img_path ?>.jpg" class="img-thumbnail" width="200" height="300">
            </a>
        </div>
        <div class="row text-center">
            <h5><strong><a href="index.php?r=movies/info&id=<?= $movieofday->value ?>"><?= $movieinfo->name_rus ?></a></strong></h5>
<?php if ( $movieinfo->year <> 0) { ?>
            <p>
                <span class="glyphicon glyphicon-calendar"></span>
                <strong><?= $movieinfo->year ?> год</strong>
            </p>
<?php } ?>
        </div>
    </div>
<?php endforeach; ?>
</div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>
