<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\Devices;
use app\models\Sensors;

class FoorplanController extends Controller
{
    public function actionIndex() // Основная страница раздела
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        $devices = Devices::find()
            ->where('map LIKE \'%@%\'')
            ->andWhere('updated > DATE_SUB(CURDATE(),INTERVAL 1 HOUR)')
            ->all();
        $sensors = Sensors::find()
            ->where('map LIKE \'%@%\'')
            ->andWhere('updated > DATE_SUB(CURDATE(),INTERVAL 1 HOUR)')
            ->all();
        return $this->render('..\network\foorplan\index', [
            'devices' => $devices,
            'sensors' => $sensors,
        ]);
    } // actionIndex

    public function actionSetup() // Редактирование плана помещений
    {
        if (Yii::$app->user->identity->username <> 'admin')
            throw new HttpException(403, 'Необходимы права администратора!');
        $devices = Devices::find()
            ->where('map LIKE \'%@%\'')
            ->all();
        $sensors = Sensors::find()
            ->where('map LIKE \'%@%\'')
            ->all();
        return $this->render('..\network\foorplan\setup', [
            'devices' => $devices,
            'sensors' => $sensors,
        ]);
    } // actionSetup
}