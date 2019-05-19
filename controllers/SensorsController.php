<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\data\Pagination;
use app\models\Sensors;
use app\models\Sensors_data;
use app\models\Events;

class SensorsController extends Controller
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

    public function actionIndex() // Основная страница раздела
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        $model = new Sensors();
        $dataProvider = $model->search(Yii::$app->getRequest()->get());
        $dataProvider->pagination->pageSize = 12;
        return $this->render('..\network\sensors\index',[
            'dataProvider' => $dataProvider,
        ]);
    } // actionIndex

    public function actionInfo($topic='') // Информация о датчике
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        if ($topic == "") throw new HttpException(400);
        $sensor = Sensors::find()
            ->where(['topic' => $topic])
            ->one();
        $data = Sensors_data::find()
            ->where(['sensor' => $topic])
            ->andWhere('updated <= NOW()')
            ->andWhere('updated > DATE_SUB(NOW(), INTERVAL 12 HOUR)')
            ->orderBy('updated DESC')
            ->all();
        $min = PHP_INT_MAX; $max = 0; $binary = true;
        foreach ($data as $item){
            if ($item->value < $min) $min = $item->value;
            if ($item->value > $max) $max = $item->value;
            if (($item->value != 0) && ($item->value != 1)) $binary = false;
        }
        $range = $max - $min;
        $min = $min - $range / 10;
        $max = $max + $range / 10;
        switch ($sensor->type) {
        case 1: // Датчик температуры
            $min = 0;
            $max = 100;
            $binary = false;
            break;
        case 2: // Датчик влажности
            $min = 0;
            $max = 100;
            $binary = false;
            break;
        }
        if ($binary)
            return $this->render('..\network\sensors\info_table',[
                'title' => $sensor->description,
                'data' => $data,
                'min' => $min,
                'max' => $max,
            ]);
        else
        {
            $data = Sensors_data::find()
                ->where(['sensor' => $topic])
                ->andWhere('updated <= NOW()')
                ->andWhere('updated > DATE_SUB(NOW(), INTERVAL 12 HOUR)')
                ->groupBy(['TIME_TO_SEC(updated) DIV (15*60)'])
                ->orderBy('updated DESC')
                ->all();
            return $this->render('..\network\sensors\info_chart',[
                'title' => $sensor->description,
                'data' => $data,
                'min' => $min,
                'max' => $max,
            ]);
        }
    } // actionInfo

    public function actionClimateinside() // Климат в помещении
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        $temperature = Sensors_data::find()
            ->leftJoin('sensors', 'sensors.topic = sensor')
            ->where('(sensors.options & 0x0001) != 0')
            ->andWhere('sensors_data.updated <= NOW()')
            ->andWhere('sensors_data.updated > DATE_SUB(NOW(), INTERVAL 12 HOUR)')
            ->groupBy(['TIME_TO_SEC(sensors_data.updated) DIV (15*60)'])
            ->orderBy('sensors_data.updated DESC')
            ->all();
        $humidity = Sensors_data::find()
            ->leftJoin('sensors', 'sensors.topic = sensor')
            ->where('(sensors.options & 0x0002) != 0')
            ->andWhere('sensors_data.updated <= NOW()')
            ->andWhere('sensors_data.updated > DATE_SUB(NOW(), INTERVAL 12 HOUR)')
            ->groupBy(['TIME_TO_SEC(sensors_data.updated) DIV (15*60)'])
            ->orderBy('sensors_data.updated DESC')
            ->all();
        return $this->render('..\network\sensors\climateinside',[
            'temperature' => $temperature,
            'humidity' => $humidity,
        ]);
    } // actionClimateinside
    
//=================================================================================================
//=================================================================================================
//=================================================================================================
//=================================================================================================
//=================================================================================================
//=================================================================================================
//=================================================================================================
//=================================================================================================
//=================================================================================================
//=================================================================================================
//=================================================================================================
//=================================================================================================
//=================================================================================================
//=================================================================================================
//=================================================================================================
//=================================================================================================

    public function actionInfoOld($topic='') // Информация о датчике
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        if ($topic == "") throw new HttpException(400);
        $sensor = Sensors::find()
            ->where(['topic' => $topic])
            ->one();
//        $connection = Yii::$app->db;
//        $connection->createCommand("DELETE FROM sensors_data WHERE sensor = '".$topic."' ".
//            "AND updated < DATE_SUB(NOW(), INTERVAL 24 HOUR)")->execute();
        if ($sensor->viewmode == 0 ) {
            $query = Sensors_data::find()
                ->where(['sensor' => $topic]);
            $pagination = new Pagination([
                'defaultPageSize' => 20,
                'totalCount' => $query->count(),
            ]);
            $sensors_data = $query
                ->orderBy('updated DESC')
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
            return $this->render('..\network\sensors\view_as_table',[
                'sensor' => $sensor,
                'sensors_data' => $sensors_data,
                'pagination' => $pagination,
            ]);
        } elseif (($sensor->viewmode == 1 ) && ($sensor->viewrange > 0) && ($sensor->chartstep > 0)) {
            $sensors_data = array();
            for ($i = 0; $i < $sensor->viewrange; $i++) {
                $data = Sensors_data::find()
                    ->where(['sensor' => $topic])
                    ->andWhere('updated <= DATE_SUB(NOW(), INTERVAL '.($i * $sensor->chartstep).' MINUTE)')
                    ->andWhere('updated > DATE_SUB(NOW(), INTERVAL '.(($i + 1) * $sensor->chartstep).' MINUTE)');
                if ($data->count() > 0) array_push($sensors_data, round($data->average('value'), 1));
                else array_push($sensors_data, '');
            }
            return $this->render('..\network\sensors\view_as_chart',[
                'sensor' => $sensor,
                'sensors_data' => $sensors_data,
            ]);
        } else throw new HttpException(404 ,'Установлен неправильный режим просмотра информации от датчика');
    } // actionInfo

    public function actionClimateinsideOld() // Климат в помещении
    {
        if (Yii::$app->user->isGuest) throw new HttpException(401);
        $temperature = array();
        for ($i = 0; $i < 96; $i++) {
            $data = Sensors_data::find()
                ->leftJoin('sensors', 'sensors.topic = sensor')
                ->where('(sensors.options & 0x0001) != 0')
                ->andWhere('sensors_data.updated <= DATE_SUB(NOW(), INTERVAL '.($i * 15).' MINUTE)')
                ->andWhere('sensors_data.updated > DATE_SUB(NOW(), INTERVAL '.(($i + 1) * 15).' MINUTE)');
            if ($data->count() > 0) array_push($temperature, round($data->average('sensors_data.value'), 1));
            else  array_push($temperature, '');
        }
        $humidity = array();
        for ($i = 0; $i < 96; $i++) {
            $data = Sensors_data::find()
                ->leftJoin('sensors', 'sensors.topic = sensor')
                ->where('(sensors.options & 0x0002) != 0')
                ->andWhere('sensors_data.updated <= DATE_SUB(NOW(), INTERVAL '.($i * 15).' MINUTE)')
                ->andWhere('sensors_data.updated > DATE_SUB(NOW(), INTERVAL '.(($i + 1) * 15).' MINUTE)');
            if ($data->count() > 0) array_push($humidity, round($data->average('sensors_data.value'), 1));
            else array_push($humidity, '');
        }
        return $this->render('..\network\sensors\climateinside', [
            'temperature' => $temperature,
            'humidity' => $humidity,
        ]);
    } // actionClimateinside
}
