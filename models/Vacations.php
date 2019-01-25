<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vacations".
 *
 * @property int $id
 * @property int $employee_id
 * @property string $date_start
 * @property string $date_end
 * @property string $created_at
 * @property int $status
 *
 * @property Employees $employee
 */
class Vacations extends \yii\db\ActiveRecord
{
    const NOT_APPROVAL_VACATION = 1;
    const APPROVAL_VACATION = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'date_start', 'date_end'], 'required', 'message' => 'Заполните поле'],
            [['employee_id', 'status'], 'integer'],
            [['date_start', 'date_end', 'created_at'], 'safe'],
            [['date_start'], 'validateDate'],
            [['employee_id'], 'exist', 'skipOnError' => false, 'targetClass' => Employees::className(), 'targetAttribute' => ['employee_id' => 'clock_number']],
        ];
    }

    /**
     * Валидация интервала отпуска.
     *
     * @param $attribute
     * @param $params
     */
    public function validateDate($attribute, $params)
    {
        if ($this->date_start >= $this->date_end) {
            $this->addError('date_start', 'Дата начала не может быть больше или равна дате окончания.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Employee ID',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employees::className(), ['clock_number' => 'employee_id']);
    }

    /**
     * Можно ли обновлять отпуск.
     *
     * @return bool
     */
    public function isUpdatable()
    {
        return ($this->status == 1) ? true : false;
    }

    /* Геттер для ФИО */
    public function getSecondNameWithInitial() {
        return $this->employee->getSecondNameWithInitial();
    }
}
