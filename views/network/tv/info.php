<?php
use yii\helpers\Html;
$this->title = 'Информация об устройстве';
$view = '';
$dir = Yii::getAlias('@app').'\views\network\devices\\';
$img = '<img src="images\no_image_255.jpg" class="img-thumbnail" width="360" height="510">';
if ($device->image <> '') {
    $path = Yii::getAlias('@webroot').'/images/devices/'.$device->image.'.jpg';
    if (file_exists($path)) $img = str_replace('no_image_255.jpg', '\devices\\'.$device->image.'.jpg', $img);
}
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs text-center"><?= $img ?></div>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                    <div class="box-inner">
                        <table class="table table-striped table-condensed">
                            <tbody>
                                <tr>
                                    <td class="text-right">Наименование:</td>
                                    <td width="100%"><?= $device->name ?></td>
                                </tr>
                                <tr>
                                    <td class="text-right">Описание:</td>
                                    <td><?= $device->description ?></td>
                                </tr>
<?php if ($device->addr <> '') { ?>
                                <tr>
                                    <td class="text-right">Адрес:</td>
                                    <td><?= $device->addr ?></td>
                                </tr>
<?php } if ($device->webpage <> '') { $links = explode(";", $device->webpage); ?>
                                <tr>
                                    <td class="text-right">Web-интерфейс:</td>
                                    <td>
<?php foreach ($links as $link):
    $str = explode("=", $link);
    if (count($str) > 1) { $link_name = $str[0]; $link_url = $str[1];} 
    else { $link_name = 'ссылка'; $link_url = $str[0];} ?>
                                        <a href="<?= $link_url ?>" target="_blanc"><?= $link_name ?></a><br>
<?php endforeach; ?>
                                    </td>
                                </tr>
<?php } if ($device->manufacture <> '') { $links = explode(";", $device->manufacture); ?>
                                <tr>
                                    <td class="text-right">Сайт производителя:</td>
                                    <td>
<?php foreach ($links as $link):
    $str = explode("=", $link);
    if (count($str) > 1) { $link_name = $str[0]; $link_url = $str[1];} 
    else { $link_name = 'ссылка'; $link_url = $str[0];} ?>
                                        <a href="<?= $link_url ?>" target="_blanc"><?= $link_name ?></a><br>
<?php endforeach; ?>
                                    </td>
                                </tr>
<?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
