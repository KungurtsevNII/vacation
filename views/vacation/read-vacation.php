<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel VacationsSearch */

use app\models\Vacations;
use app\models\VacationsSearch;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Просмотр отпусков';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => '{items}',
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'secondNameWithInitial',
            'label' => 'Сотрудник',
            'content' => function($data) {
                return $data->secondNameWithInitial;
            },
        ],
        [
            'attribute' => 'date_start',
            'label' => 'Дата начала',
            'content' => function($data) {
                return date('d.m.Y', strtotime($data->date_start));
            },
        ],
        [
            'attribute' => 'date_end',
            'label' => 'Дата окончания',
            'content' => function($data) {
                return date('d.m.Y', strtotime($data->date_end));
            },
        ],
        [
            'attribute' => 'status',
            'label' => 'Статус',
            'content' => function($data) {
                return ($data->status == Vacations::NOT_APPROVAL_VACATION) ? '<font color="red">Не согласован</font>' : '<font color="green">Согласован</font>';
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Действие',
            'template' => '{update}',
            'buttons' => [
                'update' => function($url, $model) {
                    if ($model->employee_id == Yii::$app->user->id && $model->isUpdatable()) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['vacation/update-vacation', 'id' => $model->id]);
                    }
                    return 'Не предусмотрено';
                }
            ]
        ],
    ],
]); ?>
