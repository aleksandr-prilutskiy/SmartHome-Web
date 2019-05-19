<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\User;
use app\models\Widgets;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' =>
                ['class' => AccessControl::className(),
                 'only' => ['logout'],
                 'rules' =>
                    [['actions' => ['logout'],
                      'allow' => true,
                      'roles' => ['@']]
                    ],
                ],
            'verbs' =>
                ['class' => VerbFilter::className(),
                 'actions' => ['logout' => ['post']],
                ],
        ];
    } // behaviors

    public function actions()
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    } // actions

    public function actionIndex() // Главная страница сайта
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login())
                return $this->goBack();
            $this->layout = '@app/views/layouts/empty.php';
            return $this->render('login', ['model' => $model]);
        }
        $widgets = Widgets::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->orderBy('id')
            ->all();
        return $this->render('index', [
            'widgets' => $widgets,
        ]);
    } // actionIndex
}
