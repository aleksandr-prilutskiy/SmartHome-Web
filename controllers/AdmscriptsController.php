<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\Devices;
use app\models\Events;
use app\models\Scripts;

class AdmscriptsController extends Controller
{
    protected function findModel($id) // Поиск записи в базе данных
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if (($model = Scripts::findOne($id)) !== null) return $model;
        throw new HttpException(404);
    } // findModel

    protected function addEventReloadTable() // Запись события принудительной
    { //  перезагрузки таблицы сценариев для сервера обработки событий
        $newEvent = new Events;
        $newEvent->application = '@';
        $newEvent->command = 'reload';
        $newEvent->parameters = 'scripts';
        $newEvent->user = Yii::$app->user->id;
        $newEvent->status = 0;
        $newEvent->save();            
    } // addEventReloadTable
    
    public function actionIndex() // Основная страница раздела
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        $searchModel = new Scripts();
        $dataProvider = $searchModel->search([]);
        $dataProvider->pagination->pageSize = 12;
        return $this->render('..\admin\scripts\index', [
            'dataProvider' => $dataProvider,
        ]);
    } // actionIndex

    public function actionAdd() // Добавление сценария
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        $model = new Scripts();
        if (($model->load(Yii::$app->request->post())) && ($model->save())) {
            $this->addEventReloadTable();
            return $this->redirect(['index', 'id' => $model->id]);
        }
        $model->enable = 1;
        return $this->render('..\admin\scripts\update', [
            'title' => 'Новый сценарий',
            'model' => $model,
            'devices' => Devices::find()->orderBy('id')->all(),
        ]);
    } // actionAdd

    public function actionCopy($id='') // Дублирование сценария
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $model = new Scripts();
        if (($model->load(Yii::$app->request->post())) && ($model->save())) {
            $this->addEventReloadTable();
            return $this->redirect(['index', 'id' => $model->id]);
        }
        $model2copy = $this->findModel($id);
        $model->enable = $model2copy->enable;
        $model->rules = $model2copy->rules;
        $model->application = $model2copy->application;
        $model->command = $model2copy->command;
        $model->device = $model2copy->device;
        $model->parameters = $model2copy->parameters;
        $model->delay = $model2copy->delay;
        $model->timeout= $model2copy->timeout;
        $model->description = $model2copy->description.' (копия)';
        return $this->render('..\admin\scripts\update', [
            'title' => 'Создание копии сценария',
            'model' => $model,
            'devices' => Devices::find()->orderBy('id')->all(),
        ]);
    } // actionCopy

    public function actionUpdate($id='') // Редактирование сценария
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $model = $this->findModel($id);
        if (($model->load(Yii::$app->request->post())) && ($model->save())) {
            $this->addEventReloadTable();
            $this->redirect(['index', 'id' => $model->id]);
        }
        return $this->render('..\admin\scripts\update', [
            'title' => 'Редактирование сценария',
            'model' => $model,
            'devices' => Devices::find()->orderBy('id')->all(),
        ]);
    } // actionUpdate

    public function actionDelete($id='') // Удаление сценария
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $this->findModel($id)->delete();
        $this->addEventReloadTable();
        return $this->redirect(['index']);
    } // actionDelete

    public function actionEnable($id='') // Разрешить сценарий
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $model = $this->findModel($id);
        $model->enable = 1;
        $model->save();
        $this->addEventReloadTable();
        return $this->redirect(['index']);
    } // actionEnable

    public function actionDisable($id='') // Запретить сценарий
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $model = $this->findModel($id);
        $model->enable = 0;
        $model->save();
        $this->addEventReloadTable();
        return $this->redirect(['index']);
    } // actionDisable


    public function actionUp($id='') // Смещение сценария в списке вверх
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $prev_id = Scripts::find()
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

    public function actionDown($id='') // Смещение сценария в списке вниз
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $next_id = Scripts::find()
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
