<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\Devices;

class LightController extends Controller
{
    public function actionIndex() // Основная страница раздела
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        $devices = Devices::find()
            ->where(['type' => 2])
            ->orderBy('id')
            ->all();
        if (count($devices) == 0 )
            throw new HttpException(200, "Нет устройств освещения. Проверте настройки стстемы.");
        return $this->render('..\network\light\index',[
            'devices' => $devices,
        ]);
    } // actionIndex
    
    public function actionInfo($id='') // Информация об устройстве
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        if ($id == "") throw new HttpException(400);
        $device = Devices::find()
            ->where(['id' => $id])
            ->one();
        $device->manufacture = 'http://noolite.ru/catalog/silovye_bloki/vyklyuchatel_radioupravlyaemyy_noolite_suf_1_300/';
        return $this->render('..\network\light\info',[
            'device' => $device,
            'root' => 'devices',
        ]);
    } // actionInfo
}