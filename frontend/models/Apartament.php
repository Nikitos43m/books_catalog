<?php

namespace app\models;

use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "apartament".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property string $street
 * @property string $house
 * @property integer $rooms
 * @property integer $floor
 * @property double $area
 * @property integer $price
 * @property string $telephone
 * @property double $lat
 * @property double $lng
 * @property string $image_path
 * @property string $description
 * @property boolean $active
 * @property integer $realty_type
 * $property integer $count_views
 * $property integer type_appart
 * $property integer otdelka
 * $property integer city_id
 * $property integer term
 * $property integer floor_all
 * $property integer year
 * @property integer $san_uzel
 * @property integer $kitchen
 * @property integer $material
 * @property integer $balkon
 * @property boolean $ipoteka
 */ 
class Apartament extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'apartament';
    }
    
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','rooms', 'floor',  'price', 'realty_type', 'count_views', 'type_appart', 'otdelka',
              'city_id', 'term', 'floor_all', 'year', 'san_uzel', 'kitchen', 'material', 'balkon'], 'integer'],
            [['area'], 'double'],
            [['lat', 'lng'], 'number'],
            [['type', 'street', 'house', 'telephone'], 'string', 'max' => 100],
            [['image_path'], 'string'],
            [['description'], 'string', 'max' => 1000],
            [['active', 'ipoteka'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип объявления',
            'street' => 'Улица',
            'house' => 'Дом',
            'rooms' => 'Количество комнат',
            'floor' => 'Этаж',
            'floor_all' => 'Этажей в доме',
            'year' => 'Год постройки',
            'area' => 'Площадь',
            'price' => 'Цена',
            'telephone' => 'Контактный телефон',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'user_id' => 'Пользователь',
            'image_path' => 'Путь к фотографиям',
            'active' => 'Активность',
            'description' => 'Описание',
            'realty_type' => 'Тип недвижимости',
            'count_views' => 'Просмотров',
            'type_appart' => 'Типо дома',
            'otdelka' => 'Отделка',
            'city_id' => 'Город',
            'term' => 'Срок сдачи',
            'san_uzel' => 'Сан-узел',
            'kitchen' => 'Площадь кухни',
            'material' => 'Тип дома',
            'balkon' => 'Балкон/лоджия',
            'ipoteka' => 'Возможна ипотека'
           
         
        ];
    }

    /**
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
 * @return \yii\db\ActiveQuery
 */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getAuthorId()
    {
        return $this->user_id;    
    }


    public function getCountViews()
    {
        return $this->count_views;
    }

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
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeAccount($id)
    {
        //получить User, затем у этого User получить тип аккаунта
        $user = User::findById($id);
        $type_account = $user->who;
        return $type_account;
    }

}
