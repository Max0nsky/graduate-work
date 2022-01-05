<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Threat */

$this->title = 'Добавить урозу';
$this->params['breadcrumbs'][] = ['label' => 'Урозы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="threat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
