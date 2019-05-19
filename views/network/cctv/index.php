<?php
use yii\helpers\Html;
$this->title = 'Видеонаблюдение';
foreach ($devices as $device): ?>
            <div class="box col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="box-inner">
                    <div class="box-header well" data-original-title="">
                        <h2><?= $device->description ?></h2>
                    </div>
                    <div class="box-content" style="height:400px;">
                        <a title="description" class="top-block" href="index.php?r=tv/info&id=<?= $device->id ?>">
                            <iframe width="100%" height="400" frameborder="0"
                                    allowTransparency="true" style="margin-left: 20px"
                                    src="http://<?= $device->addr ?>:<?= $device->parameters ?>"></iframe>
                        </a>
                    </div>
                </div>
            </div>
<?php endforeach; ?>
