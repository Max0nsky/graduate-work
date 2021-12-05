<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LogCategory */

$this->title = 'Добавить категорию логов';
$this->params['breadcrumbs'][] = ['label' => 'Log Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
