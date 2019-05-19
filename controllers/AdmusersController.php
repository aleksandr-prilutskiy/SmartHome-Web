<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\User;
use app\models\SignupForm;

class AdmusersController extends Controller
{
    protected function findModel($id) // Поиск записи в базе данных
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if (($model = User::findOne($id)) !== null) return $model;
        throw new HttpException(404);
    } // findModel

    public function actionIndex() // Редактирование спика пользователей
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        $searchModel = new User();
        $dataProvider = $searchModel->search([]);
        $dataProvider->pagination->pageSize = 12;
        return $this->render('..\admin\users\index', [
            'dataProvider' => $dataProvider,
        ]);
    } // actionIndex

    public function actionAdd() // Добавление пользователя
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()))
            if ($user = $model->signup()) return $this->redirect(['index']);
        return $this->render('..\admin\users\update', [
            'title' => 'Новый пользователь',
            'model' => $model,
        ]);
    } // actionAdd
    
    public function actionUpdate($id='') // Редактирование записи пользователя
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $model = $this->findModel($id);
        $post = Yii::$app->request->post('User', null);
        if ($post != null) {
            $model->username = $post['username'];
            if ($post['password'] != $model->password) {
                $model->setPassword($post['password']);
            }
            $model->description = $post['description'];
            if ($model->save()) return $this->redirect(['index']);
        }
        return $this->render('..\admin\users\update', [
            'title' => 'Редактирование пользователя',
            'model' => $model,
        ]);
    } // actionUpdate
    
    public function actionDelete($id='') // Удаление пользователя
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id == "") throw new HttpException(400);
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    } // actionDelete
}
