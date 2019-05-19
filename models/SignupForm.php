<<<<<<< HEAD
<?php
namespace app\models;
use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $description;

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Это имя пользователя уже занято'],
            ['username', 'string', 'min' => 3, 'max' => 32],
            ['password', 'required'],
            ['password', 'string', 'min' => 4],
            ['description', 'string', 'max' => 128],
        ];
    }
 
    public function signup()
    {
        if (!$this->validate()) { return null; }
        $user = new User();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->description = $this->description;
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }
=======
<?php
namespace app\models;
use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $description;

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Это имя пользователя уже занято'],
            ['username', 'string', 'min' => 3, 'max' => 32],
            ['password', 'required'],
            ['password', 'string', 'min' => 4],
            ['description', 'string', 'max' => 128],
        ];
    }
 
    public function signup()
    {
        if (!$this->validate()) { return null; }
        $user = new User();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->description = $this->description;
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }
>>>>>>> 487769b461f1a9002703cc94fb473681f9245e6d
}