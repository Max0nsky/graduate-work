<?php

use yii\helpers\Html;
use yii\grid\GridView;
// use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Объекты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="object-system-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить объект', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'description',
            [
                'attribute' => 'object_category_id',
                'content' => function ($model) {
                    $objectCategory = $model->objectCategory;
                    return '#' . $objectCategory->id . ' ' . $objectCategory->name;
                }
            ],
            'priority',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>