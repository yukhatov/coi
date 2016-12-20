<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 19.12.16
 * Time: 16:16
 */
namespace app\models;

use Yii;
use yii\base\Model;

class EditUserForm extends Model
{
    public $username;
    public $name;
    public $surname;
    public $birthday;

    private $currentUser;

    public function __construct(User $user = null)
    {
        if($user)
        {
            $this->name = $user->name;
            $this->surname = $user->surname;
            $this->username = $user->username;
            $this->birthday = $user->birthday;

            $this->currentUser = $user;
        }
    }

    public function rules()
    {
        return [
            [['username', 'name', 'surname', 'birthday'], 'safe'],
            [['username'], 'occupied'],
        ];
    }

    public function occupied($attribute)
    {
        $user = User::findOne(['username' => $this->$attribute]);

        if($user and $user->getId() != $this->currentUser->getId()){
            $this->addError($attribute, 'This name is already taken');
        }
    }
}