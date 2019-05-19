<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\data\Pagination;
use app\models\Sensors;
use app\models\Sensors_data;
use app\models\Events;

class AdmsensorsController extends Controller
{
    protected function findModel($id) // Поиск записи в базе данных
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if (($model = Sensors::findOne($id)) !== null) return $model;
        throw new HttpException(404);
    } // findModel

    protected function checkModel($model) // Коррекция записей после редактирования
    {
        $request = Yii::$app->request->post();
        if (isset($request['Sensors'])) {
            $post = $request['Sensors'];
            $options = 0x0000;
            if ($post['av_temperature'] == '1')     $options = $options | 0x0001;
            if ($post['av_humidity'] == '1')        $options = $options | 0x0002;
            if ($post['ex_temperature'] == '1')     $options = $options | 0x0004;
            if ($post['ex_humidity'] == '1')        $options = $options | 0x0008;
            if ($post['viewmode'] == '1')           $options = $options | 0x0100;
            $model->options = $options;
            $model->map = '';
            if (($post['map_icon'] != '') || ($post['map_pos'] != ''))
              $model->map = $post['map_icon'].'@'.$post['map_pos'];
            $model->save();
        }
    } // checkModel

    protected function newTopic() // Генерация имени тописка MQTT
    {
        while (true) {
            $max = 9;
            $topic = '';
            for ($i = 0; $i < 6; $i++) {
                $n = rand(1, $max);
                if ($n < 10) {
                    $topic = $topic.chr($n + 48);
                    $max = 35;
                } elseif ($n < 36) {
                    $topic = $topic.chr($n + 55);
                    $max = 9;
                } else {
                    $topic = $topic.'_';
                    $max = 9;
                }
            }
            if (Sensors::find()->where(['topic' => $topic])->count() == 0) break;
        }
        return str_replace('O', '0', $topic);
    } // newTopic

    protected function addEventReloadTable() // Запись события принудительной
        { //  перезагрузки таблицы датчиков для сервера "Умного дома"
        $newEvent = new Events;
        $newEvent->application = '@';
        $newEvent->command = 'reload';
        $newEvent->parameters = 'sensors';
        $newEvent->user = Yii::$app->user->id;
        $newEvent->status = 0;
        $newEvent->save();            
    } // addEventReloadTable

    public function actionIndex() // Редактирование спика датчиков
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        $model = new Sensors();
        $dataProvider = $model->search(Yii::$app->getRequest()->get());
        $dataProvider->pagination->pageSize = 12;
        global $min_id, $max_id;
        $min_id = Sensors::find()->select('id')->min('id');
        $max_id = Sensors::find()->select('id')->max('id');
        return $this->render('..\admin\sensors\index', [
            'dataProvider' => $dataProvider,
        ]);
    } // actionIndex

    public function actionAdd() // Добавление датчика
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        $model = new Sensors();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->checkModel($model);
            $this->addEventReloadTable();
            return $this->redirect(['index']);
        }
        $model->topic = $this->newTopic();
        return $this->render('..\admin\sensors\update', [
            'title' => 'Новый датчик',
            'model' => $model,
        ]);
    } // actionAdd

    public function actionCopy($id='') // Дублирование датчика
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $model = new Sensors();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->checkModel($model);
            $this->addEventReloadTable();
            return $this->redirect(['index']);
        }
        $model2copy = $this->findModel($id);
        $model->topic = $this->newTopic();
        $model->type= $model2copy->type;
        $model->units = $model2copy->units;
        $model->options = $model2copy->options;
        $model->min = $model2copy->min;
        $model->max = $model2copy->max;
        $model->viewrange = $model2copy->viewrange;
        $model->chartstep = $model2copy->chartstep;
        $model->webpage = $model2copy->webpage;
        $model->description = $model2copy->description.' (копия)';
        return $this->render('..\admin\sensors\update', [
            'title' => 'Создание копии датчика',
            'model' => $model
        ]);
    } // actionCopy

    public function actionUpdate($id='') // Редактирование информации о датчике
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->checkModel($model);
            $this->addEventReloadTable();
            return $this->redirect(['index']);
        }
        if ($model->topic == '') $model->topic = $this->newTopic();
        return $this->render('..\admin\sensors\update', [
            'title' => 'Редактирование информации о датчике',
            'model' => $model,
        ]);
    } // actionUpdate

    public function actionDelete($id='') // Удаление датчика
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $this->findModel($id)->delete();
        $this->addEventReloadTable();
        return $this->redirect(['index']);
    } // actionDelete

    public function actionUp($id='') // Смещение датчика в списке вверх
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $prev_id = Sensors::find()
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

    public function actionDown($id='') // Смещение датчика в списке вниз
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $next_id = Sensors::find()
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
