<?php
namespace app\models;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\data\ActiveDataProvider;

class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
 
    public static function tableName()
    {
        return '{{%user}}';
    }
 
    public function behaviors()
    {
        return [TimestampBehavior::className()];
    }
 
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }
 
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
 
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
 
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
 
    public function getId()
    {
        return $this->getPrimaryKey();
    }
 
    public function getAuthKey()
    {
        return $this->auth_key;
    }
 
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
 
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
 
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
 
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function search($params)
    {
        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => new \yii\data\Sort([
                'attributes' => ['id'],
            ])
        ]);
        $this->load($params);
        if (!$this->validate()) { return $dataProvider; }
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'username', $this->username]);
        return $dataProvider;
    }
}
