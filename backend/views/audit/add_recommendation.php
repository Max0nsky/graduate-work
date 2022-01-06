<?php

use common\models\Log;
use common\models\LogCategory;
use common\models\ObjectCategory;
use common\models\ObjectSystem;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Рекомендация для аудита: Id-' . $model->id;

?>

<div class="audit-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <h4><?= $model->name?></h4>
    <br>
    <?php $form = ActiveForm::begin(); ?>

    <div class="audit-form">

        <div class="row">
            <div class="col-sm-10">

                <div class="col-sm-12">
                    <?= $form->field($modelRecom, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($modelRecom, 'description')->textarea(['rows' => 6]) ?>
                    <?= $form->field($modelRecom, 'result_need')->textarea(['rows' => 6]) ?>
                </div>

                <div class="col-sm-4">
                    <?= $form->field($modelRecom, 'dateNeed')->widget(DateTimePicker::classname(), [
                        'options' => ['placeholder' => 'Дата выполнения'],
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

                <div class="col-sm-4">
                    <?= $form->field($modelRecom, 'cost_need')->textInput(['type' => 'number']) ?>
                </div>
                <div class="col-sm-4">
                    <?=
                    $form->field($modelRecom, 'priority')->dropDownList([
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

            </div>
        </div>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

    </div>
    <?php ActiveForm::end(); ?>

</div>