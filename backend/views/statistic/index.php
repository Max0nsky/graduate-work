<?php

use common\models\Partners;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\assets\BrandAsset;
use common\components\MyComponent;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use miloschuman\highcharts\GanttChart;
use miloschuman\highcharts\Highstock;
use miloschuman\highcharts\SeriesDataHelper;

\kartik\select2\Select2Asset::register($this);


$this->title = 'Статистика товаров';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="index">
	<div class="row">
		<div class="col-sm-12">
			<div class="box">
				<div class="box-header with-border">
					<div style="float: left">
						<h3 class="box-title"><?= $this->title ?></h3>
						<h5>Раздел на стадии разработки/тестирования</h5>
						<h5>Сбор данных с 09.11.21</h5>
					</div>
				</div>
				<div class="box-body" id="box-body-tree" style="min-height: 1000px; max-height: 600px; overflow: auto">

					<div class="tabs-block">
						<ul class="tabs-list clearfix">

							<li class="active">
								<a data-toggle="tab" href="#panel-settings-view">
									<span>Общее</span>
								</a>
							</li>
							<li>
								<a data-toggle="tab" href="#panel-settings-order">
									<span>Диаграммы</span>
								</a>
							</li>
							<li>
								<a data-toggle="tab" href="#panel-settings-not-order">
									<span>Без заказов</span>
								</a>
							</li>
							<li>
								<a data-toggle="tab" href="#panel-settings-table">
									<span>Таблица</span>
								</a>
							</li>
						</ul>
						<div class="tab-content">

							<div id="panel-settings-view" class="tab-pane fade in active">
								<div id="data-modal-settings-view">
									<div class="row">
										<?php $form = ActiveForm::begin(['id' => 'statistic-form', 'method' => 'get']); ?>
										<div class="col-sm-1">
											<?= Html::submitButton('Показать', ['class' => 'btn btn-flat btn-info']) ?>
										</div>
										<div class="col-sm-2">
											От:
											<input name="ot" type="date" value="<?= $dateOt ?>" required>
										</div>
										<div class="col-sm-2">
											До:
											<input name="do" type="date" value="<?= $dateDo ?>" required>
										</div>

										<?php ActiveForm::end(); ?>
									</div>

									<div class="row">


										<div class="col-sm-12">


											<?php if (isset($statisticForDates['dateNames'])) : ?>
												<?= Highcharts::widget([

													'scripts' => [
														'modules/exporting',
														'themes/grid-light',
													],
													'options' => [
														'chart' => [
															'scrollablePlotArea' => [
																'minWidth' => 5000,
																'scrollPositionX' => 1
															],
														],
														'title' => [
															'text' => 'Статистика товаров'
														],
														'xAxis' => [
															'labels' => [
																'overflow' => 'justify',
															],
															'tickLength' => 0,
															'categories' => $statisticForDates['dateNames'],
														],

														'series' => [
															[
																'type' => 'column',
																'name' => 'Переходы',
																'data' => $statisticForDates['views'],

															],
															[
																'type' => 'column',
																'name' => 'Добавления',
																'data' => $statisticForDates['added'],
															],
															[
																'type' => 'column',
																'name' => 'Оформления',
																'data' => $statisticForDates['orders'],
															],

														],
													]
												]);
												?>
											<?php else : ?>
												<h5>Внимание! Статистика за выбранный временной не найдена</h5>
												<br>
											<?php endif; ?>
										</div>


									</div>

									<?php if (!empty($resultOrder['statCatArray'])) : ?>
										<div class="row">
											<?php $form = ActiveForm::begin(['id' => 'statistic-form', 'method' => 'get']); ?>
											<div class="col-sm-1">
												<?= Html::submitButton('Показать', ['class' => 'btn btn-flat btn-info']) ?>
											</div>
											<div class="col-sm-2">
												<input name="orderCount" value="<?= $orderCount ?>" type="number" min="1">
											</div>
											<div class="col-sm-1">
												<select name="orderSort">
													<option value='best'>Лучшие</option>
													<option <?= ($orderSort == 'notBest') ? 'selected' : '' ?> value='notBest'>Худшие</option>
												</select>
											</div>

											<?php ActiveForm::end(); ?>
										</div>
										<div class="row">
											<div class="col-sm-12">

												<?= Highcharts::widget([
													'scripts' => [
														'modules/exporting',
														'themes/grid-light',
													],
													'options' => [
														'title' => [
															'text' => 'Топ товаров по заказам',
														],
														'xAxis' => [
															'categories' => $resultOrder['statArray']['names'],
														],

														'series' => [
															[
																'type' => 'column',
																'name' => 'Заказы',
																'data' => $resultOrder['statArray']['count'],
															],
														],
													]
												]); ?>
											</div>
										</div>

									<?php endif; ?>
								</div>
							</div>
							<div id="panel-settings-order" class="tab-pane fade in ">
								<div id="data-modal-settings-order">
									<div class="row">

										<div class="col-sm-6">

											<?= Highcharts::widget([
												'options' => [
													'title' => ['text' => 'Категории товаров по переходам'],
													'plotOptions' => [
														'pie' => [
															'cursor' => 'pointer',
														],
													],
													'series' => [
														[
															'type' => 'pie',
															'name' => 'Процент',
															'data' => $resultView,
														]
													],
												],
											]);

											?>
										</div>
										<div class="col-sm-6">

											<?= Highcharts::widget([
												'options' => [
													'title' => ['text' => 'Категории товаров по добавлениям'],
													'plotOptions' => [
														'pie' => [
															'cursor' => 'pointer',
														],
													],
													'series' => [
														[
															'type' => 'pie',
															'name' => 'Процент',
															'data' => $resultAdded,
														]
													],
												],
											]);

											?>
										</div>
										<div class="col-sm-12">

											<?= Highcharts::widget([
												'options' => [
													'title' => ['text' => 'Категорий товаров по заказам'],
													'plotOptions' => [
														'pie' => [
															'cursor' => 'pointer',
														],
													],
													'series' => [
														[
															'type' => 'pie',
															'name' => 'Процент',
															'data' => $resultOrder['statCatArray'],
														]
													],
												],
											]);

											?>
										</div>
									</div>
								</div>
							</div>
							<div id="panel-settings-not-order" class="tab-pane fade in ">
								<div id="w0-container" class="table-responsive kv-grid-container">
									<table class="kv-grid-table table table-bordered table-striped kv-table-wrap">
										<thead>
											<tr>
												<th style="width: 3.93%;">ID</th>
												<th data-col-seq="2" style="width: 20.0%;">Картинка</th>
												<th data-col-seq="1" style="width: 40.0%;">Название</th>
												<th data-col-seq="3" style="width: 10.0%;">Переходы</th>
												<th data-col-seq="4" style="width: 10.0%;">Добавления</th>
												<th data-col-seq="5" style="width: 9.89%;">Редактировать</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($notOrderGoods)) : ?>
												<?php foreach ($notOrderGoods as $goodStat) : ?>
													<tr>
														<?php $good = $goodStat['good'] ?>
														<?php if (!empty($good->constructor_id)) : ?>
															<td><?= $good->id ?></td>
															<td data-col-seq="1">
																<?= Html::img(Url::toRoute($good->constructor->getImage()->getPath('150x150')), [
																	'alt' => 'yii2 - картинка в gridview',
																	'style' => 'width:150px;'
																]); ?>
															</td>
															<td data-col-seq="2"><?= '<a  target="_blank" href="' . Url::to(['../goods/' . $good->slug]) . '">' . $good->name . '</a>' ?></td>
															<td data-col-seq="3"><?= $goodStat['views'] ?></td>
															<td data-col-seq="4"><?= $goodStat['added'] ?></td>
															<td data-col-seq="5"><a href="/icms/good-constructor/update?id=<?= $good->id ?>" title="Редактировать" aria-label="Редактировать" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a></td>
														<?php else : ?>
															<td><?= $good->id ?></td>
															<td data-col-seq="1">
																<?= Html::img(Url::toRoute($good->getImage()->getPath('150x150')), [
																	'alt' => 'yii2 - картинка в gridview',
																	'style' => 'width:150px;'
																]); ?>
															</td>
															<td data-col-seq="2"><?= '<a  target="_blank" href="' . Url::to(['../goods/' . $good->slug]) . '">' . $good->name . '</a>' ?></td>
															<td data-col-seq="3"><?= $goodStat['views'] ?></td>
															<td data-col-seq="4"><?= $goodStat['added'] ?></td>
															<td data-col-seq="5"><a href="/icms/good/update?id=<?= $good->id ?>" title="Редактировать" aria-label="Редактировать" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a></td>
														<?php endif; ?>
													</tr>


												<?php endforeach; ?>
											<?php else : ?>
												<td></td>
												<td data-col-seq="1">Ничего не найдено</td>
												<td data-col-seq="2"></td>
												<td data-col-seq="3"></td>
												<td data-col-seq="4"></td>
												<td data-col-seq="5"></td>
											<?php endif; ?>
										</tbody>
									</table>
								</div>
							</div>
							<div id="panel-settings-table" class="tab-pane fade in ">
								<div class="row">
									<?php $form = ActiveForm::begin(['id' => 'statistic-form', 'method' => 'get']); ?>
									<div class="col-sm-1">
										<?= Html::submitButton('Показать', ['class' => 'btn btn-flat btn-info']) ?>
									</div>
									<!-- <div class="col-sm-2">
										От:
										<input name="otTable" type="date" value="" required>
									</div>
									<div class="col-sm-2">
										До:
										<input name="doTable" type="date" value="" required>
									</div>
									<div class="col-sm-2">
										<input name="orderCountTable" value="100" type="number" min="1">
									</div>
									<div class="col-sm-1">
										<select name="orderSort">
											<option value='viewTable'>Переходы +</option>
											<option value='best'>Переходы -</option>
										</select>
									</div> -->

									<?php ActiveForm::end(); ?>
								</div>
								<div id="w0-container" class="table-responsive kv-grid-container">
									<table class="kv-grid-table table table-bordered table-striped kv-table-wrap">
										<thead>
											<tr>
												<th style="width: 3.93%;">ID</th>
												<th data-col-seq="1" style="width: 40.0%;">Название</th>
												<th data-col-seq="3" style="width: 10.0%;">Переходы</th>
												<th data-col-seq="4" style="width: 10.0%;">Добавления</th>
												<th data-col-seq="4" style="width: 10.0%;">Оформления</th>
												<th data-col-seq="5" style="width: 9.89%;">Редактировать</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($tableGoods)) : ?>

												<?php foreach ($tableGoods as $nameDate => $tableGood) : ?>
													<tr>
														<?php $good = $tableGood['good'] ?>
														<?php if (!empty($good->constructor_id)) : ?>
															<td><?= $good->id ?></td>
															<td data-col-seq="2"><?= '<a  target="_blank" href="' . Url::to(['../goods/' . $good->slug]) . '">' . $nameDate . '</a>' ?></td>
															<td data-col-seq="3"><?= $tableGood['views'] ?></td>
															<td data-col-seq="4"><?= $tableGood['added'] ?></td>
															<td data-col-seq="4"><?= $tableGood['orders'] ?></td>
															<td data-col-seq="5"><a href="/icms/good-constructor/update?id=<?= $good->id ?>" title="Редактировать" aria-label="Редактировать" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a></td>
														<?php else : ?>
															<td><?= $good->id ?></td>
															<td data-col-seq="2"><?= '<a  target="_blank" href="' . Url::to(['../goods/' . $good->slug]) . '">' . $nameDate . '</a>' ?></td>
															<td data-col-seq="3"><?= $tableGood['views'] ?></td>
															<td data-col-seq="4"><?= $tableGood['added'] ?></td>
															<td data-col-seq="4"><?= $tableGood['orders'] ?></td>

															<td data-col-seq="5"><a href="/icms/good/update?id=<?= $good->id ?>" title="Редактировать" aria-label="Редактировать" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a></td>
														<?php endif; ?>
													</tr>

												<?php endforeach; ?>
											<?php else : ?>
												<td></td>
												<td data-col-seq="1">Ничего не найдено</td>
												<td data-col-seq="2"></td>
												<td data-col-seq="3"></td>
												<td data-col-seq="4"></td>
												<td data-col-seq="5"></td>
											<?php endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>