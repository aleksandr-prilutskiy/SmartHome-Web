<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\data\Pagination;
use app\models\Devices;
use app\models\Events;

class DevicesController extends Controller
{
    public function actionIndex() // Основная страница раздела
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        $model = new Devices();
        $dataProvider = $model->search(Yii::$app->getRequest()->get());
        $dataProvider->pagination->pageSize = 12;
        return $this->render('..\network\devices\index',[
            'dataProvider' => $dataProvider,
        ]);
    } // actionIndex
    
    public function actionInfo($id='') // Информация об устройстве
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        if ($id == "") throw new HttpException(400);
        $device = Devices::find()
            ->where(['id' => $id])
            ->one();
        if ($device->type == 1) return $this->redirect(['/server/info', 'id' => $id]);
        if ($device->type == 2) return $this->redirect(['/light/info', 'id' => $id]);
        if ($device->type == 3) return $this->redirect(['/tv/info', 'id' => $id]);
        return $this->render('..\network\devices\info',[
            'device' => $device,
            'root' => 'devices',
        ]);
    } // actionInfo
}