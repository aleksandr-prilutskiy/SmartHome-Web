<?php
use yii\helpers\Html;
if ($name == 'Bad Request (#400)') $message = 'Объект не указан или не найден.';
if ($name == 'Unauthorized (#401)') $message = 'Необходима авторизация пользователя.';
if ($name == 'Forbidden (#403)') $message = 'Недостаточно прав для доступа.';
if ($name == 'Not Found (#404)') $message = 'Не найдено. Нет страницы, соотвествующей Вашему запросу.';
$this->title = $name;
?>
<div class="site-error">
<?php if ($name != 'OK (#200)') { ?>
    <h1><?= Html::encode($this->title) ?></h1>
<?php } ?>
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>
<?php if ($name != 'OK (#200)') { ?>
    <p>
       Указанная ошибка произошла во время обработки веб-сервером вашего запроса.
    </p>
<?php } ?>
</div>
