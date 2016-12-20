<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 19.12.16
 * Time: 12:22
 */
namespace app\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $username;
    public $password;
    public $name;
    public $surname;
    public $birthday;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['name', 'surname', 'birthday'], 'safe'],
            [['username'], 'occupied'],
            [['username'], 'validLogin'],
            [['password'], 'validPassword'],
        ];
    }

    public function occupied($attribute)
    {
        $user = User::findOne(['username' => $this->$attribute]);

        if($user){
            $this->addError($attribute, 'This name is already taken');
        }
    }

    public function validPassword($attribute)
    {
        if (!preg_match('/([A-Za-z0-9]{8,})/', $this->$attribute)) {
            $this->addError($attribute, 'To short');
        }
    }

    public function validLogin($attribute)
    {
        if (!preg_match('/(.+@.+)/', $this->$attribute)) {
            $this->addError($attribute, 'example@gmail.com');
        }
    }
}