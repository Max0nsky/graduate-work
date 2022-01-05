<?php

use common\models\LogCategory;
use common\models\ObjectCategory;
use common\models\ObjectSystem;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Шаг №1 для аудита: Id-' . $model->id;

?>
<div class="audit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="audit-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="row select-two">
            <div class="col-sm-12">
                <?= Select2::widget([
                    'name' => 'Audit[logCategories]',
                    'language' => 'ru',
                    'value' => $model->logCategoryIds,
                    'data' => LogCategory::getListForSelect('name'),
                    'options' => ['multiple' => true, 'placeholder' => 'Выбор категорий логов ...']
                ]); ?>
            </div>
        </div>

        <div class="row select-two">
            <div class="col-sm-12">
                <?= Select2::widget([
                    'name' => 'Audit[objectCategories]',
                    'value' => $model->objectCategoryIds,
                    'language' => 'ru',
                    'data' => ObjectCategory::getListForSelect('name'),
                    'options' => ['multiple' => true, 'placeholder' => 'Выбор категорий объектов ...']
                ]); ?>
            </div>
        </div>

        <div class="row select-two">

            <div class="col-sm-12">
                <?= Select2::widget([
                    'name' => 'Audit[objectSystems]',
                    'value' => $model->objectSystemsIds,
                    'language' => 'ru',
                    'data' => ObjectSystem::getListForSelect('name'),
                    'options' => ['multiple' => true, 'placeholder' => 'Выбор объекты ...']
                ]); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Далее', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>