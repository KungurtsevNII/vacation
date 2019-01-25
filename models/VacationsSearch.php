<?php

namespace app\models;


use yii\base\Model;
use yii\data\ActiveDataProvider;

class VacationsSearch extends Vacations
{
    public $secondNameWithInitial;

    /* Настройка правил */
    public function rules() {
        return [
            [['secondNameWithInitial', 'date_start'], 'string'],
            [['status'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     *
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Vacations::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Сортировка.
        $dataProvider->setSort([
            'attributes' => [
                'secondNameWithInitial' => [
                    'asc' => ['employees.name' => SORT_ASC, 'employees.second_name' => SORT_ASC],
                    'desc' => ['employees.name' => SORT_DESC, 'employees.second_name' => SORT_DESC],
                    'label' => 'Сотрудник',
                    'default' => SORT_ASC
                ],
                'date_start' => [
                    'asc' => ['date_start' => SORT_ASC],
                    'desc' => ['date_start' => SORT_DESC],
                ],
                'date_end' => [
                    'asc' => ['date_end' => SORT_ASC],
                    'desc' => ['date_end' => SORT_DESC],
                ],
                'status' => [
                    'asc' => ['status' => SORT_ASC],
                    'desc' => ['status' => SORT_DESC],
                ],
            ]
        ]);


        $query->joinWith(['employee']);

        if (!$this->load($params) || !$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'date_start' => $this->date_start,
        ]);
        $query->andFilterWhere([
            'like',
            'concat(UPPER(employees.second_name), " ", UPPER(employees.name), " ", UPPER(employees.middle_name))',
            mb_strtoupper($this->secondNameWithInitial)
        ]);


        return $dataProvider;
    }
}