<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ObjectSystem */

$this->title = 'Добавить объект';
$this->params['breadcrumbs'][] = ['label' => 'Объекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="object-system-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
