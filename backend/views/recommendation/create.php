<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Recommendation */

$this->title = 'Create Recommendation';
$this->params['breadcrumbs'][] = ['label' => 'Recommendations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recommendation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
