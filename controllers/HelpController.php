<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

class HelpController extends Controller
{
    public function actionIndex($page='') // Основная страница раздела
    {
        if (Yii::$app->user->identity->username <> 'admin')
            throw new HttpException(403, 'Необходимы права администратора!');
        switch ($page) :
            case 'general':
                return $this->render('general');
                break;
            case 'events':
                return $this->render('events');
                break;
            case 'scripts':
                return $this->render('scripts');
                break;
            case 'database':
                return $this->render('database');
                break;
            case 'noolite':
                return $this->render('noolite');
                break;
            case 'utils':
                return $this->render('utils');
                break;
            case 'links':
                return $this->render('links');
                break;
            case 'about':
                return $this->render('about');
                break;
            case 'config':
                return $this->render('config');
                break;
            default:
                return $this->render('index');
        endswitch;
    } // actionIndex
}
