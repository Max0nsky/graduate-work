<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Log;

/**
 * LogAuditSearch represents the model behind the search form of `common\models\Log`.
 */
class LogAuditSearch extends Log
{

    public $ids;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'log_category_id', 'user_id', 'object_id', 'priority', 'damages', 'type', 'date', 'threat_id'], 'integer'],
            [['name', 'description'], 'safe'],
            ['ids', 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Log::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if(!empty($this->ids)){
            $query->andFilterWhere(['in', 'id', $this->ids]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'log_category_id' => $this->log_category_id,
            'user_id' => $this->user_id,
            'object_id' => $this->object_id,
            'threat_id' => $this->threat_id,
            'priority' => $this->priority,
            'damages' => $this->damages,
            'type' => $this->type,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
