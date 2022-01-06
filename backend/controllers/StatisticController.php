<?php

namespace backend\controllers;

use common\models\goods\Good;
use common\models\goods\GoodStatistic;
use common\models\Order;
use common\models\OrderGoods;
use common\models\goods\GoodTypes;
use yii\web\Controller;
use Yii;
use yii\data\ActiveDataProvider;

class StatisticController extends Controller
{

	public function actionIndex()
	{
		$orders = Order::find()->all();
		$orderGoods = OrderGoods::find()->all();
		$types = GoodTypes::find()->indexBy('id')->all();
		$goodAllStats = GoodStatistic::find()->all();

		// Запрос на получение статистики по датам
		$queryStatistic = GoodStatistic::find();
		$dateOt = date('Y-m-d');
		$dateDo = date('Y-m-d');

		$filterDateOt = strtotime(date('Y-m-d' . ' 00:00:00'));
		$filterDateDo = strtotime(date('Y-m-d' . ' 23:59:59'));

		$orderCount = 20;
		$orderSort = 'best';

		// Как будто бы SearchModel
		if ($get = Yii::$app->request->get()) {
			$dateOt = (isset($get['ot']) && !empty($get['ot'])) ? $get['ot'] : $filterDateOt;
			$dateDo = (isset($get['do']) && !empty($get['do'])) ? $get['do'] : $filterDateDo;

			$filterDateOt = (isset($get['ot']) && !empty($get['ot'])) ? strtotime(date($get['ot'] . ' 00:00:00')) : $filterDateOt;
			$filterDateDo = (isset($get['do']) && !empty($get['do'])) ? strtotime(date($get['do'] . ' 23:59:59')) : $filterDateDo;

			$orderCount = (isset($get['orderCount']) && !empty($get['orderCount'])) ? $get['orderCount'] : $orderCount;
			$orderSort = (isset($get['orderSort']) && !empty($get['orderSort'])) ? $get['orderSort'] : $orderSort;
		}

		$queryStatistic->where(['>=', 'date', $filterDateOt])->andWhere(['<=', 'date', $filterDateDo]);
		$statisticGoods = $queryStatistic->orderBy('date ASC')->all();

		//Расчёт
		$statisticForDates = $this->calculateStatisticForDates($orders, $orderGoods, $statisticGoods);
		$resultOrder = $this->calculateOrderStatistic($types, $orderGoods, $orderCount, $orderSort);
		$resultView = $this->calculateViewStatistic($types, $goodAllStats);
		$resultAdded = $this->calculateAddedStatistic($types, $goodAllStats);
		$notOrderGoods = $this->notOrderGoods($orderGoods);
		// $tableGoods = $this->tableGoods($orderGoods, $orders, $goodAllStats);
		$tableGoods = [];


		return $this->render(
			'index',
			compact(
				'resultOrder',
				'orderCount',
				'orderSort',
				'dateOt',
				'dateDo',
				'statisticForDates',
				'notOrderGoods',
				'resultView',
				'resultAdded',
				'tableGoods',
			)
		);
	}

	/**
	 * Расчет статистики по заказам
	 * return 2 массива
	 */
	public function calculateOrderStatistic($types, $orderGoods, $orderCount, $orderSort)
	{
		$arrayChastGood = [];
		$arrayChastCategory = [];
		$statCatArray = [];

		if (!empty($orderGoods)) {

			foreach ($orderGoods as $orderGood) {
				$good = $orderGood->good;
				if (!isset($arrayChastGood[$good->name])) {
					$arrayChastGood[$good->name] = 0;
				}
				$arrayChastGood[$good->name] += 1;
				if (!isset($arrayChastCategory[$good->type->id])) {
					$arrayChastCategory[$good->type->id] = 0;
				}
				$arrayChastCategory[$good->type->id] += 1;
			}

			arsort($arrayChastGood);
			if ($orderSort == 'notBest') {
				$arrayChastGood = array_reverse($arrayChastGood);
			}

			$arrayChastGood = (count($arrayChastGood) > (int)$orderCount) ? array_slice($arrayChastGood, 0, (int)$orderCount) : $arrayChastGood;

			foreach ($arrayChastGood as $name => $count) {
				$statArray['names'][] =  $name;
				$statArray['count'][] =  $count;
			}

			$total = count($orderGoods);
			foreach ($types as $type) {
				if (isset($arrayChastCategory[$type->id])) {
					$statCatArray[] = [$type->name, round((($arrayChastCategory[$type->id] / $total) * 100), 1)];
				}
			}
		}

		return ['statArray' => $statArray, 'statCatArray' => $statCatArray];
	}

	/**
	 * Расчет статистики по переходам
	 */
	public function calculateViewStatistic($types, $goodAllStats)
	{
		$resArr = [];

		$goodViews = [];
		$total = 0;
		foreach ($goodAllStats as $goodAllStat) {
			if (!isset($goodViews[$goodAllStat->good->type_id])) {
				$goodViews[$goodAllStat->good->type_id] = 0;
			}
			$goodViews[$goodAllStat->good->type_id] += $goodAllStat->views;
			$total += $goodAllStat->views;
		}

		foreach ($goodViews as $typeId => $goodView) {
			$resArr[] = [$types[$typeId]->name, round((($goodView / $total) * 100), 1)];
		}
		return $resArr;
	}

