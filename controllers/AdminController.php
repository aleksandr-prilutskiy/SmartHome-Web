<<<<<<< HEAD
<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\Commands;
use app\models\Events;

class AdminController extends Controller
{
    public function actionExecute($id='') // Список команд администратора
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id != "") {
            $command = Commands::find()
                    ->where(['id' => $id])
                    ->one();
            $newEvent = new Events;
            $newEvent->type = 0;
            $newEvent->application = $command->application;
            $newEvent->command = $command->command;
            $newEvent->device = $command->device;
            $newEvent->parameters = $command->parameters;
            $newEvent->user = Yii::$app->user->id;
            $newEvent->save();
        }
        $searchModel = new Commands();
        $dataProvider = $searchModel->search([]);
        $dataProvider->pagination->pageSize = 12;
        return $this->render('..\admin\execute\index', [
            'dataProvider' => $dataProvider,
        ]);
    } // actionIndex
}
=======
<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\Commands;
use app\models\Events;

class AdminController extends Controller
{
    public function actionExecute($id='') // Список команд администратора
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if ($id != "") {
            $command = Commands::find()
                    ->where(['id' => $id])
                    ->one();
            $newEvent = new Events;
            $newEvent->type = 0;
            $newEvent->application = $command->application;
            $newEvent->command = $command->command;
            $newEvent->device = $command->device;
            $newEvent->parameters = $command->parameters;
            $newEvent->user = Yii::$app->user->id;
            $newEvent->save();
        }
        $searchModel = new Commands();
        $dataProvider = $searchModel->search([]);
        $dataProvider->pagination->pageSize = 12;
        return $this->render('..\admin\execute\index', [
            'dataProvider' => $dataProvider,
        ]);
    } // actionIndex
}
>>>>>>> 487769b461f1a9002703cc94fb473681f9245e6d
