<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "employees".
 *
 * @property int $clock_number табельный номер
 * @property string $name
 * @property string $second_name
 * @property string $middle_name
 * @property int $boss_clock_number табельный номер начальника
 * @property string $password Пароль
 *
 * @property Employees $bossClockNumber
 * @property Employees $employees
 */
class Employees extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'second_name', 'middle_name', 'boss_clock_number', 'password'], 'required'],
            [['boss_clock_number'], 'integer'],
            [['name', 'second_name', 'middle_name'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
            [['boss_clock_number'], 'unique'],
            [['boss_clock_number'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['boss_clock_number' => 'clock_number']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'clock_number' => 'табельный номер',
            'name' => 'Name',
            'second_name' => 'Second Name',
            'middle_name' => 'Middle Name',
            'boss_clock_number' => 'табельный номер начальника',
            'password' => 'Пароль',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBossClockNumber()
    {
        return $this->hasOne(Employees::className(), ['clock_number' => 'boss_clock_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasOne(Employees::className(), ['boss_clock_number' => 'clock_number']);
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->clock_number;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    /**
     * Формирует строку с фамилией пользователя и инициалами.
     *
     * @return string
     */
    public function getSecondNameWithInitial()
    {
        return $this->second_name . ' ' . substr($this->name, 0, 2) . '. ' . substr($this->middle_name, 0, 2) . '.';
    }

    /**
     * Метод возвращает массив моделей сотрудников,
     * которые находяться в подчинении босс.
     *
     * @param $bossID
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getEmployeesUnderBoss($bossID)
    {
        return static::find()
            ->where('boss_clock_number = :bossID', [':bossID' => $bossID])
            ->all();
    }
}
