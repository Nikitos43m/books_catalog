<?php
namespace frontend\models;

use yii\base\Model;
use app\models\Apartament;
use common\models\User;
use yii\web\UploadedFile;
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
    public $image;
    public $image_path;
    public $active;
    public $description;
    public $realty_type;
    public $count_views;
    public $type_appart;
    public $otdelka;
    public $city_id;
    public $term;
    public $floor_all; 
    public $year;
    public $san_uzel;
    public $kitchen;
    public $material;
    public $balkon;
    public $ipoteka;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ ['user_id','rooms','area', 'price', 'type', 'street', 'house', 'telephone', 'floor', 'realty_type'], 'required', 'message' => 'Заполните поле'],
            [ ['lat'], 'required', 'message' => 'Укажите местоположение объекта на карте'],
            [ ['rooms',  'floor', 'price', 'realty_type', 'count_views', 'type_appart', 'otdelka', 'city_id', 'san_uzel','term', 'floor_all', 'year', 'kitchen', 'material', 'balkon'], 'number'],
            [ ['lat', 'lng'], 'double'],
            [ ['area'], 'double', 'message' => 'Дробные значения указываются через точку'],
            [ ['image'], 'file', 'extensions' => 'png, jpg, gif', 'maxFiles' => 8],
            [ ['image_path'], 'string'],
            [ ['description'], 'string', 'max' => 1000],
            [ ['active', 'ipoteka'], 'boolean']
        ];
    }

    public function upload(){
       if($this->validate()){
           //var_dump($this->image);
           //$this->image->saveAs("uploads/{$this->image->baseName}.{$this->image->extension}");

       }else{
           return false;
       }
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
        $apartament->image_path = $this->image_path;
        $apartament->description = $this->description;
        $apartament->realty_type = $this->realty_type;
        $apartament->active = $this->active;
        $apartament->count_views = $this->count_views;
        $apartament->type_appart = $this->type_appart;
        $apartament->otdelka = $this->otdelka;
        $apartament->city_id = $this->city_id;
        $apartament->term = $this->term;
        $apartament->floor_all = $this->floor_all;
        $apartament->year = $this->year;
        $apartament->san_uzel = $this->san_uzel;
        $apartament->kitchen = $this->kitchen;
        $apartament->material = $this->material;
        $apartament->balkon = $this->balkon;
        $apartament->ipoteka = $this->ipoteka;
        
        return $apartament->save() ? $apartament : null;

    }
    
    
    // Уже не нужна
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsername($id)
    {
        //получить User, затем у этого User получить username
        $user = User::findById($id);
        $username = $user->username;
        return $username;
    }
}