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
 * @property integer $area
 * @property integer $price
 * @property string $telephone
 * @property double $lat
 * @property double $lng
 * @property string $image_path
 * @property string $description
 * @property boolean $active
 * @property integer $realty_type
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
            [['user_id','rooms', 'floor', 'area', 'price', 'realty_type'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['type', 'street', 'house', 'telephone'], 'string', 'max' => 100],
            [['image_path'], 'string'],
            [['description'], 'string', 'max' => 1000],
            [['active'], 'boolean']
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
            'area' => 'Площадь',
            'price' => 'Цена',
            'telephone' => 'Телефон',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'user_id' => 'Пользователь',
            'image_path' => 'Путь к фотографиям',
            'active' => 'Активность',
            'description' => 'Описание',
            'realty_type' => 'Тип недвижимости'
         
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
