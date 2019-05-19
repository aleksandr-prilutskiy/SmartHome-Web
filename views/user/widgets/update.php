<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = $title;
$widgets_list = array();
$widgets_setup = array();
$widgets_list[''] = '{ перевод строки }';
$widgetsdirpath = Yii::getAlias('@app')."/views/widgets";
if (file_exists($widgetsdirpath)) {
    $widgetsdir = dir($widgetsdirpath);
    if ($widgetsdir) {
        while (false !== ($name = $widgetsdir->read())) {
            if ($name === '.' || $name === '..') continue;
            if (filetype($widgetsdirpath . '\\' . $name) == "dir") $widgets_list[$name] = $name;
        }
        $widgetsdir->close();
    }
}
?>
<div class="box col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
<?php $form = ActiveForm::begin(); ?>
            <div class=" row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?= $form->field($model, 'widget', [
    "template" => "<label>widget</label>\n{input}\n{hint}\n{error}"
    ])->dropDownList($widgets_list) ?>
                </div>
            </div>
            <div class=" row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?= $form->field($model, 'parameters', [
    "template" => "<label>parameters</label>\n{input}\n{hint}\n{error}"
    ])->textInput() ?>
                </div>
            </div>
            <div class="form-group text-center">
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                <button class="btn btn-danger" formaction="index.php?r=user/widgets">Отменить</button>
            </div>
<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
