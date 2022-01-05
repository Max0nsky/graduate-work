<?php

use yii\helpers\Html;
use yii\grid\GridView;

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

            'id',
            'name',
            'description:ntext',
            'audit_id',
            'date',
            //'date_need_execut',
            //'date_fact_execut',
            //'priority',
            //'cost',
            //'result_need:ntext',
            //'result_fact:ntext',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
