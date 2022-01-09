<?php

use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Логи для аудита #' . $modelAudit->id;
$this->params['breadcrumbs'][] = ['label' => 'Страница аудита', 'url' => ['/audit/audit-step-two?id='.$modelAudit->id]];


?>
<div class="log-index">
    <div class="row">
        <?php if ($modelAudit->status < 2) : ?>
            <div class="col-sm-12">
                <div class="col-sm-2 audit-link">
                    <a class="btn btn-danger" href="<?= Url::to(['audit/finish', 'id' => $modelAudit->id]); ?>">Завершить аудит</a>
                </div>
                <div class="col-sm-2 audit-link">
                    <a class="btn btn-info" href="<?= Url::to(['audit/statistic', 'id' => $modelAudit->id]); ?>">Просмотр статистики</a>
                </div>
                <div class="col-sm-2 audit-link">
                    <a class="btn btn-info" href="<?= Url::to(['audit/cvss']); ?>">CVSS-калькулятор v2</a>
                </div>
                <div class="col-sm-2 audit-link">
                    <a class="btn btn-info" href="<?= Url::to(['audit/cvss-three']); ?>">CVSS-калькулятор v3</a>
                </div>
                <div class="col-sm-2 audit-link">
                    <a class="btn btn-info" href="<?= Url::to(['audit/add-recommendation', 'id' => $modelAudit->id]); ?>">Добавить рекомендации</a>
                </div>
            </div>
        <?php else : ?>
            <div class="col-sm-2 audit-link">
                <a class="btn btn-info" href="<?= Url::to(['audit/index']); ?>">К списку</a>
            </div>
        <?php endif; ?>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-4">
                    <?= Highcharts::widget([
                        'options' => [
                            'title' => ['text' => 'Приоритетное соотношение'],
                            'plotOptions' => [
                                'pie' => [
                                    'cursor' => 'pointer',
                                ],
                            ],
                            'series' => [
                                [
                                    'type' => 'pie',
                                    'name' => 'Процент',
                                    'data' => $diagr_priority,
                                ]
                            ],
                        ],
                    ]);

                    ?>
                </div>
                <div class="col-sm-4">
                    <?= Highcharts::widget([
                        'options' => [
                            'title' => ['text' => 'Соотношение категорий логов'],
                            'plotOptions' => [
                                'pie' => [
                                    'cursor' => 'pointer',
                                ],
                            ],
                            'series' => [
                                [
                                    'type' => 'pie',
                                    'name' => 'Процент',
                                    'data' => $diagr_category,
                                ]
                            ],
                        ],
                    ]);

                    ?>
                </div>
                <div class="col-sm-4">
                    <?= Highcharts::widget([
                        'options' => [
                            'title' => ['text' => 'Соотношение предполагаемых угроз'],
                            'plotOptions' => [
                                'pie' => [
                                    'cursor' => 'pointer',
                                ],
                            ],
                            'series' => [
                                [
                                    'type' => 'pie',
                                    'name' => 'Процент',
                                    'data' => $diagr_threat,
                                ]
                            ],
                        ],
                    ]);

                    ?>
                </div>
            </div>
        </div>
        <br>
        <div class="col-sm-12">
            <div class="row">

                <div class="col-sm-4">
                    <?= Highcharts::widget([
                        'options' => [
                            'title' => ['text' => 'Влияние на конфиденциальность, целостность, доступность'],
                            'plotOptions' => [
                                'pie' => [
                                    'cursor' => 'pointer',
                                ],
                            ],
                            'series' => [
                                [
                                    'type' => 'pie',
                                    'name' => 'Процент',
                                    'data' => $diagr_kcd,
                                ]
                            ],
                        ],
                    ]);

                    ?>
                </div>

                <div class="col-sm-4">
                    <?= Highcharts::widget([
                        'options' => [
                            'title' => ['text' => 'Возможные источники угроз'],
                            'plotOptions' => [
                                'pie' => [
                                    'cursor' => 'pointer',
                                ],
                            ],
                            'series' => [
                                [
                                    'type' => 'pie',
                                    'name' => 'Процент',
                                    'data' => $diagr_source,
                                ]
                            ],
                        ],
                    ]);

                    ?>
                </div>

                <div class="col-sm-4">
                    <?= Highcharts::widget([
                        'options' => [
                            'title' => ['text' => 'Соотношение объектов'],
                            'plotOptions' => [
                                'pie' => [
                                    'cursor' => 'pointer',
                                ],
                            ],
                            'series' => [
                                [
                                    'type' => 'pie',
                                    'name' => 'Процент',
                                    'data' => $diagr_obj,
                                ]
                            ],
                        ],
                    ]);

                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">

                <div class="col-sm-12">
                    <?= Highcharts::widget([

                        'scripts' => [
                            'modules/exporting',
                            'themes/grid-light',
                        ],
                        'options' => [
                            'chart' => [
                                'scrollablePlotArea' => [
                                    'minWidth' => 200,
                                    'scrollPositionX' => 1
                                ],
                            ],
                            'title' => [
                                'text' => 'Суточная статистика логов'
                            ],
                            'xAxis' => [
                                'labels' => [
                                    'overflow' => 'justify',
                                ],
                                'tickLength' => 0,
                                'categories' => $statistic_days['dateNames'],
                            ],

                            'series' => [
                                [
                                    'type' => 'column',
                                    'name' => 'Количество',
                                    'data' => $statistic_days['count'],

                                ],
                                [
                                    'type' => 'column',
                                    'name' => 'Убытки',
                                    'data' => $statistic_days['cost'],
                                ],
                                [
                                    'type' => 'column',
                                    'name' => 'Важность',
                                    'data' => $statistic_days['priority'],
                                ],

                            ],
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'content' => function ($model) {
                    $str = '<b>' . $model->name . '</b> <br>';
                    $str .= $model->description . '<br>';
                    return $str;
                }
            ],

            [
                'attribute' => 'log_category_id',
                'content' => function ($model) {
                    $logCategory = $model->logCategory;
                    return '#' . $logCategory->id . ' ' . $logCategory->name;
                }
            ],

            [
                'attribute' => 'object_id',
                'content' => function ($model) {
                    $objectSystem = $model->objectSystem;
                    return '#' . $objectSystem->id . ' ' . $objectSystem->name;
                }
            ],

            [
                'attribute' => 'threat_id',
                'content' => function ($model) {
                    $threat = $model->threat;
                    return '#' . $threat->id . ' ' . $threat->name;
                }
            ],

            [
                'attribute' => 'user_id',
                'content' => function ($model) {
                    $user = $model->user;
                    return '#' . $user->id . ' ' . $user->username;
                }
            ],

            'attribute' => 'priority',

            [
                'attribute' => 'date',
                'content' => function ($model) {
                    return  $model->dateTime;
                }
            ],

        ],
    ]); ?>


</div>