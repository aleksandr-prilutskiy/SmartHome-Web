<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
	
class Scripts extends \yii\db\ActiveRecord
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
            ['enable', 'integer'],
            ['rules', 'string'],
            ['application', 'string'],
            ['command', 'string'],
            ['device', 'string'],
            ['parameters', 'string'],
            ['delay', 'integer'],
            ['timeout', 'integer'],
            ['description', 'string'],
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
            'enable' => $this->enable,
            'rules' => $this->rules,
            'application' => $this->application,
            'command' => $this->command,
            'device' => $this->device,
            'delay' => $this->delay,
            'timeout' => $this->timeout,
            'parameters' => $this->parameters,
        ]);
        $query->andFilterWhere(['like', 'description', $this->description]);
        return $dataProvider;
    } // search
}
