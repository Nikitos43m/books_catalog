<?php
namespace frontend\models;

use yii\base\Model;
use app\models\Apartament;
use common\models\User;
use yii\web\UploadedFile;

class CityForm extends Model
{
    public $country;
    public $region;
    public $city;
    
    
     public function rules()
    {
        return [

           // [ ['city',  'region', 'country'], 'number'],
        ];
    }
    
    
}