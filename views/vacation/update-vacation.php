<?php

/* @var $this yii\web\View */
/* @var $vacationModel \app\models\Vacations */

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактировать отпуск';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin(['id' => 'create-vacation']); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($vacationModel, 'date_start')->widget(DatePicker::class, [
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'language' => 'ru',
                'pluginOptions' => [
                    'autoclose'=>true,

                    'format' => 'dd-mm-yyyy'
                ]
            ])->label('Дата начала'); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($vacationModel, 'date_end')->widget(DatePicker::class, [
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'language' => 'ru',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd-mm-yyyy'
                ]
            ])->label('Дата окончания'); ?>
        </div>
    </div>
<?= Html::submitButton('Далее', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>