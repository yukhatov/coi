<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ResetPasswordForm extends Model
{
    public $username;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['username'], 'exists'],
        ];
    }

    public function exists($attribute)
    {
        $user = User::findOne(['username' => $this->$attribute]);

        if(!$user){
            $this->addError($attribute, 'User not found');
        }
    }
}
