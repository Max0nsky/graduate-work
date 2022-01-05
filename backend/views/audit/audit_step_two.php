<?php

use common\models\Log;
use common\models\LogCategory;
use common\models\ObjectCategory;
use common\models\ObjectSystem;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Шаг №2 для аудита: Id-' . $model->id;

$logs = $model->logs;

$logCategories = $model->modelsLogCategories;
$objectCategories = $model->modelsObjectCategories;
$objectSystems = $model->modelsObjectSystems;

?>

<div class="audit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="audit-form">

        <div class="row select-two">
            <div class="col-sm-6">
                <h3><?= $model->name ?></h3>
                <p><?= $model->description ?></p>
                <p>
                    <b>Выбранный период для анализа:</b> <br>
                    от <?= date('d.m.Y h:m', $model->date_start) ?> <br>
                    до <?= date('d.m.Y h:m', $model->date_finish) ?> <br>
                </p>

                <?php if (!empty($logCategories)) : ?>
                    <p>
                        <b>Анализируемые категории логов:</b> <br>
                        <?php foreach ($logCategories as $logCategory) : ?>
                            <?= $logCategory->name ?>;
                        <?php endforeach; ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($objectCategories)) : ?>
                    <p>
                        <b>Анализируемые категории объектов системы:</b> <br>
                        <?php foreach ($objectCategories as $objectCategory) : ?>
                            <?= $objectCategory->name ?>;
                        <?php endforeach; ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($objectSystems)) : ?>
                    <p>
                        <b>Анализируемые объекты системы:</b> <br>
                        <?php foreach ($objectSystems as $objectSystem) : ?>
                            <?= $objectSystem->name ?>;
                        <?php endforeach; ?>
                    </p>
                <?php endif; ?>

            </div>
            <div class="col-sm-6">

                <div class="col-sm-12 audit-link">
                    <h3>Действия:</h3>
                </div>
                <div class="col-sm-12 audit-link">
                    <a class="btn btn-info" href="">Просмотр статистики</a>
                </div>
                <div class="col-sm-12 audit-link">
                    <a class="btn btn-info" href="">Добавить рекомендации</a>
                </div>
                <div class="col-sm-12 audit-link">
                    <a class="btn btn-info" href="">CVSS-калькулятор</a>
                </div>
                <div class="col-sm-12 audit-link">
                    <a class="btn btn-danger" href="">Завершить аудит</a>
                </div>


            </div>
            <div class="col-sm-12">
                <h4>Всего записей за период: <?= count($logs) ?></h4>
                <h4>Убытки за период: <?= Log::getDamageForLogs($logs) ?></h4>
            </div>
        </div>

    </div>

</div>