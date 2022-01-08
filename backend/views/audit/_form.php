<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Audit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="audit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="row">

        <div class="col-sm-6">
            <?= $form->field($model, 'dateTimeStart')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => 'Введите время начала...', 'class' => 'dateinput'],
                'pluginOptions' => [
                    'convertFormat' => true,
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy hh:ii',
                    'startDate' => '01-Mar-2014 12:00 AM',
                    'todayHighlight' => true
                ]
            ]); ?>
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'dateTimeFinish')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => 'Введите время конца...', 'class' => 'dateinput'],
                'pluginOptions' => [
                    'convertFormat' => true,
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy hh:ii',
                    'startDate' => '01-Mar-2014 12:00 AM',
                    'todayHighlight' => true
                ]
            ]); ?>
        </div>

    </div>


    <div class="form-group">
        <?= Html::submitButton('Продолжить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
