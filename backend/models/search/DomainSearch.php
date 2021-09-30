<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Domain;

/**
 * DomainSearch represents the model behind the search form about `backend\models\Domain`.
 */
class DomainSearch extends Domain
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'traffic', 'traffic_season', 'project_stage', 'profit_await', 'evaluate_min', 'evaluate_middle', 'evaluate_max', 'domain_age', 'IKS', 'articles_num', 'index_Y', 'index_G'], 'integer'],
            [['domain', 'organic', 'direct', 'effectiveness', 'CMS'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Domain::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'traffic' => $this->traffic,
            'traffic_season' => $this->traffic_season,
            'project_stage' => $this->project_stage,
            'profit_await' => $this->profit_await,
            'evaluate_min' => $this->evaluate_min,
            'evaluate_middle' => $this->evaluate_middle,
            'evaluate_max' => $this->evaluate_max,
            'domain_age' => $this->domain_age,
            'IKS' => $this->IKS,
            'articles_num' => $this->articles_num,
            'index_Y' => $this->index_Y,
            'index_G' => $this->index_G,
        ]);

        $query->andFilterWhere(['like', 'domain', $this->domain])
            ->andFilterWhere(['like', 'organic', $this->organic])
            ->andFilterWhere(['like', 'direct', $this->direct])
            ->andFilterWhere(['like', 'effectiveness', $this->effectiveness])
            ->andFilterWhere(['like', 'CMS', $this->CMS]);

        return $dataProvider;
    }
}
