<?php

use common\models\Log;
use common\models\Recommendation;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$allRecs = Recommendation::getRecs();
$sucessRecs = Recommendation::getSuccessRecs();
$errorRecs = Recommendation::getErrorRecs();

$sucessRecsPercent = round((($sucessRecs / $allRecs) * 100), 0);
$errorRecsPercent = round((($errorRecs / $allRecs) * 100), 0);

$newLogs = Log::find()->where(['type' => 0])->count();

?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . 'Приложение' . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
            <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning"><?=$newLogs?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Новых логов - <?=$newLogs?></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                               
                                <li>
                                    <a href="/admin/log">
                                        <i class="fa fa-warning text-yellow"> Просмотр </i>
                                    </a>
                                </li>
                               
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger"><?= $errorRecs ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Не выполнено <?= $errorRecs ?> рекомендаций</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">

                                <li>
                                    <a href="#">
                                        <h3>
                                            Выполненные рекомендации
                                            <small class="pull-right"><?= $sucessRecsPercent ?>%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-green" style="width: <?= $sucessRecsPercent ?>%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only"><?= $sucessRecsPercent ?>% Завершено</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <h3>
                                            Новые рекомендации
                                            <small class="pull-right"><?= $errorRecsPercent ?>%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-red" style="width: <?= $errorRecsPercent ?>%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only"><?= $errorRecsPercent ?>% Новые</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="footer">
                            <a href="/admin/recommendation">Просмотр</a>
                        </li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs"><?= Yii::$app->user->identity->username; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="/admin" class="btn btn-default btn-flat">Главная</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Выход',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <!-- <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a> -->
                </li>
            </ul>
        </div>
    </nav>
</header>