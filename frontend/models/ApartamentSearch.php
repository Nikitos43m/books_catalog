<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Apartament;

/**
 * ApartamentSearch represents the model behind the search form about `app\models\Apartament`.
 *
 * @property integer $cost_from
 * @property integer $cost_to
 * @property integer $floor_from
 * @property integer $floor_to
 * @property integer $area_from
 * @property integer $area_to
 */
class ApartamentSearch extends Apartament
{
    public $cost_from;
    public $cost_to;

    public $floor_from;
    public $floor_to;

    public $area_from;
    public $area_to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'floor', 'area', 'price', 'user_id', 'cost_from', 'cost_to', 'floor_from','floor_to','area_from','area_to', 'realty_type', 'type_appart', 'otdelka'], 'integer'],
            [['type', 'street', 'house', 'telephone'], 'safe'],
            [['lat', 'lng'], 'number'],
            ['rooms', 'in', 'range' => [1,2,3,4,5,11], 'allowArray' => true]
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
            'pagination' => [
               // 'pageSize' => 4,
            ],
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
            'realty_type' => $this->realty_type,
            //'price' => $this->price,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'user_id' => $this->user_id,
            'type_appart' => $this->type_appart,
            'otdelka' => $this->otdelka
        ]);

       /* if($this->cost_from == null){
            $this->cost_from = 0;
        }*/

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'house', $this->house])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['between', 'price', $this->cost_from, $this->cost_to])
            ->andFilterWhere(['between', 'floor', $this->floor_from, $this->floor_to])
            ->andFilterWhere(['between', 'area', $this->area_from, $this->area_to])

            ->andFilterWhere(['<=', 'price', $this->cost_to])
            ->andFilterWhere(['>=', 'price', $this->cost_from])

            ->andFilterWhere(['<=', 'floor', $this->floor_to])
            ->andFilterWhere(['>=', 'floor', $this->floor_from])

            ->andFilterWhere(['<=', 'area', $this->area_to])
            ->andFilterWhere(['>=', 'area', $this->area_from]);
        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchUser($params, $user)
    {
        $query = Apartament::find()->where(['user_id' => $user]);;

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
    
    public function searchTable($params)
    {
        $query = Apartament::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 3,
            ],
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
