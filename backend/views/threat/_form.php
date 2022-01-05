<?php

use common\models\ObjectSystem;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Threat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="threat-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-12">

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-12">

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>

        <div class="col-sm-12">

            <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-12">
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
        <div class="col-sm-4">

            <?= $form->field($model, 'charact_k')
                ->dropDownList(
                    [
                        0 => 'Нет',
                        1 => 'Да',
                    ],
                ); ?>
        </div>

        <div class="col-sm-4">

            <?= $form->field($model, 'charact_c')
                ->dropDownList(
                    [
                        0 => 'Нет',
                        1 => 'Да',
                    ],
                ); ?>
        </div>
        <div class="col-sm-4">

            <?= $form->field($model, 'charact_d')
                ->dropDownList(
                    [
                        0 => 'Нет',
                        1 => 'Да',
                    ],
                ); ?>
        </div>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>