<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Apartament;

/**
 * ApartamentSearch represents the model behind the search form about `app\models\Apartament`.
 */
class ApartamentSearch extends Apartament
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'rooms', 'floor', 'area', 'price', 'user_id'], 'integer'],
            [['type', 'street', 'house', 'telephone'], 'safe'],
            [['lat', 'lng'], 'number'],
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
        $query = Apartament::find();

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
            'rooms' => $this->rooms,
            'floor' => $this->floor,
            'area' => $this->area,
            'price' => $this->price,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'house', $this->house])
            ->andFilterWhere(['like', 'telephone', $this->telephone]);

        return $dataProvider;
    }
}
