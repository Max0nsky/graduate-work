<?php

use common\models\LogCategory;
use common\models\ObjectSystem;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="log-form">


    <?php $form = ActiveForm::begin(); ?>


    <div class="row">
        <div class="col-sm-9">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'dateTime')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => 'Введите время ...'],
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

    <div class="row">

        <div class="col-sm-3">
            <?=
            $form->field($model, 'log_category_id')->widget(Select2::class, [
                'data' => LogCategory::getListForSelect('name'),
                'options' => ['placeholder' => 'Выберите категорию'],
                'pluginOptions' => [
                    'tabindex' => false,
                    'tags' => false,
                    'tokenSeparators' => [',', ' '],
                ],
            ])->label('Категория');
            ?>
        </div>
        <div class="col-sm-3">
            <?=
            $form->field($model, 'object_id')->widget(Select2::class, [
                'data' => ObjectSystem::getListForSelect('name'),
                'options' => ['placeholder' => 'Выберите объект'],
                'pluginOptions' => [
                    'tabindex' => false,
                    'tags' => false,
                    'tokenSeparators' => [',', ' '],
                ],
            ])->label('Объект');
            ?>
        </div>

        <div class="col-sm-3">
            <?=
            $form->field($model, 'priority')->dropDownList([
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
            ]);
            ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'damages')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'description')->textarea(['rows' => 4, 'onkeyup' => 'myVar.lenghtChar(this)']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>