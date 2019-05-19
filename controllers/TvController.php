<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\Devices;

class TvController extends Controller
{
    public function actionIndex() // Основная страница раздела
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        $devices = Devices::find()
            ->where(['type' => 3])
            ->orderBy('id')
            ->all();
        if (count($devices) == 0 )
            throw new HttpException(200, "Телевизоры не установлены или не настроены.");
        return $this->render('..\network\tv\index',[
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
        return $this->render('..\network\tv\info',[
            'device' => $device,
            'root' => 'devices',
        ]);
    } // actionInfo
}