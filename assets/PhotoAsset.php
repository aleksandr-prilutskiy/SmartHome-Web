<?php
namespace app\assets;

use yii\web\AssetBundle;

class PhotoAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/font-awesome.min.css',
        'css/animate.min.css',
        'css/charisma-app.css',
        'css/site.css',
        'css/ekko-lightbox.css',
    ];
    public $js = [
        'js/ekko-lightbox.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];
}
