<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class Sensors extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['id', 'type', 'options'], 'integer'],
            [['topic', 'description', 'units', 'map', 'webpage'], 'safe'],
        ];
    } // rules

    public function scenarios()
    {
        return Model::scenarios();
    } // scenarios

    public function search($params)
    {
        $query = $this::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => new \yii\data\Sort([
                'attributes' => [updated],
            ])
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'topic' => $this->topic,
            'value' => $this->value,
            'units' => $this->units,
            'type' => $this->type,
            'options' => $this->options,
            'updated' => $this->updated,
        ]);
        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'map', $this->map])
            ->andFilterWhere(['like', 'webpage', $this->webpage]);
        return $dataProvider;
    } // search

    public function test_status($code)
    {
        switch ($code) :
            case 'av temperature':  return ($this->options & 0x0001) > 0 ? true : false;
            case 'av humidity':     return ($this->options & 0x0002) > 0 ? true : false;
            case 'ex temperature':  return ($this->options & 0x0004) > 0 ? true : false;
            case 'ex humidity':     return ($this->options & 0x0008) > 0 ? true : false;
            case 'view as chart':   return ($this->options & 0x0100) > 0 ? true : false;
            default:                return false;
        endswitch;
    } // test_status

    public function getMap_icon()
    {
        If (!($pos = strripos($this->map, '@'))) return '';
        return substr($this->map, 0, $pos);
    } // getMap_icon

    public function getMap_pos()
    {
        If (!($pos = strripos($this->map, '@'))) return '';
        return substr($this->map, $pos + 1, strlen($this->map) - $pos - 1);
    } // getMap_pos

    public function getViewmode()
    {
        return $this->test_status('view as chart');
    } // getViewmode

    public function getAv_temperature()
    {
        return $this->test_status('av temperature');
    } // getAv_temperature

    public function getAv_humidity()
    {
        return $this->test_status('av humidity');
    } // getAv_humidity
    
    public function getEx_temperature()
    {
        return $this->test_status('ex temperature');
    } // getEx_temperature

    public function getEx_humidity()
    {
        return $this->test_status('ex humidity');
    } // getEx_humidity
    
    public function getIcon($size='', $id='')
    {
        $img = '';
        $dimension = ' border="0"';
        if ($size != '') $dimension = ' width="'.$size.'" hight="'.$size.'"'.$dimension;
        if ($id != '') $id = 'id="'.$id.'" ';
        if ($this->type == 1) $img = 'thermometer'.$size.'.png';
        if ($this->type == 2) $img = 'humidity'.$size.'.png';
        if (($img != '') && (file_exists(Yii::getAlias('@webroot').'/images/icons/'.$img)))
             $img = 'images\icons\\'.$img;
        else $img = 'images\~.gif';
        return '<img '.$id.'src="'.$img.'"'.$dimension.'>';
    } // getIcon
}