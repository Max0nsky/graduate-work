<?php

namespace common\models\search;

use common\models\ObjectSystem;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * ObjectSystemSearch represents the model behind the search form of `common\models\Country`.
 */
class ObjectSystemSearch extends ObjectSystem
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'safe'],
            [['description'], 'safe'],
            [['priority'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
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
        $query = ObjectSystem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'description', $this->description]);
        $query->andFilterWhere(['=', 'priority', $this->priority]);

        return $dataProvider;
    }
}