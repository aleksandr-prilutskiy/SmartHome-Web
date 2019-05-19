<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

class Events extends \yii\db\ActiveRecord
{
    public function getCmdstr()
    {
        $cmdstr = $this->application.' '.$this->command;
        if ($this->device != '') $cmdstr = $cmdstr.' '.$this->device;
        if ($this->parameters != '') $cmdstr = $cmdstr.' '.$this->parameters;
        return $cmdstr;
    } // getCmdstr

    public function rules()
    {
        return [
            ['id', 'integer'],
            ['application', 'string'],
            ['command', 'string'],
            ['device', 'string'],
            ['parameters', 'string'],
            ['user', 'integer'],
            ['status', 'integer'],
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
            'application' => $this->application,
            'command' => $this->command,
            'device' => $this->device,
            'parameters' => $this->parameters,
            'user' => $this->user,
            'status' => $this->status,
            'updated' => $this->updated,
        ]);
        return $dataProvider;
    } // search
    
    public function getUsername()
    {
        if ($this->user == 0) return 'server';
        $artist = User::find()
            ->where(['id' => $this->user])
            ->one();
        return $artist->username;
    } // getUsername
}