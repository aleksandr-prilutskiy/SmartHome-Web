<?php
namespace app\models;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

class Widgets extends ActiveRecord
{
    public function rules()
    {
        return [[['id', 'user_id'], 'integer'],
                [['widget', 'parameters'], 'safe']];
    } // rules

    public function search($params)
    {
        $query = Widgets::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => new \yii\data\Sort([
                'attributes' => ['id'],
            ])
        ]);
        $this->load($params);
        if (!$this->validate()) { return $dataProvider; }
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['user_id' => $this->user_id]);
        $query->andFilterWhere(['like', 'widget', $this->widget]);
        $query->andFilterWhere(['like', 'parameters', $this->parameters]);
        return $dataProvider;
    } // search
}