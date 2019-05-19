<<<<<<< HEAD
<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\User;
use app\models\Widgets;

class UserController extends Controller
{
    protected function findWidget($id='') // Поиск виджета в базе данных
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if (($model = Widgets::findOne($id)) !== null) return $model;
        throw new HttpException(404);
    } // findWidget

    public function actionWidgets() // Настройка главной страницы для пользователя
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        $searchModel = new Widgets();
        $dataProvider = $searchModel->search(['User_widgets' => ['user_id' => Yii::$app->user->id]]);
        $dataProvider->pagination->pageSize = 12;
        global $min_id, $max_id;
        $min_id = Widgets::find()->select('id')->where(['user_id' => Yii::$app->user->id])->min('id');
        $max_id = Widgets::find()->select('id')->where(['user_id' => Yii::$app->user->id])->max('id');
        return $this->render('..\user\widgets\index', [
            'dataProvider' => $dataProvider,
        ]);
    } // actionWidgets
    
    public function actionAddwidget() // Добавление виджета на главную страницу пользователя
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        $model = new Widgets();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            if ($model->save()) return $this->redirect(['widgets']);
        }
        return $this->render('..\user\widgets\update', [
            'title' => 'Добавить виджет',
            'model' => $model,
        ]);
    } // actionAddwidget

    public function actionWidgetupdate($id='') // Редактирование виджета на главной странице пользователя
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        if ($id == "") throw new HttpException(400);
        $model = $this->findWidget($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            if ($model->save()) return $this->redirect(['widgets']);
        }
        return $this->render('..\user\widgets\update', [
            'title' => 'Редактировать виджет',
            'model' => $model,
        ]);
    } // actionWidgetupdate

    public function actionWidgetdelete($id='') // Удаление виджета с главной страницы пользователя
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        if ($id == "") throw new HttpException(400);
        $this->findWidget($id)->delete();
        return $this->redirect(['widgets']);
    } // actionWidgetdelete

    public function actionWidgetup($id='') // Смещение виджета в списке вверх
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        if ($id == "") throw new HttpException(400);
        $prev_id = Widgets::find()
            ->where('id < '.$id)
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->orderBy('id DESC')
            ->one()
            ->id;
        $model = $this->findWidget($id);
        $model->id = 0;
        $model->save();
        $model = $this->findWidget($prev_id);
        $model->id = $id;
        $model->save();
        $model = $this->findWidget(0);
        $model->id = $prev_id;
        $model->save();
        return $this->redirect(['widgets']);
    } // actionUp

    public function actionWidgetdown($id='') // Смещение виджета в списке вниз
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        if ($id == "") throw new HttpException(400);
        $next_id = Widgets::find()
            ->where('id > '.$id)
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->orderBy('id ASC')
            ->one()
            ->id;
        $model = $this->findWidget($id);
        $model->id = 0;
        $model->save();
        $model = $this->findWidget($next_id);
        $model->id = $id;
        $model->save();
        $model = $this->findWidget(0);
        $model->id = $next_id;
        $model->save();
        return $this->redirect(['widgets']);
    } // actionDown

    public function actionPassword() // Изменение пароля
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        $model = User::find()
            ->where(['id' => Yii::$app->user->id])
            ->one();
        $post = Yii::$app->request->post('User', null);
        if ($post != null) {
            if ($post['password'] != $model->password) {
                $model->setPassword($post['password']);
            }
            if ($model->save()) return $this->redirect(['index']);
        }
        return $this->render('..\user\password', [
            'model' => $model,
        ]);
    } // actionPassword

    public function actionLogout() // Отмена аутентификации пользователя
    {
        Yii::$app->user->logout();
        return $this->goHome();
    } // actionLogout
}
=======
<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\User;
use app\models\Widgets;

class UserController extends Controller
{
    protected function findWidget($id='') // Поиск виджета в базе данных
    {
        if (Yii::$app->user->identity->username <> 'admin') throw new HttpException(403);
        if (($model = Widgets::findOne($id)) !== null) return $model;
        throw new HttpException(404);
    } // findWidget

    public function actionWidgets() // Настройка главной страницы для пользователя
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        $searchModel = new Widgets();
        $dataProvider = $searchModel->search(['User_widgets' => ['user_id' => Yii::$app->user->id]]);
        $dataProvider->pagination->pageSize = 12;
        global $min_id, $max_id;
        $min_id = Widgets::find()->select('id')->where(['user_id' => Yii::$app->user->id])->min('id');
        $max_id = Widgets::find()->select('id')->where(['user_id' => Yii::$app->user->id])->max('id');
        return $this->render('..\user\widgets\index', [
            'dataProvider' => $dataProvider,
        ]);
    } // actionWidgets
    
    public function actionAddwidget() // Добавление виджета на главную страницу пользователя
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        $model = new Widgets();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            if ($model->save()) return $this->redirect(['widgets']);
        }
        return $this->render('..\user\widgets\update', [
            'title' => 'Добавить виджет',
            'model' => $model,
        ]);
    } // actionAddwidget

    public function actionWidgetupdate($id='') // Редактирование виджета на главной странице пользователя
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        if ($id == "") throw new HttpException(400);
        $model = $this->findWidget($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            if ($model->save()) return $this->redirect(['widgets']);
        }
        return $this->render('..\user\widgets\update', [
            'title' => 'Редактировать виджет',
            'model' => $model,
        ]);
    } // actionWidgetupdate

    public function actionWidgetdelete($id='') // Удаление виджета с главной страницы пользователя
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        if ($id == "") throw new HttpException(400);
        $this->findWidget($id)->delete();
        return $this->redirect(['widgets']);
    } // actionWidgetdelete

    public function actionWidgetup($id='') // Смещение виджета в списке вверх
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        if ($id == "") throw new HttpException(400);
        $prev_id = Widgets::find()
            ->where('id < '.$id)
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->orderBy('id DESC')
            ->one()
            ->id;
        $model = $this->findWidget($id);
        $model->id = 0;
        $model->save();
        $model = $this->findWidget($prev_id);
        $model->id = $id;
        $model->save();
        $model = $this->findWidget(0);
        $model->id = $prev_id;
        $model->save();
        return $this->redirect(['widgets']);
    } // actionUp

    public function actionWidgetdown($id='') // Смещение виджета в списке вниз
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        if ($id == "") throw new HttpException(400);
        $next_id = Widgets::find()
            ->where('id > '.$id)
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->orderBy('id ASC')
            ->one()
            ->id;
        $model = $this->findWidget($id);
        $model->id = 0;
        $model->save();
        $model = $this->findWidget($next_id);
        $model->id = $id;
        $model->save();
        $model = $this->findWidget(0);
        $model->id = $next_id;
        $model->save();
        return $this->redirect(['widgets']);
    } // actionDown

    public function actionPassword() // Изменение пароля
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        $model = User::find()
            ->where(['id' => Yii::$app->user->id])
            ->one();
        $post = Yii::$app->request->post('User', null);
        if ($post != null) {
            if ($post['password'] != $model->password) {
                $model->setPassword($post['password']);
            }
            if ($model->save()) return $this->redirect(['index']);
        }
        return $this->render('..\user\password', [
            'model' => $model,
        ]);
    } // actionPassword

    public function actionLogout() // Отмена аутентификации пользователя
    {
        Yii::$app->user->logout();
        return $this->goHome();
    } // actionLogout
}
>>>>>>> 487769b461f1a9002703cc94fb473681f9245e6d
