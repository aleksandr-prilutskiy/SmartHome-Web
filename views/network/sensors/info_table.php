<?php
use yii\helpers\Html;
$this->title = $title;
?>
<div class="box col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-content">
            <table class="table table-striped">
                <tbody>
<?php foreach ($data as $item): ?>
                    <tr>
                        <td align="right"><?= $item->updated ?></td>
                        <td align="left" width="100%"><?= $item->value ?>&nbsp;<?= $sensor->units ?></td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
