<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Audit */

$this->title = 'Создание аудита';
$this->params['breadcrumbs'][] = ['label' => 'Список', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
