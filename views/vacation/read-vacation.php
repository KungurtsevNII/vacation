<?php

/* @var $this yii\web\View */
/* @var $vacations \app\models\Vacations[] */

use yii\helpers\Html;

$this->title = 'Просмотр отпусков';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<table class="table table-dark">
    <thead>
        <th>Сотрудник</th>
        <th>Дата начала</th>
        <th>Дата окончания</th>
        <th>Статус</th>
        <th>Действия</th>
    </thead>
    <tbody>
        <?php foreach ($vacations as $vacation): ?>
            <tr>
                <td> <?= $vacation->employee->getSecondNameWithInitial() ?> </td>
                <td> <?= date('d-m-Y', strtotime($vacation->date_start)) ?> </td>
                <td> <?= date('d-m-Y', strtotime($vacation->date_end)) ?> </td>
                <td> <?= $vacation->status ?> </td>
                <td> <?= ($vacation->employee_id == Yii::$app->user->id && $vacation->isUpdatable()) ? Html::a('Редактировать', ['update-vacation', 'id' => $vacation->id]) : 'Не предусмотрено' ?> </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
