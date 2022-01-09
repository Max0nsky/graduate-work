<?php

use common\models\Audit;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Audit */

$this->title = 'CVSS-3-результат';

?>
<div class="audit-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row ">
        <div class="col-sm-8 ">
            <p><b>Сформирован вектор для расчета степени опасности уязвимостей:</b>
                <?= ($resultCvss['vector']) ?>
            </p>
            <p><b>Базовые метрики:</b>
                <?= "(" . $resultCvss['BaseScore'] . " из 10.0)" ?>.
                <?= Audit::lvlCvss($resultCvss['BaseScore']) ?>
            </p>
            <p><b>Воздействие на систему:</b>
                <?= "(" . round($resultCvss['Impact'], 1) . " из 10.0)" ?>.
                <?= Audit::lvlCvss(round($resultCvss['Impact'], 1)) ?>
            </p>
            <p><b>Временные метрики:</b>
                <?= "(" . $resultCvss['TemporalScore'] . " из 10.0)" ?>.
                <?= Audit::lvlCvss($resultCvss['TemporalScore']) ?>
            </p>
            <p><b>Контекстные метрики:</b>
                <?= "(" . $resultCvss['EnvironmentalScore'] . " из 10.0)" ?>.
                <?= Audit::lvlCvss($resultCvss['EnvironmentalScore']) ?>
            </p>
            <p><b>Общий результат:</b>
                <?= "(" . $resultCvss['overallScore'] . " из 10.0)" ?>.
                <?= Audit::lvlCvss($resultCvss['overallScore']) ?>
            </p><br>
            
            <div class="col-sm-2 audit-link">
                <a class="btn btn-info" href="<?= Url::to(['audit/cvss-three']); ?>">Пересчитать результат</a>
            </div>
        </div>
    </div>

    <br>

</div>