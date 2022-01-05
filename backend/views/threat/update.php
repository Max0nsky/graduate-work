<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Threat */

$this->title = 'Редактировать: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Угрозы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="threat-update">
    <br>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
