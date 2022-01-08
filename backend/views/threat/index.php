<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Угрозы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="threat-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить угрозу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'name',
            [
                'attribute' => 'object_id',
                'content' => function ($model) {
                    $objectSystem = $model->objectSystem;
                    return '#' . $objectSystem->id . ' ' . $objectSystem->name;
                }
            ],

            [
                'attribute' => 'charact_k',
                'content' => function ($model) {
                    return $model::getListYesNo($model->charact_k);
                  },
            ],
            [
                'attribute' => 'charact_c',
                'content' => function ($model) {
                    return $model::getListYesNo($model->charact_c);
                  },
            ],
            [
                'attribute' => 'charact_d',
                'content' => function ($model) {
                    return $model::getListYesNo($model->charact_d);
                  },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
