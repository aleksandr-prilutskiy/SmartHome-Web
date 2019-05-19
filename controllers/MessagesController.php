<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\Messages;

class MessagesController extends Controller
{
    protected function findModel($id) // Поиск записи в базе данных
    {
        if (Yii::$app->user->identity->username <> 'admin')
            throw new HttpException(403, 'Необходимы права администратора!');
        if (($model = Messages::findOne($id)) !== null) return $model;
        throw new HttpException(404, 'Запрашиваемый объект не существует.');
    } // findModel

    public function actionIndex() // Основная страница раздела
    {
        if (Yii::$app->user->identity->username <> 'admin')
            throw new HttpException(403, 'Необходимы права администратора!');
        $searchModel = new Messages();
        $dataProvider = $searchModel->search([]);
        $dataProvider->pagination->pageSize = 12;
        return $this->render('..\admin\messages\index', [
            'dataProvider' => $dataProvider,
        ]);
    } // actionIndex

    public function actionView($id='') // Просмотр отчета
    {
        if (Yii::$app->user->identity->username <> 'admin')
            throw new HttpException(403, 'Необходимы права администратора!');
        $model = $this->findModel($id);
        $model->readed = 1;
        $model->save();
        return $this->render('..\admin\messages\view', [
            'model' => $model,
        ]);
    } // actionView

    public function actionClean() // Удаление всех отчетов
    {
        if (Yii::$app->user->identity->username <> 'admin')
            throw new HttpException(403, 'Необходимы права администратора!');
        Yii::$app->db->createCommand()->truncateTable('Messages')->execute();
        return $this->redirect(['index']);
    } // actionClean
}
