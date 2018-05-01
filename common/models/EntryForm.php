<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 04.12.2016
 * Time: 14:12
 */

namespace common\models;
use yii\base\Model;

class EntryForm extends Model
{
    public $name;
    public $email;

    public function rules()
    {
        return [
            [['name', 'email'], 'required', 'message' => 'Заполните поле'],
            ['email', 'email'],
        ];
    }
}