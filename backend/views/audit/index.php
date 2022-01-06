<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Аудит';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audit-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Начать новый аудит', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'description:ntext',
            [
                'attribute' => 'date',
                'format' => ['date', 'php:d.m.Y'],
            ],
            [
                'attribute' => 'date_start',
                'format' => ['date', 'php:d.m.Y h:m'],
            ],
            [
                'attribute' => 'date_finish',
                'format' => ['date', 'php:d.m.Y h:m'],
            ],
            [
                'attribute' => 'status',
                'content' => function ($model) {
                    return '#' . $model->status . ' ' . $model->nameStatus;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>