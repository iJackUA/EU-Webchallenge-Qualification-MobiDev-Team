<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Survey;
use yii\helpers\VarDumper;

/**
 * SearchSurvey represents the model behind the search form about `app\models\Survey`.
 */
class SearchSurvey extends Survey
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'createdBy'], 'integer'],
            [['title', 'desc', 'startDate', 'sendDate', 'expireDate', 'created_at', 'updated_at'], 'safe'],
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
    public function search($params, $usedId = null)
    {
        $query = Survey::find();
        if (!Yii::$app->user->can('Administrator')) {
            $usedId = Yii::$app->getUser()->getId();
        }
        if ($usedId) {
            $query->where(['createdBy' => $usedId]);
        }

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'startDate' => $this->startDate,
            'sendDate' => $this->sendDate,
            'expireDate' => $this->expireDate,
            'createdBy' => $this->createdBy,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'desc', $this->desc]);

        $query->orderBy(['created_at' => SORT_DESC]);

        return $dataProvider;
    }
}
