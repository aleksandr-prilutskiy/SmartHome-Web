<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class Config extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [[['id'], 'integer'], [['name', 'data'], 'safe']];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Config::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => new \yii\data\Sort([
                'attributes' => ['id'],
            ])
        ]);
        $this->load($params);
        if (!$this->validate()) { return $dataProvider; }
        $query->andFilterWhere(['id' => $this->id]);
        return $dataProvider;
    }

    public function dlna_url()
    {
        $addr = Config::find()->where(['name' => 'ServerAddr'])->one()->data;
        $port = Config::find()->where(['name' => 'PortDLNA'])->one()->data;
        if (($addr == '') || ($port == '')) return '';
        return 'http://'.$addr.':'.$port.'/MediaServer/Playlists/';
    }
    
    public function is_local_ip()
    {
        $netmask = Config::find()->where(['name' => 'LocalNetworkMask'])->one()->data;
        if ($netmask == '') return false;
        return substr($_SERVER["REMOTE_ADDR"], 0, strlen($netmask)) == $netmask;
    }
}
