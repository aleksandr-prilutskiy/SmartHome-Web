<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\Devices;
use app\models\Shedule;
use app\models\Events;

class AdmsheduleController extends Controller
{
    protected function findModel($id='') // Поиск записи в базе данных
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if (($model = Shedule::findOne($id)) !== null) return $model;
        throw new HttpException(404);
    } // findModel

    protected function addEventReloadTable() // Запись события принудительной
    { //  перезагрузки таблицы устройств для сервера "Умного дома"
        $newEvent = new Events;
        $newEvent->application = '@';
        $newEvent->command = 'reload';
        $newEvent->parameters = 'shedule';
        $newEvent->user = Yii::$app->user->id;
        $newEvent->status = 0;
        $newEvent->save();            
    } // addEventReloadTable

    public function actionIndex() // Основная страница раздела
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        $searchModel = new Shedule();
        $dataProvider = $searchModel->search([]);
        $dataProvider->pagination->pageSize = 12;
        global $min_id, $max_id;
        $min_id = Shedule::find()->select('id')->min('id');
        $max_id = Shedule::find()->select('id')->max('id');
        return $this->render('..\admin\shedule\index', [
            'dataProvider' => $dataProvider,
            'pagination' => $pagination,
        ]);
    } // actionIndex

    public function actionAdd() // Добавление события по рассписанию
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        $model = new Shedule();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->next_time == '') $model->next_time = date('Y/m/d H:i:00');
            if ($model->save()) {
                $this->addEventReloadTable();
                return $this->redirect(['index', 'id' => $model->id]);
            }
        }
        $model->enable = 1;
        return $this->render('..\admin\shedule\update', [
            'title' => 'Новое событие по рассписанию',
            'model' => $model,
            'devices' => Devices::find()->orderBy('id')->all(),
        ]);
    } // actionAdd

    public function actionCopy($id='') // Дублирование события по рассписанию
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $model = new Shedule();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->next_time == '') $model->next_time = date('Y/m/d H:i:00');
            if ($model->save()) {
                $this->addEventReloadTable();
                return $this->redirect(['index', 'id' => $model->id]);
            }
        }
        $model2copy = $this->findModel($id);
        $model->enable = $model2copy->enable;
        $model->application = $model2copy->application;
        $model->command = $model2copy->command;
        $model->device = $model2copy->device;
        $model->parameters = $model2copy->parameters;
        $model->mode = $model2copy->mode;
        $model->period= $model2copy->period;
        $model->next_time = $model2copy->next_time;
        $model->description = $model2copy->description.' (копия)';
        return $this->render('..\admin\shedule\update', [
            'title' => 'Создание копии события по рассписанию',
            'model' => $model,
            'devices' => Devices::find()->orderBy('id')->all(),
        ]);
    } // actionCopy
    
    public function actionUpdate($id='') // Редактирование события по рассписаниию
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->next_time == '') $model->next_time = date('Y/m/d H:i:00');
            if ($model->save()) {
                $this->addEventReloadTable();
                return $this->redirect(['index', 'id' => $model->id]);
            }
        }
        return $this->render('..\admin\shedule\update', [
            'title' => 'Редактирование события по рассписанию',
            'model' => $model,
            'devices' => Devices::find()->orderBy('id')->all(),
        ]);
    } // actionUpdate

    public function actionDelete($id='') // Удаление события по рассписанию
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $this->findModel($id)->delete();
        $this->addEventReloadTable();
        return $this->redirect(['index']);
    } // actionDelete
    
    public function actionEnable($id='') // Разрешить событие по рассписанию
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $model = $this->findModel($id);
        $model->enable = 1;
        $model->save();
        $this->addEventReloadTable();
        return $this->redirect(['index']);
    } // actionEnable

    public function actionDisable($id='') // Запретить событие по рассписанию
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $model = $this->findModel($id);
        $model->enable = 0;
        $model->save();
        $this->addEventReloadTable();
        return $this->redirect(['index']);
    } // actionDisable

    public function actionUp($id='') // Смещение события по рассписанию в списке вверх
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $prev_id = Shedule::find()
                ->where('id < '.$id)
                ->orderBy('id DESC')
                ->one()
                ->id;
        $model = $this->findModel($id);
        $model->id = 0;
        $model->save();
        $model = $this->findModel($prev_id);
        $model->id = $id;
        $model->save();
        $model = $this->findModel(0);
        $model->id = $prev_id;
        $model->save();
        return $this->redirect(['index']);
    } // actionUp

    public function actionDown($id='') // Смещение события по рассписанию в списке вниз
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $next_id = Shedule::find()
                ->where('id > '.$id)
                ->orderBy('id ASC')
                ->one()
                ->id;
        $model = $this->findModel($id);
        $model->id = 0;
        $model->save();
        $model = $this->findModel($next_id);
        $model->id = $id;
        $model->save();
        $model = $this->findModel(0);
        $model->id = $next_id;
        $model->save();
        return $this->redirect(['index']);
    } // actionDown
}
