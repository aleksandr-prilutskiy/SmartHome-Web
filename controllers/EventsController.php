<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\Events;

class EventsController extends Controller
{
    public function actionIndex() // Основная страница раздела
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        $searchModel = new Events();
        $dataProvider = $searchModel->search([]);
        $dataProvider->setSort(['defaultOrder' => ['updated'=>SORT_DESC]]);
        $dataProvider->pagination->pageSize = 12;
        return $this->render('..\admin\events\index', [
            'dataProvider' => $dataProvider,
        ]);
    } // actionIndex

    public function actionClean() // Удаление всех записей
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        Yii::$app->db->createCommand()->truncateTable('Events')->execute();
        return $this->redirect(['index']);
    } // actionClean
}
