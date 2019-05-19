<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class Devices extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            ['id', 'integer'],
            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'unique', 'targetClass' => '\app\models\Devices', 'message' => 'Это имя уже занято.'],
            ['name', 'string', 'min' => 3, 'max' => 32],
            ['type', 'integer'],
            ['description', 'string', 'max' => 128],
            ['driver', 'string'],
            ['addr', 'string'],
            ['options', 'integer'],
            ['state', 'integer'],
            ['parameters', 'string'],
            ['image', 'string'],
            ['map', 'string'],
            ['webpage', 'string'],
            ['manufacture', 'string'],
            ['manuals', 'string'],
            ['updated', 'safe'],
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
            'sort' => new \yii\data\Sort(['attributes' => ['id']])
        ]);
        $this->load($params);
        if (!$this->validate()) return $dataProvider;
        $query->andFilterWhere([
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'driver' => $this->driver,
            'options' => $this->options,
            'state' => $this->state,
            'updated' => $this->updated,
        ]);
        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'addr', $this->addr])
            ->andFilterWhere(['like', 'parameters', $this->parameters])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'map', $this->map])
            ->andFilterWhere(['like', 'webpage', $this->webpage])
            ->andFilterWhere(['like', 'manufacture', $this->manufacture])
            ->andFilterWhere(['like', 'manuals', $this->manuals]);
        return $dataProvider;
    } // search
    
    public function test_status($code)
    {
        switch ($code) :
            case 'ping':            return ($this->options & 0x0001) > 0 ? true : false;
            case 'can off':         return ($this->options & 0x0002) > 0 ? true : false;
            case 'can on':          return ($this->options & 0x0004) > 0 ? true : false;
            case 'all off':         return ($this->options & 0x0008) > 0 ? true : false;
            case 'play music':      return ($this->options & 0x0010) > 0 ? true : false;
            case 'play video':      return ($this->options & 0x0020) > 0 ? true : false;
            default:                return false;
        endswitch;
    } // test_status

    public function getMap_icon()
    {
        if (!($pos = strripos($this->map, '@'))) return '';
        return substr($this->map, 0, $pos);
    } // getMap_icon

    public function getMap_pos()
    {
        if (!($pos = strripos($this->map, '@'))) return '';
        return substr($this->map, $pos + 1, strlen($this->map) - $pos - 1);
    } // getMap_pos

    public function getOption_ping()
    {
        return $this->test_status('ping');
    } // getOption_ping

    public function getOption_can_off()
    {
        return $this->test_status('can off');
    } // getOption_can_off

    public function getOption_can_on()
    {
        return $this->test_status('can on');
    } // getOption_can_on

    public function getOption_all_off()
    {
        return $this->test_status('all off');
    } // getOption_all_off

    public function getOption_play_music()
    {
        return $this->test_status('play music');
    } // getOption_play_music
    
    public function getOption_play_video()
    {
        return $this->test_status('play video');
    } // getOption_play_video

    public function getIcon($size='', $id='')
    {
        $img = '';
        $dimension = ' border="0"';
        if ($size != '') $dimension = ' width="'.$size.'" hight="'.$size.'"'.$dimension;
        if ($id != '') $id = 'id="'.$id.'" ';
        if ($this->type == 1) $img = 'server'.$size.'.png';
        if ($this->type == 2) $img = 'bulb'.$size.'.png';
        if ($this->type == 3) $img = 'tv'.$size.'.png';
        if ($this->type == 4) $img = 'webcam'.$size.'.png';
        if ($this->type == 5) $img = 'arduino'.$size.'.png';
        if (($img != '') && (file_exists(Yii::getAlias('@webroot').'/images/icons/'.$img)))
             $img = 'images\icons\\'.$img;
        else $img = 'images\~.gif';
        return '<img '.$id.'src="'.$img.'"'.$dimension.'>';
    } // getIcon
}
