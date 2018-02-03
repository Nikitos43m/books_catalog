<?php
namespace frontend\models;

use yii\base\Model;
use app\models\Apartament;

/**
 * Apatament form
 */
class ApartamentForm extends Model
{
    public $rooms;
    public $floor;
    public $area;
    public $price;
    public $lat;
    public $lng;
    public $type;
    public $street;
    public $house;
    public $telephone;
    public $user_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','rooms','area', 'price', 'type', 'street', 'house', 'telephone', 'floor'], 'required'],
            [ ['rooms',  'floor', 'area', 'price'], 'number'],
            [ ['lat', 'lng'], 'double'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function save()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $apartament = new Apartament();
        $apartament->rooms = $this->rooms;
        $apartament->floor = $this->floor;
        $apartament->area = $this->area;
        $apartament->price = $this->price;
        $apartament->lat = $this->lat;
        $apartament->lng = $this->lng;
        $apartament->type = $this->type;
        $apartament->street = $this->street;
        $apartament->house = $this->house;
        $apartament->telephone = $this->telephone;
        $apartament->user_id = $this->user_id;

        return $apartament->save() ? $apartament : null;

    }
}