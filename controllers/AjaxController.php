<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\Devices;
use app\models\Events;
use app\models\Sensors;
use app\models\Media_browsed;
use app\models\Media_favorite;

class AjaxController extends Controller
{
    public function actionDevice($id='', $type='', $state='') // Состояние устройств
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        $devices = Devices::find()
            ->select(['id', 'name', 'type', 'addr', 'state', 'updated'])
            ->where('type = \'server\' OR updated > TIMESTAMP(DATE_SUB(NOW(), INTERVAL 5 minute))');
        if ($id != '') $devices = $devices->andWhere(['id' => $id]);
        if ($type != '') $devices = $devices->andWhere(['type' => $type]);
        if ($state == 'on') $devices = $devices->andWhere('state > 0');
        return $devices->all();
    } // actionDevice
    
    public function actionSensor($topic='') // Состояние датчика
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        $sensors = Sensors::find()
            ->select(['id', 'topic', 'value', 'units', 'updated']);
        if ($topic != '') $sensors = $sensors->andWhere(['topic' => $topic]);
        return $sensors->all();
    } // actionSensor

    public function actionEvent($app='', $cmd='', $device='', $param='') // Вызов события
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        if (((strtolower($app) == "@") || (strtolower($app) == "server")) &&
            (Yii::$app->user->identity->username <> 'admin'))
            throw new HttpException(403);
        if ($cmd == '') throw new HttpException(402);
        if (($app == '') && ($device !== ''))
        {
            $deviceinfo = Devices::find()->where(['name' => $device])->one();
            if ($deviceinfo->type == 2) $app = 'nooLite';
            else $app = $deviceinfo->driver;
        }
        if ($app == '') throw new HttpException(400);
        $newEvent = new Events;
        $newEvent->type = 0;
        $newEvent->application = $app;
        $newEvent->command = $cmd;
        $newEvent->device = $device;
        $newEvent->parameters = $param;
        $newEvent->user = Yii::$app->user->id;
        $newEvent->status = 0;
        if ($newEvent->save()) return 'OK';
        throw new HttpException(500, 'Ошибка базы данных');
    } // actionEvent

    public function actionMarkmediafile($id='') // Отметка медиафайла как просмотренного
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        if ($id == '') throw new HttpException(400);
        $newRecord = new Media_browsed;
        $newRecord->user_id = Yii::$app->user->id;
        $newRecord->dlna_id = $id;
        $newRecord->save();
        if ($newRecord->save()) return 'OK';
        throw new HttpException(520, 'Ошибка в базе данных!');
    } // actionMarkmediafile

    public function actionUnmarkmediafile($id='') // Снятие отметки о просмотре файла
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        if ($id == '') throw new HttpException(400);
        if (Media_browsed::deleteAll(['user_id' => Yii::$app->user->id, 'dlna_id' => $id]) > 0) return 'OK';
        throw new HttpException(520, 'Ошибка в базе данных!');
    } // actionUnmarkmediafile

    public function actionSwitchfavorite($id='') // Отметка медиафайла как избранного
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        if ($id == '') throw new HttpException(400);
        if (Media_favorite::find()->where(['user_id' => Yii::$app->user->id, 'dlna_id' => $id])->count() > 0) {
            if (Media_favorite::deleteAll(['user_id' => Yii::$app->user->id, 'dlna_id' => $id]) > 0) return 'false';
        } else {
            $newRecord = new Media_favorite;
            $newRecord->user_id = Yii::$app->user->id;
            $newRecord->dlna_id = $id;
            $newRecord->save();
            if ($newRecord->save()) return 'true';
            throw new HttpException(520, 'Ошибка в базе данных!');
        }
        throw new HttpException(500, 'Неизвестная ошибка');
    } // actionSwitchfavorite
}
