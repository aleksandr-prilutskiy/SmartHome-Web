<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use app\models\system_;
$this->title = $title;
$this->params['breadcrumbs'][] = [
    'label' => 'Сеть',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => 'Телевизоры',
    'url' => '?r=tv/index',
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => Html::encode($device->name),
    'url' => '?r=tv/info&id='.$device->id,
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => 'Настройка каналов',
    'url' => '?r=tv/setup&id='.$device->id,
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
$this->params['breadcrumbs'][] = [
    'label' => Html::encode($this->title),
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
echo $this->render('..\..\layouts\_boxstart', [
    'title' => Html::encode($this->title),
    'icon' => 'fas fa-tv']);
?>
<H3>Телевизор: <?= $device->name ?></H3>
<div class="server-devices-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
            <?= $form -> field($model, 'number', [
                "template" => "<label>№ канала на ТВ</label>\n{input}\n{hint}\n{error}"
                ])->input('text') ?>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">
            <?= $form->field($model, 'channel_id', [
                "template" => "<label>Наименование канала</label>\n{input}\n{hint}\n{error}"
                ])->dropDownList($channels) ?>
        </div>
    </div>
    <div class="form-group">
<?= Html::submitButton('<i class="fa fa-check" aria-hidden="true"></i>&nbsp;Сохранить', ['class' => 'btn btn-success']) ?>
        <button class="btn btn-danger" formaction="index.php?r=tv/setup&id=<?= $device->id ?>">
            <i class="fa fa-times" aria-hidden="true"></i>&nbsp;Отмена
        </button>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php echo $this->render('..\..\layouts\_boxend'); ?>
