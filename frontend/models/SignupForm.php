<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $my_appart;
    public $who;
   

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => 'Обязательное поле'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким именем уже есть'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['who', 'required', 'message'=>'Выберите тип аккаунта'],
            
            ['email', 'trim'],
            ['email', 'required', 'message' => 'Введите email'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким email уже есть'],

            ['password', 'required', 'message' => 'Установите пароль'],
            ['password', 'string', 'min' => 6],
            [['my_appart'], 'string']

        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->who = $this->who;
        $user->my_appart = '00';
        $user->setPassword($this->password);
        $user->generateAuthKey();

        
        return $user->save() ? $user : null;
    }
}
