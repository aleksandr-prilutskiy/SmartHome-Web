<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\data\Pagination;
use app\models\Devices;
use app\models\Events;

class AdmdevicesController extends Controller
{
    protected function findModel($id) // Поиск записи в базе данных
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if (($model = Devices::findOne($id)) !== null) return $model;
        throw new HttpException(404);
    } // findModel
    
    protected function checkModel($model) // Коррекция записей после редактирования
    {
        if ($model->id == 1) {
            if ($model->type != 'server') {
                $model->type = 'server';
                $model->save();
            }
        }
        if ($pos = strripos($model->name, ' ')) {
            $model->name = str_replace(' ', '_', $model->name);
            $model->save();
        }
        $request = Yii::$app->request->post();
        if (isset($request['Devices'])) {
            $post = $request['Devices'];
            $options = 0x0000;
            if ($post['option_ping'] == '1')        $options = $options | 0x0001;
            if ($post['option_can_off'] == '1')     $options = $options | 0x0002;
            if ($post['option_can_on'] == '1')      $options = $options | 0x0004;
            if ($post['option_all_off'] == '1')     $options = $options | 0x0008;
            if ($post['option_play_music'] == '1')  $options = $options | 0x0010;
            if ($post['option_play_video'] == '1')  $options = $options | 0x0020;
            $model->options = $options;
            $model->map = '';
            if (($post['map_icon'] != '') || ($post['map_pos'] != ''))
              $model->map = $post['map_icon'].'@'.$post['map_pos'];
            $model->save();
        }
    } // checkModel

    protected function addEventReloadTable() // Запись события принудительной
    { //  перезагрузки таблицы устройств для сервера "Умного дома"
        $newEvent = new Events;
        $newEvent->application = '@';
        $newEvent->command = 'reload';
        $newEvent->parameters = 'devices';
        $newEvent->user = Yii::$app->user->id;
        $newEvent->status = 0;
        $newEvent->save();            
    } // addEventReloadTable
    
    public function actionIndex() // Редактирование спика устройств
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        $model = new Devices();
        $dataProvider = $model->search(Yii::$app->getRequest()->get());
        $dataProvider->pagination->pageSize = 12;
        global $min_id, $max_id;
        $min_id = Devices::find()->select('id')->min('id');
        $max_id = Devices::find()->select('id')->max('id');
        return $this->render('..\admin\devices\index', [
            'dataProvider' => $dataProvider,
        ]);
    } // actionIndex
    
    public function actionAdd() // Добавление устройства
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        $model = new Devices();
        if (($model->load(Yii::$app->request->post())) && ($model->save())) {
            $this->checkModel($model);
            $this->addEventReloadTable();
            return $this->redirect(['index']);
        }
        return $this->render('..\admin\devices\update', [
            'title' => 'Добавить устройство',
            'model' => $model,
        ]);
    } // actionAdd

    public function actionCopy($id='') // Дублирование устройства
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $model = new Devices();
        if (($model->load(Yii::$app->request->post())) && ($model->save())) {
            $this->checkModel($model);
            $this->addEventReloadTable();
            return $this->redirect(['index']);
        }
        $model2copy = $this->findModel($id);
        $model->name = $model2copy->name.'_copy';
        $model->type = $model2copy->type;
        $model->description = $model2copy->description.' (копия)';
        $model->driver = $model2copy->driver;
        $model->addr = $model2copy->addr;
        $model->options = $model2copy->options;
        $model->parameters = $model2copy->parameters;
        $model->image = $model2copy->image;
        $model->webpage = $model2copy->webpage;
        $model->manufacture = $model2copy->manufacture;
        $model->manuals = $model2copy->manuals;
        return $this->render('..\admin\devices\update', [
            'title' => 'Создание копии устройства',
            'model' => $model
        ]);
    } // actionCopy

    public function actionUpdate($id='') // Редактирование информации об устройстве
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $model = $this->findModel($id);
        if (($model->load(Yii::$app->request->post())) && ($model->save())) {
            $this->checkModel($model);
            $this->addEventReloadTable();
            return $this->redirect(['index']);
        }
        return $this->render('..\admin\devices\update', [
            'title' => 'Редактирование информации об устройстве',
            'model' => $model,
        ]);
    } // actionUpdate

    public function actionDelete($id='') // Удаление устройства
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        if ($id == 1) throw new HttpException(403);
        $this->findModel($id)->delete();
        $this->addEventReloadTable();
        return $this->redirect(['index']);
    } // actionDelete

    public function actionUp($id='') // Смещение устройства в списке вверх
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $prev_id = Devices::find()
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

    public function actionDown($id='') // Смещение устройства в списке вниз
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $next_id = Devices::find()
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