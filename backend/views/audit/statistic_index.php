<?php

use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Логи для аудита #' . $modelAudit->id;
$this->params['breadcrumbs'][] = $this->title;
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
                    <a class="btn btn-info" href="">CVSS-калькулятор</a>
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
                <div class="col-sm-6">
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
                <div class="col-sm-6">
                    <?= Highcharts::widget([
                        'options' => [
                            'title' => ['text' => 'Соотношение категорий'],
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
            </div>
        </div>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
                'attribute' => 'user_id',
                'content' => function ($model) {
                    $user = $model->user;
                    return '#' . $user->id . ' ' . $user->username;
                }
            ],

            'attribute' => 'damages',


            [
                'attribute' => 'date',
                'format' => ['date', 'php:d.m.Y h:m'],
            ],

        ],
    ]); ?>


</div>