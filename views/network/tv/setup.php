<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Tv_channel_map;
$this->title = 'Настройка каналов';
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
    'label' => Html::encode($this->title),
    'template' => PHP_EOL.'{link}'.PHP_EOL.'/'
];
global $min_id;
global $max_id;
$min_id = Tv_channel_map::find()->select('id')->where(['device' => $device->name])->min('id');
$max_id = Tv_channel_map::find()->select('id')->where(['device' => $device->name])->max('id');

echo $this->render('..\..\layouts\_boxstart', [
    'title' => Html::encode($this->title),
    'icon' => 'fas fa-tv',
    'buttons' => [['url' => '?r=tv/add&id='.$device->id, 'icon' => 'glyphicon-plus']]]);
?>
<H3>Телевизор <?= $device->name ?></H3>
<table class="table table-striped">
    <thead>
        <tr>
            <td width="10%" class="text-right"><strong>№ на ТВ</strong></td>
            <td width="90%"><strong>Название канала</strong></td>
            <td><img src="images\~.gif" width="140" height="1"></td>
        </tr>
    </thead>
    <tbody>
<?php  foreach ($channels as $channel): ?>
        <tr>
            <td class="text-right"><?= $channel->number ?></td>
            <td><?= $channel->name ?></td>
            <td>
                <a class="btn btn-success btn-sm" href="?r=tv/update&id=<?= $channel->id ?>">
                    <i class="fas fa-pencil-alt"></i></a>
                <button type="button" class="btn btn-danger btn-sm"
                    data-toggle="modal" data-target="#ModalConfirmDelete" data-whatever="<?= $channel->id ?>"
                    data-text="<?= $channel->name ?>"><i class="fas fa-user-times"></i></button>  
<?php  if ($channel->id == $min_id) { ?>
                <img src="images\~.gif" width="27" height="20">
<?php } else { ?>
                <a class="btn btn-info btn-xs" href="?r=tv/up&id=<?= $channel->id ?>">
                    <i class="fa fa-arrow-circle-up fa-lg" aria-hidden="true"></i></a>
<?php } if ($channel->id == $max_id) { ?>
                <img src="images\~.gif" width="27" height="20">
<?php } else { ?>
                <a class="btn btn-info btn-xs" href="?r=tv/down&id=<?= $channel->id ?>">
                    <i class="fa fa-arrow-circle-down fa-lg" aria-hidden="true"></i></a>
<?php } ?>
            </td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>
<?php echo $this->render('..\..\layouts\_boxend');
echo $this->render('..\..\layouts\_modaldialog', [
    'id' => 'ModalConfirmDelete',
    'title' => 'Удалить канал из списка?',
]);
?>

<script>
 $('#ModalConfirmDelete').on('show.bs.modal', function (event) {
  var modal = $(this);
  modal.find('.modal-text').text('Вы действительно хотите удалить канал "'+$(event.relatedTarget).data('text')+'" с этого телевизора?');
  modal.find('.modal-button-ok').attr('onclick', 'location=\'?r=tv/delete&id='+$(event.relatedTarget).data('whatever')+'\'')
});
</script>
