<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Логируемые события';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить лог', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
 
            'name',

            [
                'attribute' => 'log_category_id',
                'content' => function ($model) {
                    $logCategory = $model->logCategory;
                    return '#' . $logCategory->id . ' ' . $logCategory->name;
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
            'type',
            [
                'attribute' => 'date',
                'content' => function ($model) {
                    return  $model->dateTime;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
            
        ],
    ]); ?>


</div>