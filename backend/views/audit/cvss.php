<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Audit */

$this->title = 'CVSS-калькулятор';

?>
<div class="audit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row all">
        <div class="col-sm-4 base">
            <br>
            <h3>Базовые метрики:</h3>
            <div class="sel">
                Способ получения доступа (AV):<br>
                <select class="select" name="AV" size="1">
                    <option value="L">Локальный (L)</option>
                    <option value="A">Смежная сеть (A)</option>
                    <option value="N">Сетевой (N)</option>
                </select>
            </div>
            <div class="sel">
                <br>Сложность получения доступа (AC):<br>
                <select class="select" name="AC" size="1">
                    <option value="H">Высокая (H)</option>
                    <option value="M">Средняя (M)</option>
                    <option value="L">Низкая (L)</option>
                </select>
            </div>
            <div class="sel">
                <br>Аутентификация (Au):<br>
                <select class="select" name="Au" size="1">
                    <option value="M">Множественная (M)</option>
                    <option value="S">Единственная (S)</option>
                    <option value="N">Не требуется (N)</option>
                </select>
            </div>
            <div class="sel">
                <br>Влияние на конфиденциальность (С):<br>
                <select class="select" name="C" size="1">
                    <option value="N">Не оказывает (N)</option>
                    <option value="P">Частичное (P)</option>
                    <option value="C">Полное (C)</option>
                </select>
            </div>
            <div class="sel">
                <br>Влияние на целостность (I):<br>
                <select class="select" name="I" size="1">
                    <option value="N">Не оказывает (N)</option>
                    <option value="P">Частичное (P)</option>
                    <option value="C">Полное (C)</option>
                </select>
            </div>
            <div class="sel">
                <br>Влияние на доступность (A):<br>
                <select class="select" name="A" size="1">
                    <option value="N">Не оказывает (N)</option>
                    <option value="P">Частичное (P)</option>
                    <option value="C">Полное (C)</option>
                </select>
            </div>

        </div>

        <div class="col-sm-4 time">
            <br>
            <h3>Временные метрики:</h3>
            <div class="sel">
                Возможность использования (E):<br>
                <select class="select" name="E" size="1">
                    <option value="ND">Не определено (ND)</option>
                    <option value="U">Теоретически (U)</option>
                    <option value="POC">Есть концепция (POC)</option>
                    <option value="F">Есть сценарий (F)</option>
                    <option value="H">Высокая (H)</option>
                </select>
            </div>
            <div class="sel">
                <br>Уровень исправления (RL):<br>
                <select class="select" name="RL" size="1">
                    <option value="ND">Не определено (ND)</option>
                    <option value="OF">Официальное (OF)</option>
                    <option value="T">Временное (T)</option>
                    <option value="W">Рекомендации (W)</option>
                    <option value="U">Недоступно (U)</option>
                </select>
            </div>
            <div class="sel">
                <br>Степень доверенности источника (RC):<br>
                <select class="select" name="RC" size="1">
                    <option value="ND">Не определено (ND)</option>
                    <option value="UC">Не подтверждена (UC)</option>
                    <option value="UR">Не доказана (UR)</option>
                    <option value="C">Подтверждена (C)</option>
                </select>
            </div>
        </div>

        <div class="col-sm-4 context">
            <br>
            <h3>Контекстные метрики:</h3>
            <div class="sel">
                Вероятность нанесения косвенного ущерба (CDP):<br>
                <select class="select" name="CDP" size="1">
                    <option value="ND">Не определено (ND)</option>
                    <option value="N">Отсутствует (N)</option>
                    <option value="L">Низкая (L)</option>
                    <option value="LM">Средняя (LM)</option>
                    <option value="MH">Повышенная (MH)</option>
                    <option value="H">Высокая (H)</option>
                </select>
            </div>
            <div class="sel">
                <br>Плотность целей (TD):<br>
                <select class="select" name="TD" size="1">
                    <option value="ND">Не определено (ND)</option>
                    <option value="N">Отсутствует (N)</option>
                    <option value="L">Низкая (L)</option>
                    <option value="M">Средняя (M)</option>
                    <option value="H">Высокая (H)</option>
                </select>
            </div>
            <div class="sel">
                <br>Требования к конфиденциальности (CR):<br>
                <select class="select" name="CR" size="1">
                    <option value="ND">Не определено (ND)</option>
                    <option value="L">Низкая (L)</option>
                    <option value="M">Средняя (M)</option>
                    <option value="H">Высокая (H)</option>
                </select>
            </div>
            <div class="sel">
                <br>Требования к целостности (IR):<br>
                <select class="select" name="IR" size="1">
                    <option value="ND">Не определено (ND)</option>
                    <option value="L">Низкая (L)</option>
                    <option value="M">Средняя (M)</option>
                    <option value="H">Высокая (H)</option>
                </select>
            </div>
            <div class="sel">
                <br>Требования к конфиденциальности (AR):<br>
                <select class="select" name="AR" size="1">
                    <option value="ND">Не определено (ND)</option>
                    <option value="L">Низкая (L)</option>
                    <option value="M">Средняя (M)</option>
                    <option value="H">Высокая (H)</option>
                </select>
            </div>
        </div>
    </div>

    <br>
    <div class="form-group">
        <?= Html::submitButton('Пересчет характеристик', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>