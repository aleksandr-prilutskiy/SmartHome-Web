<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\Config;

class AdmconfigController extends Controller
{
    protected function findModel($id='') // Поиск записи в базе данных
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if (($model = Config::findOne($id)) !== null) return $model;
        throw new HttpException(404);
    } // findModel

    protected function checkModel($model) // Коррекция записей после редактирования
    {
        if (substr($model->name, strlen($model->name) - 3) == 'Dir') {
            if (substr($model->data, strlen($model->data) - 1) != '\\') {
                $model->data = $model->data.'\\';
                $model->save();
            }
        }
    } // checkModel

    public function actionIndex($id='') // Редактирование системных переменных
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        $searchModel = new Config();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->get());
        $dataProvider->pagination->pageSize = 12;
        global $min_id, $max_id;
        $min_id = Config::find()->select('id')->min('id');
        $max_id = Config::find()->select('id')->max('id');
        return $this->render('..\admin\config\index', [
            'dataProvider' => $dataProvider,
        ]);
    } // actionIndex

    public function actionAdd() // Добавление записи
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        $model = new Config();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->checkModel($model);
            return $this->redirect(['index', 'id' => $model->id]);
        }
        return $this->render('..\admin\config\update', [
            'title' => 'Добавить системную переменную',
            'model' => $model
        ]);
    } // actionAdd

    public function actionCopy($id='') // Дублирование записи
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $model = new Config();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->checkModel($model);
            return $this->redirect(['index', 'id' => $model->id]);
        }
        $model2copy = $this->findModel($id);
        $model->name = $model2copy->name;
        $model->data = $model2copy->data;
        return $this->render('..\admin\config\update', [
            'title' => 'Создание копии системной переменной',
            'model' => $model
        ]);
    } // actionCopy

    public function actionUpdate($id='') // Редактирование записи
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->checkModel($model);
            return $this->redirect(['index', 'id' => $model->id]);
        }
        return $this->render('..\admin\config\update', [
            'title' => 'Редактирование системной переменной',
            'model' => $model,
        ]);
    } // actionUpdate

    public function actionDelete($id='') // Удаление записи
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    } // actionDelete

    public function actionUp($id='') // Смещение записи в списке вверх
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $prev_id = Config::find()
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

    public function actionDown($id='') // Смещение записи в списке вниз
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $next_id = Config::find()
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
