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
                'options' => ['placeholder' => 'Введите время начала...'],
                'convertFormat' => true,
                'pluginOptions' => [
                    'convertFormat' => true,
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy h:i',
                    'language' => 'ru',
                    'weekStart' => 1, //неделя начинается с понедельника
                    'todayBtn' => true, //снизу кнопка "сегодня"
                ]
            ]); ?>
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'dateTimeFinish')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => 'Введите время начала...'],
                'convertFormat' => true,
                'pluginOptions' => [
                    'convertFormat' => true,
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy h:i',
                    'language' => 'ru',
                    'weekStart' => 1, //неделя начинается с понедельника
                    'todayBtn' => true, //снизу кнопка "сегодня"
                ]
            ]); ?>
        </div>

    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
