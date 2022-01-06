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
    <h4><?= $model->name ?></h4>
    <p><?= $model->description ?></p>
    <br>
    <?php $form = ActiveForm::begin(); ?>

    <div class="audit-form">

        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($modelRecom, 'name')->textInput(['maxlength' => true, 'readOnly' => true]) ?>
                <?= $form->field($modelRecom, 'description')->textarea(['rows' => 5, 'readOnly' => true]) ?>
            </div>


            <div class="col-sm-6">
                <?php if ($modelRecom->status == 2) : ?>
                    <div class="col-sm-12">
                        <?= $form->field($modelRecom, 'result_fact')->textarea(['rows' => 7, 'readOnly' => true]) ?>
                    </div>

                    <div class="col-sm-12">
                        <p>
                            <b>Фактические затраты:</b>
                            <?= $modelRecom->cost_fact ?>
                        </p>
                        <br>
                    </div>

                    <div class="col-sm-12">
                        <p>
                            <b>Дата фактического выполнения:</b>
                            <?= $modelRecom->dateFact ?>
                        </p>
                        <br>
                    </div>
                <?php else : ?>
                    <div class="col-sm-12">
                        <?= $form->field($modelRecom, 'result_fact')->textarea(['rows' => 7,  'required' => true]) ?>
                    </div>
                    <div class="col-sm-12">
                        <?= $form->field($modelRecom, 'dateFact')->widget(DateTimePicker::classname(), [
                            'options' => ['placeholder' => 'Дата выполнения', 'required' => true],
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
                    <div class="col-sm-12">
                        <?= $form->field($modelRecom, 'cost_fact')->textInput(['type' => 'number', 'required' => true]) ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-sm-6">
                <div class="col-sm-12">
                    <?= $form->field($modelRecom, 'result_need')->textarea(['rows' => 7, 'readOnly' => true]) ?>
                </div>

                <div class="col-sm-12">
                    <p>
                        <b>Ожидаемые затраты:</b>
                        <?= $modelRecom->cost_need ?>
                    </p>
                    <br>
                </div>

                <div class="col-sm-12">
                    <p>
                        <b>Дата ожидаемого выполнения:</b>
                        <?= $modelRecom->dateNeed ?>
                    </p>
                    <br>
                </div>

                <div class="col-sm-12">
                    <p>
                        <b>Приоритет:</b>
                        <?= $modelRecom->priority ?>
                    </p>
                    <br>
                </div>
            </div>

        </div>
    </div>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

</div>
<?php ActiveForm::end(); ?>

</div>