	/**
	 * Расчет статистики по переходам
	 */
	public function calculateAddedStatistic($types, $goodAllStats)
	{
		$resArr = [];

		$goodAdded = [];
		$total = 0;
		foreach ($goodAllStats as $goodAllStat) {
			if (!isset($goodAdded[$goodAllStat->good->type_id])) {
				$goodAdded[$goodAllStat->good->type_id] = 0;
			}
			$goodAdded[$goodAllStat->good->type_id] += $goodAllStat->added;
			$total += $goodAllStat->added;
		}

		foreach ($goodAdded as $typeId => $goodAdd) {
			$resArr[] = [$types[$typeId]->name, round((($goodAdd / $total) * 100), 1)];
		}
		return $resArr;
	}

	/**
	 * Расчет статистики по переходам/добавлениям/оформлениям товаров по $statisticGoods
	 */
	public function calculateStatisticForDates($orders, $orderGoods, $statisticGoods)
	{
		$statisticForDates = [];

		$orderDates = [];
		foreach ($orders as $order) {
			$dateOrder = strtotime(date('Y-m-d', $order->created_at) . ' 00:00:00');
			$orderDates[$order->id] = $dateOrder;
		}

		$orderGoodIds = [];
		foreach ($orderGoods as $orderGood) {
			$orderGoodIds[$orderGood->order_id][] = $orderGood->goods_id;
		}

		$goodDatesOrder = [];
		foreach ($orderDates as $orderId => $date) {
			foreach ($orderGoodIds[$orderId] as $good_id) {

				if (!isset($goodDatesOrder[$date][$good_id])) {
					$goodDatesOrder[$date][$good_id] = 0;
				}
				$goodDatesOrder[$date][$good_id] += 1;
			}
		}

		$arrDates = [];
		foreach ($statisticGoods as $statisticGood) {

			$good = $statisticGood->good;
			$dateName = date('d-m-y', $statisticGood->date) . ' (' . $good->name . ')';


			if (isset($goodDatesOrder[$statisticGood->date])) {
				foreach ($goodDatesOrder[$statisticGood->date] as $goodId => $goodCount) {
					$arrDates[$dateName]['orders'] = 0;

					if ($goodId == $good->id) {
						$arrDates[$dateName]['orders'] = $goodCount;
					}
				}
			}

			$arrDates[$dateName]['views'] = $statisticGood->views;
			$arrDates[$dateName]['added'] = $statisticGood->added;
		}

		foreach ($arrDates as $dateName => $arrDate) {

			$statisticForDates['dateNames'][] = $dateName;
			$statisticForDates['orders'][] = isset($arrDate['orders']) ? $arrDate['orders'] : [];
			$statisticForDates['views'][] = $arrDate['views'];
			$statisticForDates['added'][] = $arrDate['added'];
		}
		return $statisticForDates;
	}

	/**
	 * Товары, которые ещё не заказывали
	 */
	public function notOrderGoods($orderGoods)
	{
		$orderedIds = [];
		foreach ($orderGoods as $orderGood) {
			$orderedIds[$orderGood->goods_id] = $orderGood->goods_id;
		}

		$goods = Good::find()->where(['not in', 'id', $orderedIds])->andWhere(['visibility' => 1, 'is_delete' => 0])->indexBy('id')->all();

		if (!empty($goods)) {

			$goodIds = [];
			foreach ($goods as $good) {
				$goodIds[$good->id] = $good->id;
			}
			$statisticGoods = GoodStatistic::find()->where(['in', 'good_id', $goodIds])->all();

			$resArr = [];
			foreach ($goods as $goodId => $good) {
				$resArr[$goodId]['good'] = $good;
				$resArr[$goodId]['views'] = 0;
				$resArr[$goodId]['added'] = 0;


				if (!empty($statisticGoods)) {

					foreach ($statisticGoods as $statisticGood) {

						if ($statisticGood->good_id == $goodId) {
							$resArr[$goodId]['views'] += $statisticGood->views;
							$resArr[$goodId]['added'] += $statisticGood->added;
						}
					}
				}
			}

			usort($resArr, function ($a, $b) {
				return strnatcmp($b["views"], $a["views"]);
			});
		}

		return $resArr;
	}

	/**
	 * Товары
	 */
	public function tableGoods($orderGoods, $orders, $goodAllStats)
	{
		$goodAllStats = array_slice($goodAllStats, 50);

		$arrDates = [];

		$orderDates = [];
		foreach ($orders as $order) {
			$dateOrder = strtotime(date('Y-m-d', $order->created_at) . ' 00:00:00');
			$orderDates[$order->id] = $dateOrder;
		}

		$orderGoodIds = [];
		foreach ($orderGoods as $orderGood) {
			$orderGoodIds[$orderGood->order_id][] = $orderGood->goods_id;
		}

		$goodDatesOrder = [];
		foreach ($orderDates as $orderId => $date) {
			foreach ($orderGoodIds[$orderId] as $good_id) {

				if (!isset($goodDatesOrder[$date][$good_id])) {
					$goodDatesOrder[$date][$good_id] = 0;
				}
				$goodDatesOrder[$date][$good_id] += 1;
			}
		}

		foreach ($goodAllStats as $statisticGood) {

			$good = $statisticGood->good;
			$dateName = date('d-m-y', $statisticGood->date) . ' (' . $good->name . ')';

			$arrDates[$dateName]['orders'] = 0;
			if (isset($goodDatesOrder[$statisticGood->date])) {
				foreach ($goodDatesOrder[$statisticGood->date] as $goodId => $goodCount) {
					$arrDates[$dateName]['orders'] = 0;

					if ($goodId == $good->id) {
						$arrDates[$dateName]['orders'] = $goodCount;
					}
				}
			}

			$arrDates[$dateName]['views'] = $statisticGood->views;
			$arrDates[$dateName]['added'] = $statisticGood->added;
			$arrDates[$dateName]['good'] = $good;
		}
		return array_reverse($arrDates);
	}
}
