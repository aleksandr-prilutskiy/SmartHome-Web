<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Общая папка';
$this->params['breadcrumbs'][] = [
    'label' => 'Сервер',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => Html::encode($this->title),
    'url' => '?r=share/index',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
echo $this->render('..\..\layouts\_boxstart', [
    'title' => Html::encode($this->title),
    'icon' => 'fas fa-folder-open']);
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class=" row">
        <a href="index.php?r=share/index">
            <button type="button" class="btn btn-default btn-sm"><i class="fas fa-arrow-to-top"></i>&nbsp;В начало</button>
        </a>
        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#ModalCreateDir">
            <i class="fas fa-folder"></i>&nbsp;Создать каталог
        </button>
        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#ModalDeleteFiles">
            <i class="fas fa-trash"></i>&nbsp;Удалить
        </button>
        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#ModalUploadFile">
            <i class="fas fa-upload"></i>&nbsp;Загрузить
        </button>
    </div>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <td></td>
            <td><img src="images/~.gif" width="24" hight="1" border="0"></td>
            <td width='100%'>Имя файла</td>
        </tr>
    </thead>
    <tbody>
<?php if ($path != '') {
    $parent_dir = '';
    $pos = strrpos($path, '/');
    if ($pos) $parent_dir = substr($path, 0, $pos);?>
        <tr onclick="javascript:document.location.href='index.php?r=share/index&subdir=<?= $parent_dir ?>'" style="cursor: pointer">
            <td></td>
            <td><img src="images/filetypes/_folder_return.png" border="0"></td>
            <td>..</td>
        </tr>
<?php } foreach ($dir->folders as $folder): ?>
        <tr>
            <td><input type="checkbox"></td>
            <td>
                <img src="images/filetypes/_folder.png" border="0" width="24" height="24"
                     onclick="javascript:document.location.href='index.php?r=share/index&subdir=<?= $path.'/'.$folder->name ?>'" style="cursor: pointer">
            </td>
            <td><strong><?= $folder->name ?></strong></td>
        </tr>
<?php endforeach; ?>

<?php foreach ($dir->files as $file):
 $onclick = '';
 if ($share_url != '') {
  $file_url = $share_url;
  if ($path != '') $file_url = $file_url . $path;
//  $onclick = ' onclick="javascript:document.location.href=\''. $file_url . '/' . $file->name . '\'" style="cursor: pointer" ';
  $onclick = ' onclick=window.open(\''. $file_url . '/' . $file->name . '\') style="cursor: pointer"';
 }
 $ext = strtolower(substr($file->name, -4));
 $img = '_file.png';
 if (($ext == '.bmp') || ($ext == '.jpg') || ($ext == '.png') || ($ext == '.gif')) $img = '_file_image.png';
 if ($ext == '.pdf') $img = 'pdf.png';
 if ($ext == '.txt') $img = 'txt.png';
 if ($img == '_file.png') $onclick = '';
?>
        <tr>
            <td><input type="checkbox" id="delete_<?= $file->name ?>"></td>
            <td>
                <img src="images/filetypes/<?= $img ?>"<?= $onclick ?> border="0" width="24" height="24">
            </td>
            <td><?= $file->name ?></td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>
<?php echo $this->render('..\..\layouts\_boxend'); ?>

<div id="ModalCreateDir" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
                <div class="modal-header">
                    <h4>Создать подкаталог</h4>
                </div>
                <div class="modal-body modal-text">
                    <?= $form->field($model_DirectoryCreate, 'name', [
                        "template" => "<label>Имя каталога</label>\n{input}\n{hint}\n{error}",
                        ]) -> textInput() ?>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Отмена</a>
                    <button class="btn btn-success">Создать</button>
                </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>

<div id="ModalDeleteFiles" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
                <div class="modal-header">
                    <h4>Удаление файлов</h4>
                </div>
                <div class="modal-body modal-text">
                    Вы действительно хотите удалить выбранные файлы (или каталоги)?
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Отмена</a>
                    <button class="btn btn-danger">Удалить</button>
                </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>

<div id="ModalUploadFile" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
                <div class="modal-header">
                    <h4>Загрузка файла</h4>
                </div>
                <div class="modal-body modal-text">
                    <?= $form->field($model_FileUpload, 'newFile', [
                        "template" => "{input}\n{hint}\n{error}",
                        ]) -> fileInput() ?>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Отмена</a>
                    <button class="btn btn-success">Загрузить</button>
                </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>

<script>
 $('#ModalCreateDir').on('show.bs.modal', function (event) {
  var modal = $(this);
});
$('#ModalDeleteFiles').on('show.bs.modal', function (event) {
  var modal = $(this);
});
$('#ModalUploadFile').on('show.bs.modal', function (event) {
  var modal = $(this);
});
</script>
