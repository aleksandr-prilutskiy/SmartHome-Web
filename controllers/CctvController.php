<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\Devices;

class CctvController extends Controller
{
    public function actionIndex() // Основная страница раздела
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        $devices = Devices::find()
            ->where(['type' => 4])
            ->andWhere('state > 0')
            ->andWhere('parameters <> \'\'')
            ->orderBy('id')
            ->all();
        if (count($devices) == 0 )
            throw new HttpException(200, "Камеры видеонаблюдения не установлены не настроены или отключены.");
        return $this->render('..\network\cctv\index',[
            'devices' => $devices,
        ]);
    } // actionIndex
}