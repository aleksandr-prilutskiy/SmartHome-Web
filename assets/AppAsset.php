<?php
namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/fontawesome-all.min.css',
        'css/animate.min.css',
        'css/charisma-app.css',
        'css/site.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];
}
