<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Config;
AppAsset::register($this);
$localsubnet = Config::find()->where("name = 'LocalNetworkMask'")->one()->data;
$is_local_ip = substr($_SERVER["REMOTE_ADDR"], 0, strlen($localsubnet)) == $localsubnet;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<!-- topbar starts -->
<div class="navbar navbar-default" role="navigation">
    <div class="navbar-inner">
        <button type="button" class="navbar-toggle pull-left animated flip">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>"><img src="images/logo.png" width="48" height="48"><span>MySmartHome</span></a>
        <!-- user dropdown starts -->
        <div class="btn-group pull-right">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <i class="far fa-user"></i><span class="hidden-sm hidden-xs"> <?= ucfirst(Yii::$app->user->identity->username) ?></span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
<?php echo Html::beginForm(['user/logout'], 'post')."\n";
if (Yii::$app->user->isGuest) { ?>
                <li class="user-menu">
                    <a href="?r=site/index"><i class="far fa-sign-in-alt"></i></i></span>&nbsp;Вход</a>
                </li>
<?php } else { ?>
                <li class="user-menu">
                    <a href="?r=user/widgets"><i class="far fa-puzzle-piece"></i></span>&nbsp;Виджеты</a>
                </li>
                <li class="user-menu">
                    <a href="?r=user/password"><i class="far fa-key"></i></span>&nbsp;Пароль</a>
                </li>
<?php if (Yii::$app->user->identity->username == 'admin') { ?>
                <li class="user-menu">
                    <a href="?r=admin/execute"><i class="far fa-bolt"></i></span>&nbsp;Выполнить</a>
                </li>
<?php } ?>
                <li class="divider"></li>
                <li class="user-menu">
                    <a href="#" onClick="this.parentNode.parentNode.submit(); return false;"><i class="far fa-sign-out-alt"></i> Выход</a>
                </li>
<?php } echo Html::endForm()."\n"; ?>
            </ul>
        </div>
        <!-- user dropdown ends -->
    </div>
</div>
<!-- topbar ends -->

<div class="ch-container">
    <div class="row">
        <!-- left menu starts -->
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">
                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <li>
                            <a class="ajax-link" href="<?= Yii::$app->homeUrl ?>">
                                <i class="fal fa-home"></i><span>&nbsp;Главная</span>
                            </a>
                        </li>
<?php if (!Yii::$app->user->isGuest) { ?>
                        <li class="accordion">
                            <a href="#"><i class="fal fa-sitemap"></i><span>&nbsp;Сеть</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li class = "hidden-xs"><a href="?r=foorplan/index">План&nbsp;помещений</a></li>
                                <li><a href="?r=light/index">Освещение</a></li>
                                <li><a href="?r=tv/index">Телевизоры</a></li>
<?php if ($is_local_ip) { ?>
                                <li class = "hidden-xs"><a href="?r=cctv/index">Видеонаблюдение</a></li>
<?php } if (Yii::$app->user->identity->username == 'admin' ) { ?>
                                <li><a href="?r=devices/index">Все&nbsp;устройства</a></li>
                                <li><a href="?r=sensors/index">Все&nbsp;датчики</a></li>
<?php } ?>
                            </ul>
                        </li>
<?php if (Yii::$app->user->identity->username == 'admin' ) { ?>
                        <li class="accordion">
                            <a href="#"><i class="fal fa-server"></i><span>&nbsp;Сервер</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="?r=server/info">Управление</a></li>
                            </ul>
                        </li>
                        <li class="accordion">
                            <a href="#"><i class="fal fa-cog"></i><span>&nbsp;Настройки</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="?r=admusers/index">Пользователи</a></li>
                                <li><a href="?r=admconfig/index">Конфигурация</a></li>
                                <li><a href="?r=admdevices/index">Устройства</a></li>
                                <li><a href="?r=admsensors/index">Датчики</a></li>
                                <li><a href="?r=admshedule/index">Рассписание</a></li>
                                <li><a href="?r=admscripts/index">Сценарии</a></li>
                            </ul>
                        </li>
                        <li class="accordion">
                            <a href="#"><i class="fal fa-calendar-check"></i><span>&nbsp;Отчеты</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="?r=events/index">События</a></li>
                                <li><a href="?r=messages/index&sort=-time">Сообщения</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="ajax-link" href="?r=help/index">
                                <i class="fal fa-question"></i><span>&nbsp;Справка</span>
                            </a>
                        </li>
<?php }} ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- left menu ends -->
        <div class="container col-lg-10 col-md-9 col-sm-8 col-xs-12">
<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'homeLink' => false,
    'options' => ['class' => 'breadcrumb'],
]) ?>
            
            <div class="site-index">
                <div class="body-content">
                    <div class="row">
                    <!-- content starts -->
<?= $content ?>
                    <!-- content ends -->
                    </div>
                </div>
            </div>
        </div>
        <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">Warning!</h4>
                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
            </div>
        </noscript>
    </div><!--/fluid-row-->
</div><!--/.fluid-container-->

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; MySmartHome 2016-2019</p>
    </div>
</footer>

<?php $this->endBody() ?>

<script>
$(document).ready(function () {
 $('.navbar-toggle').click(function (e) {
  e.preventDefault();
  $('.nav-sm').html($('.navbar-collapse').html());
  $('.sidebar-nav').toggleClass('active');
  $(this).toggleClass('active');
 });

 var $sidebarNav = $('.sidebar-nav');

 $('.accordion > a').click(function (e) {
  e.preventDefault();
  var $ul = $(this).siblings('ul');
  var $li = $(this).parent();
  if ($ul.is(':visible')) $li.removeClass('active');
  else                    $li.addClass('active');
  $ul.slideToggle();
 });
 
 $('ul.main-menu li a').each(function () {
 if ($($(this))[0].href.indexOf("#") < 0 ) {
   var $pos = $($(this))[0].href.indexOf("?r=");
   if ($pos >= 0) {
    $pos = $($(this))[0].href.indexOf("/", $pos);
    if ($pos < 0) { $pos = String(window.location).indexOf("%2F", $pos); }
    if ($($(this))[0].href.substring(0, $pos) == String(window.location).substring(0, $pos)) {
     $(this).parent().addClass('active');
    }
   } else {
    if ($($(this))[0].href == String(window.location)) {
     $(this).parent().addClass('active');
    }
   }
  }
 });
 $('.accordion li.active:first').parents('ul').slideDown();
 docReady();
});
</script>
</html>
<?php $this->endPage() ?>
