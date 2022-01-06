<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рекомендации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recommendation-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'audit_id',
                'format' => 'raw',
                'content' => function ($model) {
                    $str = '<b> #' . $model->audit_id . '</b> ';
                    $str .= '<a href="'. Url::to(['audit/statistic', 'id' => $model->audit_id]).'">Просмотр</a>';
                    return $str;
                }
            ],

            [
                'attribute' => 'date',
                'format' => ['date', 'php:d.m.Y H:i'],
            ],
            [
                'attribute' => 'date_need_execut',
                'format' => ['date', 'php:d.m.Y H:i'],
            ],
            [
                'attribute' => 'date_fact_execut',
                'format' => ['date', 'php:d.m.Y H:i'],
            ],
            'priority',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'content' => function ($model) {
                    return $model->nameStatus;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]); ?>


</div>
