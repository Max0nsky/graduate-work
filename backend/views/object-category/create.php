<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ObjectCategory */

$this->title = 'Create Object Category';
$this->params['breadcrumbs'][] = ['label' => 'Object Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="object-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
