<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Log */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-form">


    <?php $form = ActiveForm::begin(); ?>


    <div class="row">
        <div class="col-sm-9">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'date_pick')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Введите дату ...'],
                'pluginOptions' => [
                    'convertFormat' => true,
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy',
                    'language' => 'ru',
                    'weekStart' => 1, //неделя начинается с понедельника
                    'todayBtn' => true, //снизу кнопка "сегодня"
                ]
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'damages')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'log_category_id')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'object_id')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'priority')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'description')->textarea(['rows' => 4, 'onkeyup' => 'myVar.lenghtChar(this)']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>