<?php

use common\models\ObjectCategory;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ObjectSystem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="object-system-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-5">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-2">
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
            <div class="col-sm-12">
                <?=
                $form->field($model, 'object_category_id')->widget(Select2::class, [
                    'data' => ObjectCategory::getListForSelect('name'),
                    'options' => ['placeholder' => 'Выберите категорию'],
                    'pluginOptions' => [
                        'tabindex' => false,
                        'tags' => false,
                        'tokenSeparators' => [',', ' '],
                    ],
                ])->label('Категория');
                ?>
            </div>
        </div>
    
    </div>
    <div class="row">
        <div class="col-sm-10">
            <?= $form->field($model, 'description')->textarea(['rows' => '6']) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>