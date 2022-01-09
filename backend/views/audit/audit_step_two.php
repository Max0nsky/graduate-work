<?php

use common\models\Log;
use common\models\LogCategory;
use common\models\ObjectCategory;
use common\models\ObjectSystem;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Шаг №2 для аудита: Id-' . $model->id;

$logs = $model->logs;

$logCategories = $model->modelsLogCategories;
$objectCategories = $model->modelsObjectCategories;
$objectSystems = $model->modelsObjectSystems;
$recommendations = $model->recommendations;

?>

<div class="audit-update">
    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-2 audit-link">
                <a class="btn btn-danger" href="<?= Url::to(['audit/finish', 'id' => $model->id]); ?>">Завершить аудит</a>
            </div>
            <div class="col-sm-2 audit-link">
                <a class="btn btn-info" href="<?= Url::to(['audit/statistic', 'id' => $model->id]); ?>">Просмотр статистики</a>
            </div>
            <div class="col-sm-2 audit-link">
                <a class="btn btn-info" href="<?= Url::to(['audit/cvss']); ?>">CVSS-калькулятор v2</a>
            </div>
            <div class="col-sm-2 audit-link">
                <a class="btn btn-info" href="<?= Url::to(['audit/cvss-three']); ?>">CVSS-калькулятор v3</a>
            </div>
            <div class="col-sm-2 audit-link">
                <a class="btn btn-info" href="<?= Url::to(['audit/add-recommendation', 'id' => $model->id]); ?>">Добавить рекомендации</a>
            </div>
        </div>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="audit-form">

        <div class="row select-two">

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h3><?= $model->name ?></h3>
                    </div>
                    <div class="card-body">
                        <p><?= $model->description ?></p>
                        <p>
                            <b>Выбранный период для анализа:</b> <br>
                            от <?= $model->dateTimeStart ?> <br>
                            до <?= $model->dateTimeFinish ?> <br>
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

                        <h4>Всего записей за период: <?= count($logs) ?></h4>
                        <h4>Убытки за период: <?= Log::getDamageForLogs($logs) ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Рекомендации</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($recommendations)) : ?>
                            <div id="accordion">

                                <?php $i = 1; ?>
                                <?php foreach ($recommendations as $recommendation) : ?>
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h4 class="card-title w-100">
                                                <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapse-<?= $i ?>" aria-expanded="false">
                                                    • <?= $recommendation->name ?>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse-<?= $i ?>" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                <p><?= $recommendation->description ?></p>
                                                <p><?= $recommendation->result_need ?></p>
                                                <p>
                                                    Приоритет: <?= $recommendation->priority ?> <br>
                                                    Затраты: <?= $recommendation->cost_need ?>
                                                </p>
                                                <p>Выполнить до: <?= date('d.m.Y', $recommendation->date_need_execut) ?></p>
                                                <p>
                                                    <a class="btn btn-outline-primary" href="<?= Url::to(['audit/update-recommendation', 'id' => $recommendation->id]); ?>">Редактировать</a>
                                                    <a class="btn btn-outline-danger" href="<?= Url::to(['audit/delete-recommendation', 'id' => $recommendation->id]); ?>">Удалить</a>
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; ?>
                                <?php endforeach; ?>

                            </div>
                        <?php else : ?>
                            <p>Не найдено</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>