<?php
namespace app\models;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

class Commands extends ActiveRecord
{
    public function rules()
    {
        return [
            ['description', 'trim'],
            ['description', 'required'],
            ['description', 'string', 'min' => 3, 'max' => 128],
        ];
    }

    public function getCmdstr()
    {
        $cmdstr = $this->application.' '.$this->command;
        if ($this->device != '') $cmdstr = $cmdstr.' '.$this->device;
        if ($this->parameters != '') $cmdstr = $cmdstr.' '.$this->parameters;
        return $cmdstr;
    } // getCmdstr
   
    public function search($params)
    {
        $query = Commands::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => new \yii\data\Sort([
                'attributes' => ['id'],
            ])
        ]);
        $this->load($params);
        if (!$this->validate()) { return $dataProvider; }
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'command', $this->command]);
        return $dataProvider;
    } // search
}