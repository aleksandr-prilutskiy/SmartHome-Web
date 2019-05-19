<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\Devices;

class ServerController extends Controller
{
    public function actionInfo() // Информация об устройстве
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        $device = Devices::find()
            ->where(['type' => 1])
            ->one();
        return $this->render('..\server\info',[
            'device' => $device,
            'root' => 'devices',
        ]);
    } // actionInfo

    public function actionShutdown() // Выключение сервера
    {
        if (Yii::$app->user->identity->username <> 'admin')
            throw new HttpException(403, 'Необходимы права администратора!');
        $this->layout = '@app/views/layouts/empty.php';
        return $this->render('shutdown');
    } // actionShutdown

    public function actionReboot() // Перезагрузка сервера
    {
        if (Yii::$app->user->identity->username <> 'admin')
            throw new HttpException(403, 'Необходимы права администратора!');
        $this->layout = '@app/views/layouts/empty.php';
        return $this->render('reboot');
    } // actionReboot
}
