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
                Вектор атаки (AV):<br>
                <select class="select" name="AV" size="1">
                    <option value="L">Локальный (L)</option>
                    <option value="A">Смежная сеть (A)</option>
                    <option value="N">Сетевой (N)</option>
                    <option value="P">Физический (P)</option>
                </select>
            </div>
            <div class="sel">
                <br>Сложность атаки (AC):<br>
                <select class="select" name="AC" size="1">
                    <option value="H">Высокая (H)</option>
                    <option value="L">Низкая (L)</option>
                </select>
            </div>
            <div class="sel">
                <br>Уровень привилегий (PR):<br>
                <select class="select" name="PR" size="1">
                    <option value="N">Не требуется (N)</option>
                    <option value="L">Низкий (L)</option>
                    <option value="H">Высокий (H)</option>
                </select>
            </div>
            <div class="sel">
                <br>Взаимодействие с пользователем (UI):<br>
                <select class="select" name="UI" size="1">
                    <option value="R">Требуется (R)</option>
                    <option value="N">Не требуется (N)</option>
                </select>
            </div>
            <div class="sel">
                <br>Влияние на компоненты системы (S):<br>
                <select class="select" name="S" size="1">
                    <option value="U">Не оказывает (U)</option>
                    <option value="C">Оказывает (C)</option>
                </select>
            </div>
            <div class="sel">
                <br>Влияние на конфиденциальность (С):<br>
                <select class="select" name="C" size="1">
                    <option value="N">Не оказывает (N)</option>
                    <option value="L">Низкое (L)</option>
                    <option value="H">Высокое (H)</option>
                </select>
            </div>
            <div class="sel">
                <br>Влияние на целостность (I):<br>
                <select class="select" name="I" size="1">
                    <option value="N">Не оказывает (N)</option>
                    <option value="L">Низкое (L)</option>
                    <option value="H">Высокое (H)</option>
                </select>
            </div>
            <div class="sel">
                <br>Влияние на доступность (A):<br>
                <select class="select" name="A" size="1">
                    <option value="N">Не оказывает (N)</option>
                    <option value="L">Низкое (L)</option>
                    <option value="H">Высокое (H)</option>
                </select>
            </div>

        </div>

        <div class="col-sm-4 time">
            <br>
            <h3>Временные метрики:</h3>
            <div class="sel">
                Доступность средств эксплуатации (E):<br>
                <select class="select" name="E" size="1">
                    <option value="X">Не определено (X)</option>
                    <option value="H">Высокая (H)</option>
                    <option value="F">Есть сценарий (F)</option>
                    <option value="P">Есть PoC-код (P)</option>
                    <option value="U">Теоретическая (U)</option>
                </select>
            </div>
            <div class="sel">
                <br>Доступность средств устранения (RL):<br>
                <select class="select" name="RL" size="1">
                    <option value="X">Не определено (X)</option>
                    <option value="U">Недоступно (U)</option>
                    <option value="W">Рекомендации (W)</option>
                    <option value="T">Временное (T)</option>
                    <option value="O">Официальное (O)</option>
                </select>
            </div>
            <div class="sel">
                <br>Степень доверенности источника (RC):<br>
                <select class="select" name="RC" size="1">
                    <option value="X">Не определено (X)</option>
                    <option value="C">Подтверждена (C)</option>
                    <option value="R">Достоверные отчеты (R)</option>
                    <option value="U">Отчеты (U)</option>
                </select>
            </div>
            <div class="sel">
                <br>Требования к конфиденциальности (CR):<br>
                <select class="select" name="CR" size="1">
                    <option value="X">Не определено (X)</option>
                    <option value="L">Низкая (L)</option>
                    <option value="M">Средняя (M)</option>
                    <option value="H">Высокая (H)</option>
                </select>
            </div>
            <div class="sel">
                <br>Требования к целостности (IR):<br>
                <select class="select" name="IR" size="1">
                    <option value="X">Не определено (X)</option>
                    <option value="L">Низкая (L)</option>
                    <option value="M">Средняя (M)</option>
                    <option value="H">Высокая (H)</option>
                </select>
            </div>
            <div class="sel">
                <br>Требования к конфиденциальности (AR):<br>
                <select class="select" name="AR" size="1">
                    <option value="X">Не определено (X)</option>
                    <option value="L">Низкая (L)</option>
                    <option value="M">Средняя (M)</option>
                    <option value="H">Высокая (H)</option>
                </select>
            </div>
        </div>

        <div class="col-sm-4 context">
            <br>
            <h3>Контекстные метрики:</h3>
           
            <div class="sel">
                <br>Вектор атаки корр. (MAV):<br>
                <select class="select" name="MAV" size="1">
                    <option value="X">Не определено (X)</option>
                    <option value="N">Сетевой (N)</option>
                    <option value="A">Смежная сеть (A)</option>
                    <option value="L">Локальный (L)</option>
                    <option value="P">Физический (P)</option>
                </select>
            </div>
            
            <div class="sel">
                <br>Сложность атаки корр. (MAC):<br>
                <select class="select" name="MAC" size="1">
                    <option value="X">Не определено (X)</option>
                    <option value="H">Высокая (H)</option>
                    <option value="L">Низкая (L)</option>
                </select>
            </div>

            <div class="sel">
                <br>Уровень привилегий корр. (MPR):<br>
                <select class="select" name="MPR" size="1">
                    <option value="X">Не определено (X)</option>
                    <option value="H">Высокая (H)</option>
                    <option value="L">Низкая (L)</option>
                    <option value="N">Не требуется (N)</option>
                </select>
            </div>

            <div class="sel">
                <br>Взаимодействие с пользователем корр. (MUI):<br>
                <select class="select" name="MUI" size="1">
                    <option value="X">Не определено (X)</option>
                    <option value="R">Требуется (R)</option>
                    <option value="N">Не требуется (N)</option>
                </select>
            </div>

            <div class="sel">
                <br>Взаимодействие с пользователем корр. (MS):<br>
                <select class="select" name="MS" size="1">
                    <option value="X">Не определено (X)</option>
                    <option value="U">Не оказывает (U)</option>
                    <option value="C">Оказывает (C)</option>
                </select>
            </div>

            <div class="sel">
                <br>Влияние на конфиденциальность корр. (MC):<br>
                <select class="select" name="MC" size="1">
                    <option value="X">Не определено (X)</option>
                    <option value="N">Не оказывает (N)</option>
                    <option value="L">Низкое (L)</option>
                    <option value="H">Высокое (H)</option>
                </select>
            </div>

            <div class="sel">
                <br>Влияние на целостность корр. (MI):<br>
                <select class="select" name="MI" size="1">
                    <option value="X">Не определено (X)</option>
                    <option value="N">Не оказывает (N)</option>
                    <option value="L">Низкое (L)</option>
                    <option value="H">Высокое (H)</option>
                </select>
            </div>
            <div class="sel">
                <br>Влияние на доступность корр. (MA):<br>
                <select class="select" name="MA" size="1">
                    <option value="X">Не определено (X)</option>
                    <option value="N">Не оказывает (N)</option>
                    <option value="L">Низкое (L)</option>
                    <option value="H">Высокое (H)</option>
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