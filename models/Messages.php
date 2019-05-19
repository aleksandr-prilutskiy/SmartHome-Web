<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class Messages extends \yii\db\ActiveRecord
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
        return [[['id'], 'integer'],
                [['creator', 'event', 'description', 'error', 'logfile', 'readed'], 'safe']];
    } // rules

    public function scenarios()
    {
        return Model::scenarios();
    } // scenarios

    public function search($params)
    {
        $query = Messages::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $this->load($params);
        if (!$this->validate()) { return $dataProvider; }
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'creator', $this->creator])
            ->andFilterWhere(['like', 'event', $this->event])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'error', $this->error])
            ->andFilterWhere(['like', 'logfile', $this->logfile])
            ->andFilterWhere(['like', 'readed', $this->readed]);
        return $dataProvider;
    } // search
}