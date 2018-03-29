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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ ['user_id','rooms','area', 'price', 'type', 'street', 'house', 'telephone', 'floor', 'realty_type'], 'required'],
            [ ['lat'], 'required', 'message' => 'Укажите местоположение объекта на карте'],
            [ ['rooms',  'floor', 'area', 'price', 'realty_type', 'count_views', 'type_appart', 'otdelka', 'city_id'], 'number'],
            [ ['lat', 'lng'], 'double'],
            [ ['image'], 'file', 'extensions' => 'png, jpg, gif', 'maxFiles' => 8],
            [ ['image_path'], 'string'],
            [ ['description'], 'string', 'max' => 1000],
            [ ['active'], 'boolean']
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