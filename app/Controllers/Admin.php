<?php

namespace App\Controllers;

// require './vendor/autoload.php';

helper('date');

use App\Libraries\permissions;
use App\Libraries\Emails;
use App\Models\Alerts;
use App\Models\AlertStatus;
use App\Models\Users;
use App\Models\ChatMessage;
use App\Models\Deposit;
use App\Models\Payout;
use App\Models\Notifications;
use App\Models\ReturnType;
use App\Models\Singlenotification;
use App\Models\Withdraw;
use App\Models\ProfitLoss;
use Twilio\Rest\Client;
use App\Models\Currency;
use App\Models\CurrencyOption;
use App\Models\TaxForm;
use App\Models\Report;


class Admin extends BaseController
{

	public function userDashboard()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$data = [];
			$profitLoss = new ProfitLoss();
			$chat = new ChatMessage();
			$users = new Users();
			$notifications = new Notifications();
			$singleNotification = new Singlenotification();
			$deposit = new Deposit();
			$withdraw = new Withdraw();
			$payout = new Payout();
			$tax_form = new TaxForm();

			$id =  $_GET['userid'];
			$data['allChat'] = $chat->getChatByUserId($id);
			$data['profitLossDetails'] = $profitLoss->getByUserId($id);
			$data['tax_form_data'] = $tax_form->get_By_UserId($id);

			log_message('debug', '**********************Tax Form Data****************************' . var_export($data['tax_form_data'], true));

			$userInfo = $users->getrow($id);
			$data['userInfo'] = $userInfo;
			$data['id'] = $id;
			$returnType = $users->getReturnTypeId($id);
			$data['returnType'] = $returnType;

			$profit = $profitLoss->getTotalProfitById($id);
			$loss = $profitLoss->getTotalLossById($id);
			$data['profitLoss'] = $profit - $loss;
			$payoutSum = $payout->getsum($id);
			$data['payoutSum'] = $payoutSum;

			$data['lastpayout'] = $payout->getPayoutsdesc($id);
			$data['firstpayout'] = $payout->getPayoutsasc($id);

			$profitByMonth = $profitLoss->getProfitsMonthlyById($id);
			$lossByMonth = $profitLoss->getLossMonthlyById($id);

			$depositAcceptedAll = $deposit->getAcceptedDepositByUserId($id);
			$depositAcceptedAll = $depositAcceptedAll ? $depositAcceptedAll : 0;
			$payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;
			$completedWithdrawals = $withdraw->getCompletedByUserId($id);
			$payoutAll += $completedWithdrawals;
			$data['payoutAll'] = $payoutAll;
			$pendingWithdraw = $withdraw->getAllPendingByUserId($id);
			$data['pendingWithdraw'] = $pendingWithdraw;
			$totalBalance = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll + (float)$data['profitLoss']) - (float)$pendingWithdraw - (float)$payoutAll;
			$data['totalBalance'] = $totalBalance;
			$data['profitLossMonthly'] = [];
			$data['profitLossMonthly']['total'] = 0;
			$data['totalProfitNum'] = 0;
			$data['totalLossNum'] = 0;
			for ($a = 0; $a < sizeof($data['profitLossDetails']); $a++) {
				$data['profitLossDetails'][$a]['type'] == 'Profit' ? $data['totalProfitNum']++ : $data['totalLossNum']++;
			}
			log_message('debug', '**************************************************' . var_export($profitByMonth, true));
			log_message('debug', '**************************************************' . var_export($lossByMonth, true));
			$j = $k = 0;
			if (sizeof($profitByMonth) > 0 && (int)$profitByMonth[$j]['year'] < date("Y")) {
				while ($j < sizeof($profitByMonth) && (int)$profitByMonth[$j]['year'] < date("Y")) {
					$j++;
				}
			}
			if (sizeof($lossByMonth) > 0 && (int)$lossByMonth[$k]['year'] < date("Y")) {
				while ($k < sizeof($lossByMonth) && (int)$lossByMonth[$k]['year'] < date("Y")) {
					$k++;
				}
			}

			// $length = count($profitByMonth) > count($lossByMonth) ? count($profitByMonth) - $j : count($lossByMonth) - $k;
			// $data['profitLossMonthly']['len'] = $length;
			// log_message('debug','**************************************************'.var_export($profitByMonth,true));
			// log_message('debug','**************************************************'.var_export($lossByMonth,true));
			// log_message('debug','**************************************************'.$j.'  ***    '.$k);
			for ($i = 1; $i < 13; $i++) {
				if ((!empty($profitByMonth[$j]) && $i == (int)$profitByMonth[$j]['month']) || (!empty($lossByMonth[$k]) && $i == (int)$lossByMonth[$k]['month'])) {
					if ((!empty($profitByMonth[$j]) && !empty($lossByMonth[$k])) && ((int)$profitByMonth[$j]['month'] === (int)$lossByMonth[$k]['month'])) {
						$data['profitLossMonthly'][$i] = number_format(((float)$profitByMonth[$j]['amount'] - (float)$lossByMonth[$k]['amount']), 2, '.', '');
						$data['profitLossMonthly']['total'] += (($profitByMonth[$j]['amount'] - $lossByMonth[$k]['amount']));
						$j++;
						$k++;
					} else if (empty($lossByMonth[$k]) || (!empty($profitByMonth[$j]) && (int)$profitByMonth[$j]['month'] < (int)$lossByMonth[$k]['month'])) {
						$data['profitLossMonthly'][$i] = number_format((float)(($profitByMonth[$j]['amount'])), 2, '.', '');
						$data['profitLossMonthly']['total'] += (float)($profitByMonth[$j]['amount']);
						$j++;
					} else if (empty($profitByMonth[$j]) || (!empty($lossByMonth[$k]) && (int)$profitByMonth[$j]['month'] > (int)$lossByMonth[$k]['month'])) {
						$data['profitLossMonthly'][$i] = number_format((float)((($lossByMonth[$k]['amount']))), 2, '.', '') * -1;
						$data['profitLossMonthly']['total'] += (float)($lossByMonth[$k]['amount']) * -1;
						$k++;
					}
				} else {
					$data['profitLossMonthly'][$i] = 0;
				}
			}
			$data['profitLossMonthly']['total'] = $data['profitLossMonthly']['total'] ? number_format(($data['profitLossMonthly']['total']), 2, '.', '') : 0;


			if ($returnType[0]['name'] == 'noreturn') {
				$data['profitAftersplit'] = ($data['profitLoss']) * ($userInfo['payout_per'] / 100);
				// For Payout available after Split Box 
				$data['payoutAftersplit'] = $data['profitAftersplit'] - ((float)$data['payoutSum'][0]['amount']);
			} else {
				// For Profit after split
				$data['profitAftersplit'] = ($data['profitLoss'] - $userInfo['initialInvestment']) * ($userInfo['payout_per'] / 100);
				// For Payout available after Split Box 
				$data['payoutAftersplit'] = $data['profitAftersplit'] - ((float)$data['payoutSum'][0]['amount']);
			}
			// log_message('debug', '***************** Payout available after Split *****************' . var_export($data['payoutSum'][0]['amount'], true));
			$data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
			$data['callChartAdmin'] = true;
			return view('/home/customer-dashboard', $data);
		} else {
			return redirect()->to('/');
		}
	}
	public function userDashboardNew()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$data = [];
			$profitLoss = new ProfitLoss();
			$chat = new ChatMessage();
			$users = new Users();
			$notifications = new Notifications();
			$singleNotification = new Singlenotification();
			$deposit = new Deposit();
			$withdraw = new Withdraw();
			$payout = new Payout();
			$tax_form = new TaxForm();

			$id =  $_GET['userid'];
			$data['allChat'] = $chat->getChatByUserId($id);
			$data['profitLossDetails'] = $profitLoss->getByUserId($id);
			$data['tax_form_data'] = $tax_form->get_By_UserId($id);

			log_message('debug', '**********************Tax Form Data****************************' . var_export($data['tax_form_data'], true));

			$userInfo = $users->getrow($id);
			$data['userInfo'] = $userInfo;
			$data['id'] = $id;
			$returnType = $users->getReturnTypeId($id);
			$data['returnType'] = $returnType;

			$profit = $profitLoss->getTotalProfitById($id);
			$loss = $profitLoss->getTotalLossById($id);
			$data['profitLoss'] = $profit - $loss;
			$payoutSum = $payout->getsum($id);
			$data['payoutSum'] = $payoutSum;

			$data['lastpayout'] = $payout->getPayoutsdesc($id);
			$data['firstpayout'] = $payout->getPayoutsasc($id);

			$profitByMonth = $profitLoss->getProfitsMonthlyById($id);
			$lossByMonth = $profitLoss->getLossMonthlyById($id);

			$depositAcceptedAll = $deposit->getAcceptedDepositByUserId($id);
			$depositAcceptedAll = $depositAcceptedAll ? $depositAcceptedAll : 0;
			$payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;
			$completedWithdrawals = $withdraw->getCompletedByUserId($id);
			$payoutAll += $completedWithdrawals;
			$data['payoutAll'] = $payoutAll;
			$pendingWithdraw = $withdraw->getAllPendingByUserId($id);
			$data['pendingWithdraw'] = $pendingWithdraw;
			$totalBalance = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll + (float)$data['profitLoss']) - (float)$pendingWithdraw - (float)$payoutAll;
			$data['totalBalance'] = $totalBalance;
			$data['profitLossMonthly'] = [];
			$data['profitLossMonthly']['total'] = 0;
			$data['totalProfitNum'] = 0;
			$data['totalLossNum'] = 0;
			for ($a = 0; $a < sizeof($data['profitLossDetails']); $a++) {
				$data['profitLossDetails'][$a]['type'] == 'Profit' ? $data['totalProfitNum']++ : $data['totalLossNum']++;
			}
			log_message('debug', '**************************************************' . var_export($profitByMonth, true));
			log_message('debug', '**************************************************' . var_export($lossByMonth, true));
			$j = $k = 0;
			if (sizeof($profitByMonth) > 0 && (int)$profitByMonth[$j]['year'] < date("Y")) {
				while ($j < sizeof($profitByMonth) && (int)$profitByMonth[$j]['year'] < date("Y")) {
					$j++;
				}
			}
			if (sizeof($lossByMonth) > 0 && (int)$lossByMonth[$k]['year'] < date("Y")) {
				while ($k < sizeof($lossByMonth) && (int)$lossByMonth[$k]['year'] < date("Y")) {
					$k++;
				}
			}

			// $length = count($profitByMonth) > count($lossByMonth) ? count($profitByMonth) - $j : count($lossByMonth) - $k;
			// $data['profitLossMonthly']['len'] = $length;
			// log_message('debug','**************************************************'.var_export($profitByMonth,true));
			// log_message('debug','**************************************************'.var_export($lossByMonth,true));
			// log_message('debug','**************************************************'.$j.'  ***    '.$k);
			for ($i = 1; $i < 13; $i++) {
				if ((!empty($profitByMonth[$j]) && $i == (int)$profitByMonth[$j]['month']) || (!empty($lossByMonth[$k]) && $i == (int)$lossByMonth[$k]['month'])) {
					if ((!empty($profitByMonth[$j]) && !empty($lossByMonth[$k])) && ((int)$profitByMonth[$j]['month'] === (int)$lossByMonth[$k]['month'])) {
						$data['profitLossMonthly'][$i] = number_format(((float)$profitByMonth[$j]['amount'] - (float)$lossByMonth[$k]['amount']), 2, '.', '');
						$data['profitLossMonthly']['total'] += (($profitByMonth[$j]['amount'] - $lossByMonth[$k]['amount']));
						$j++;
						$k++;
					} else if (empty($lossByMonth[$k]) || (!empty($profitByMonth[$j]) && (int)$profitByMonth[$j]['month'] < (int)$lossByMonth[$k]['month'])) {
						$data['profitLossMonthly'][$i] = number_format((float)(($profitByMonth[$j]['amount'])), 2, '.', '');
						$data['profitLossMonthly']['total'] += (float)($profitByMonth[$j]['amount']);
						$j++;
					} else if (empty($profitByMonth[$j]) || (!empty($lossByMonth[$k]) && (int)$profitByMonth[$j]['month'] > (int)$lossByMonth[$k]['month'])) {
						$data['profitLossMonthly'][$i] = number_format((float)((($lossByMonth[$k]['amount']))), 2, '.', '') * -1;
						$data['profitLossMonthly']['total'] += (float)($lossByMonth[$k]['amount']) * -1;
						$k++;
					}
				} else {
					$data['profitLossMonthly'][$i] = 0;
				}
			}
			$data['profitLossMonthly']['total'] = $data['profitLossMonthly']['total'] ? number_format(($data['profitLossMonthly']['total']), 2, '.', '') : 0;
			// echo $data['profitLossMonthly']['total'];
			// exit;


			if ($returnType[0]['name'] == 'noreturn') {
				$data['profitAftersplit'] = ($data['profitLoss']) * ($userInfo['payout_per'] / 100);
				// For Payout available after Split Box 
				$data['payoutAftersplit'] = $data['profitAftersplit'] - ((float)$data['payoutSum'][0]['amount']);
			} else {
				// For Profit after split
				$data['profitAftersplit'] = ($data['profitLoss'] - $userInfo['initialInvestment']) * ($userInfo['payout_per'] / 100);
				// For Payout available after Split Box 
				$data['payoutAftersplit'] = $data['profitAftersplit'] - ((float)$data['payoutSum'][0]['amount']);
			}
			// log_message('debug', '***************** Payout available after Split *****************' . var_export($data['payoutSum'][0]['amount'], true));
			$data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
			$data['callChartAdmin'] = true;
			// return $data['profitLossMonthly'];
			// exit;
			$waveChart = $this->adminchartDetails();
			$data['waveChart'] = $waveChart;
			return view('/home/new-dashboard', $data);
		} else {
			return redirect()->to('/');
		}
	}
	// Run BY AJAX call
	public function adminTransactionChart()
	{
		log_message('debug', '***************** Transaction Chart BY Admin *****************');
		$id = $_GET['userid'];
		$data = [];
		$profitLoss = new ProfitLoss();
		$profitLossDetails = $profitLoss->getByUserId($id);
		$totalProfitNum = 0;
		$totalLossNum = 0;
		for ($a = 0; $a < sizeof($profitLossDetails); $a++) {
			$profitLossDetails[$a]['type'] == 'Profit' ? $totalProfitNum++ : $totalLossNum++;
		}

		$data['profitLoss'][0] = $totalProfitNum ? round(($totalProfitNum / sizeof($profitLossDetails)) * 100, 1) : 0;
		$data['profitLoss'][1] = $totalLossNum ? round(($totalLossNum / sizeof($profitLossDetails)) * 100, 1) : 0;

		return json_encode($data);
	}
	// Run BY AJAX call
	public function adminchartDetails()
	{
		log_message('debug', '***************** Chart BY Admin *****************');
		$id = $_GET['userid'];
		$data = [];
		$profitLoss = new ProfitLoss();
		$users = new Users();
		$payout = new Payout();
		$deposit = new Deposit();
		$withdraw = new Withdraw();
		$payoutSum = $payout->getsum($id);
		$userInfo = $users->getrow($id);
		$investmentAmount = $userInfo['initialInvestment'];

		log_message('debug', 'PLID: ' . $id);
		$ProfitAndLoss = $profitLoss->getAllProfitAndLossById($id);
		// 		$maxLoss = $profitLoss->getMaxLossById($id);
		$profit = $profitLoss->getTotalProfitById($id);
		$loss = $profitLoss->getTotalLossById($id);
		$firstpayout = $payout->getPayoutsasc($id);
		// 		$returnType = $users->getReturnTypeId($id);
		$allPayouts = $payout->getrow($id);
		$completedDeposits = $deposit->getCompletedDepositByUserId($id);
		$completedWithdrawals = $withdraw->getCompletedWithdrawalsByUserId($id);
		$amount = [];
		$dates = [];
		$totalProfit = $investmentAmount + ($profit - $loss);
		log_message('debug', 'PL1: ' . ($ProfitAndLoss[0]['amount']));

		// $data['maxLoss'] = round(($ProfitAndLoss[0]['amount']) * ($userInfo['payout_per'] / 100), 2);
		// $data['maxProfit'] = round((($totalProfit) * ($userInfo['payout_per'] / 100)) + 100, 2);
		$data['maxLoss'] = $investmentAmount + round(($ProfitAndLoss[0]['amount']), 2);
		$data['maxProfit'] = $investmentAmount + 10;
		$payoutindex = 0;
		$depositIndex = 0;
		$withdrawIndex = 0;
		// 		if ($returnType[0]['name'] == 'noreturn') {
		//  for the customers of no return investment
		$newAmount = $investmentAmount; //$completedDeposits + $completedWithdrawals;
		foreach ($ProfitAndLoss as $key => $single) {
			//   For Payouts the graph will go down as in case of loss
			if (isset($allPayouts[$payoutindex]) && $allPayouts[$payoutindex]) {
				$singlePayout = $allPayouts[$payoutindex];
				if ((strtotime($singlePayout['payoutdate']) <= strtotime($single['publishDate'])) && ($payoutindex < sizeof($allPayouts))) {
					$newAmount -= $singlePayout['amount'];
					$amount[] = round($newAmount, 2);
					$dates[] = date('M d, Y  H:i:s', strtotime(date($singlePayout['payoutdate']) . ' +11 hours'));
					$payoutindex++;
					if ($data['maxLoss'] > $newAmount) {
						$data['maxLoss'] = round($newAmount, 2);
					}
				}
			}
			// For Deposits which are accepted in this case graph will go up as in profit
			if (isset($completedDeposits[$depositIndex]) && $completedDeposits[$depositIndex]) {
				$singleDeposit = $completedDeposits[$depositIndex];
				if ((strtotime($singleDeposit['accepted_date']) <= strtotime($single['publishDate'])) && ($depositIndex < sizeof($completedDeposits))) {
					$newAmount += $singleDeposit['amount'];
					$amount[] = round($newAmount, 2);
					$dates[] = date('M d, Y  H:i:s', strtotime(date($singleDeposit['accepted_date']) . ' +1 hours'));
					$depositIndex++;
					if ($data['maxProfit'] < $newAmount) {
						$data['maxProfit'] = round($newAmount, 2);
					}
				}
			}
			// For Withdrawals which are accepted in this case graph will go down as in loss
			if (isset($completedWithdrawals[$withdrawIndex]) && $completedWithdrawals[$withdrawIndex]) {
				$singleWithdraw = $completedWithdrawals[$withdrawIndex];
				if ((strtotime($singleWithdraw['paid_date']) <= strtotime($single['publishDate'])) && ($withdrawIndex < sizeof($completedWithdrawals))) {
					$newAmount -= $singleWithdraw['amount'];
					$amount[] = round($newAmount, 2);
					$dates[] = date('M d, Y  H:i:s', strtotime(date($singleWithdraw['paid_date']) . ' +5 hours'));
					$withdrawIndex++;
					if ($data['maxLoss'] > $newAmount) {
						$data['maxLoss'] = round($newAmount, 2);
					}
				}
			}

			if ($single['type'] == 'Loss') {
				// $newAmount -=  ($single['amount']) * ($userInfo['payout_per'] / 100);
				$newAmount -= $single['amount'];
				if ($data['maxLoss'] > $newAmount) {
					$data['maxLoss'] = round($newAmount, 2);
				}
				$amount[] = round($newAmount, 2);
			} else {
				// $newAmount += ($single['amount']) * ($userInfo['payout_per'] / 100);
				$newAmount += $single['amount'];
				$amount[] = round($newAmount, 2);
				if ($data['maxProfit'] < $newAmount) {
					$data['maxProfit'] = round($newAmount, 2);
				}
			}
			$dates[] = date('M d, Y  H:i:s', strtotime($single['publishDate'] . ' +11 hours'));
		}
		while (isset($allPayouts[$payoutindex]) && $allPayouts[$payoutindex]) {
			$singlePayout = $allPayouts[$payoutindex];
			$newAmount -= $singlePayout['amount'];
			$amount[] = round($newAmount, 2);
			$dates[] = date('M d, Y  H:i:s', strtotime(date($singlePayout['payoutdate']) . ' +11 hours'));
			$payoutindex++;
			if ($data['maxLoss'] > $newAmount) {
				$data['maxLoss'] = round($newAmount, 2);
			}
		}
		// 		} else {
		// 			//  for the customer of return full investment
		// 			$newAmount = 0;
		// 			$check = false;
		// 			$tempProfitLoss = 0;
		// 			foreach ($ProfitAndLoss as $key => $single) {
		// 				$singlePayout = '';
		// 				if ($payoutindex < sizeof($allPayouts)) {
		// 					$singlePayout = $allPayouts[$payoutindex];
		// 				}
		// 				if ($tempProfitLoss >= $investmentAmount) {
		// 					if ($check) {
		// 						// $balanceAmount = ($single['amount']) * ($userInfo['payout_per'] / 100);
		// 						$balanceAmount = $single['amount'];
		// 					} else {
		// 						$check = true;
		// 						// $splitAboveInvestment = ($newAmount - $investmentAmount) * ($userInfo['payout_per'] / 100);
		// 						$splitAboveInvestment = ($newAmount - $investmentAmount);
		// 						$newAmount = $investmentAmount + $splitAboveInvestment;
		// 						$amount[$key - 1] = round($newAmount, 2);
		// 						// $balanceAmount = ($single['amount']) * ($userInfo['payout_per'] / 100);
		// 						$balanceAmount = $single['amount'];
		// 					}
		// 				} else {
		// 					$balanceAmount = $single['amount'];
		// 				}

		// 				if (($payoutindex < sizeof($allPayouts)) && (strtotime($singlePayout['payoutdate']) <= strtotime($single['publishDate']))) {
		// 					$newAmount -= $singlePayout['amount'];
		// 					$amount[] = round($newAmount, 2);
		// 					$dates[] = date('M d, Y  H:i:s', strtotime(date($singlePayout['payoutdate']) . '11:00:00'));
		// 					$payoutindex++;
		// 					if ($data['maxLoss'] > $newAmount) {
		// 						$data['maxLoss'] = round($newAmount, 2);
		// 					}
		// 				}
		// 				if ($single['type'] == 'Loss') {
		// 					$newAmount -=  $balanceAmount;
		// 					if ($data['maxLoss'] > $newAmount) {
		// 						$data['maxLoss'] = round($newAmount, 2);
		// 					}
		// 					$amount[] = round($newAmount, 2);
		// 					$tempProfitLoss -=  $balanceAmount;
		// 				} else {
		// 					$newAmount += $balanceAmount;
		// 					$amount[] = round($newAmount, 2);
		// 					$tempProfitLoss += $balanceAmount;
		// 					if ($data['maxProfit'] < $newAmount) {
		// 						$data['maxProfit'] = round($newAmount, 2);
		// 					}
		// 				}
		// 				$dates[] = date('M d, Y  H:i:s', strtotime($single['publishDate']));
		// 			}
		// 		}
		// log_message('debug', '***************** Chart BY Admin *****************' . $firstpayout['amount']);


		$data['amounts'] = $amount;
		$data['dates'] = $dates;

		return json_encode($data);
	}
	public function adminchartDetailsNew()
	{
		log_message('debug', '***************** Chart BY Admin *****************');
		$id = $_GET['userid'];
		$data = [];
		$profitLoss = new ProfitLoss();
		$users = new Users();
		$payout = new Payout();
		$deposit = new Deposit();
		$withdraw = new Withdraw();
		$payoutSum = $payout->getsum($id);
		$userInfo = $users->getrow($id);
		$investmentAmount = $userInfo['initialInvestment'];

		log_message('debug', 'PLID: ' . $id);
		$ProfitAndLoss = $profitLoss->getAllProfitAndLossById($id);
		// 		$maxLoss = $profitLoss->getMaxLossById($id);
		$profit = $profitLoss->getTotalProfitById($id);
		$loss = $profitLoss->getTotalLossById($id);
		$firstpayout = $payout->getPayoutsasc($id);
		// 		$returnType = $users->getReturnTypeId($id);
		$allPayouts = $payout->getrow($id);
		$completedDeposits = $deposit->getCompletedDepositByUserId($id);
		$completedWithdrawals = $withdraw->getCompletedWithdrawalsByUserId($id);
		$amount = [];
		$dates = [];
		$totalProfit = $investmentAmount + ($profit - $loss);
		log_message('debug', 'PL1: ' . ($ProfitAndLoss[0]['amount']));

		// $data['maxLoss'] = round(($ProfitAndLoss[0]['amount']) * ($userInfo['payout_per'] / 100), 2);
		// $data['maxProfit'] = round((($totalProfit) * ($userInfo['payout_per'] / 100)) + 100, 2);
		$data['maxLoss'] = $investmentAmount + round(($ProfitAndLoss[0]['amount']), 2);
		$data['maxProfit'] = $investmentAmount + 10;
		$payoutindex = 0;
		$depositIndex = 0;
		$withdrawIndex = 0;
		// 		if ($returnType[0]['name'] == 'noreturn') {
		//  for the customers of no return investment
		$newAmount = $investmentAmount; //$completedDeposits + $completedWithdrawals;
		foreach ($ProfitAndLoss as $key => $single) {
			//   For Payouts the graph will go down as in case of loss
			if (isset($allPayouts[$payoutindex]) && $allPayouts[$payoutindex]) {
				$singlePayout = $allPayouts[$payoutindex];
				if ((strtotime($singlePayout['payoutdate']) <= strtotime($single['publishDate'])) && ($payoutindex < sizeof($allPayouts))) {
					$newAmount -= $singlePayout['amount'];
					$amount[] = round($newAmount, 2);
					$dates[] = date('M d, Y  H:i:s', strtotime(date($singlePayout['payoutdate']) . ' +11 hours'));
					$payoutindex++;
					if ($data['maxLoss'] > $newAmount) {
						$data['maxLoss'] = round($newAmount, 2);
					}
				}
			}
			// For Deposits which are accepted in this case graph will go up as in profit
			if (isset($completedDeposits[$depositIndex]) && $completedDeposits[$depositIndex]) {
				$singleDeposit = $completedDeposits[$depositIndex];
				if ((strtotime($singleDeposit['accepted_date']) <= strtotime($single['publishDate'])) && ($depositIndex < sizeof($completedDeposits))) {
					$newAmount += $singleDeposit['amount'];
					$amount[] = round($newAmount, 2);
					$dates[] = date('M d, Y  H:i:s', strtotime(date($singleDeposit['accepted_date']) . ' +1 hours'));
					$depositIndex++;
					if ($data['maxProfit'] < $newAmount) {
						$data['maxProfit'] = round($newAmount, 2);
					}
				}
			}
			// For Withdrawals which are accepted in this case graph will go down as in loss
			if (isset($completedWithdrawals[$withdrawIndex]) && $completedWithdrawals[$withdrawIndex]) {
				$singleWithdraw = $completedWithdrawals[$withdrawIndex];
				if ((strtotime($singleWithdraw['paid_date']) <= strtotime($single['publishDate'])) && ($withdrawIndex < sizeof($completedWithdrawals))) {
					$newAmount -= $singleWithdraw['amount'];
					$amount[] = round($newAmount, 2);
					$dates[] = date('M d, Y  H:i:s', strtotime(date($singleWithdraw['paid_date']) . ' +5 hours'));
					$withdrawIndex++;
					if ($data['maxLoss'] > $newAmount) {
						$data['maxLoss'] = round($newAmount, 2);
					}
				}
			}

			if ($single['type'] == 'Loss') {
				// $newAmount -=  ($single['amount']) * ($userInfo['payout_per'] / 100);
				$newAmount -= $single['amount'];
				if ($data['maxLoss'] > $newAmount) {
					$data['maxLoss'] = round($newAmount, 2);
				}
				$amount[] = round($newAmount, 2);
			} else {
				// $newAmount += ($single['amount']) * ($userInfo['payout_per'] / 100);
				$newAmount += $single['amount'];
				$amount[] = round($newAmount, 2);
				if ($data['maxProfit'] < $newAmount) {
					$data['maxProfit'] = round($newAmount, 2);
				}
			}
			$dates[] = date('M d, Y  H:i:s', strtotime($single['publishDate'] . ' +11 hours'));
		}
		while (isset($allPayouts[$payoutindex]) && $allPayouts[$payoutindex]) {
			$singlePayout = $allPayouts[$payoutindex];
			$newAmount -= $singlePayout['amount'];
			$amount[] = round($newAmount, 2);
			$dates[] = date('M d, Y  H:i:s', strtotime(date($singlePayout['payoutdate']) . ' +11 hours'));
			$payoutindex++;
			if ($data['maxLoss'] > $newAmount) {
				$data['maxLoss'] = round($newAmount, 2);
			}
		}
		// 		} else {
		// 			//  for the customer of return full investment
		// 			$newAmount = 0;
		// 			$check = false;
		// 			$tempProfitLoss = 0;
		// 			foreach ($ProfitAndLoss as $key => $single) {
		// 				$singlePayout = '';
		// 				if ($payoutindex < sizeof($allPayouts)) {
		// 					$singlePayout = $allPayouts[$payoutindex];
		// 				}
		// 				if ($tempProfitLoss >= $investmentAmount) {
		// 					if ($check) {
		// 						// $balanceAmount = ($single['amount']) * ($userInfo['payout_per'] / 100);
		// 						$balanceAmount = $single['amount'];
		// 					} else {
		// 						$check = true;
		// 						// $splitAboveInvestment = ($newAmount - $investmentAmount) * ($userInfo['payout_per'] / 100);
		// 						$splitAboveInvestment = ($newAmount - $investmentAmount);
		// 						$newAmount = $investmentAmount + $splitAboveInvestment;
		// 						$amount[$key - 1] = round($newAmount, 2);
		// 						// $balanceAmount = ($single['amount']) * ($userInfo['payout_per'] / 100);
		// 						$balanceAmount = $single['amount'];
		// 					}
		// 				} else {
		// 					$balanceAmount = $single['amount'];
		// 				}

		// 				if (($payoutindex < sizeof($allPayouts)) && (strtotime($singlePayout['payoutdate']) <= strtotime($single['publishDate']))) {
		// 					$newAmount -= $singlePayout['amount'];
		// 					$amount[] = round($newAmount, 2);
		// 					$dates[] = date('M d, Y  H:i:s', strtotime(date($singlePayout['payoutdate']) . '11:00:00'));
		// 					$payoutindex++;
		// 					if ($data['maxLoss'] > $newAmount) {
		// 						$data['maxLoss'] = round($newAmount, 2);
		// 					}
		// 				}
		// 				if ($single['type'] == 'Loss') {
		// 					$newAmount -=  $balanceAmount;
		// 					if ($data['maxLoss'] > $newAmount) {
		// 						$data['maxLoss'] = round($newAmount, 2);
		// 					}
		// 					$amount[] = round($newAmount, 2);
		// 					$tempProfitLoss -=  $balanceAmount;
		// 				} else {
		// 					$newAmount += $balanceAmount;
		// 					$amount[] = round($newAmount, 2);
		// 					$tempProfitLoss += $balanceAmount;
		// 					if ($data['maxProfit'] < $newAmount) {
		// 						$data['maxProfit'] = round($newAmount, 2);
		// 					}
		// 				}
		// 				$dates[] = date('M d, Y  H:i:s', strtotime($single['publishDate']));
		// 			}
		// 		}
		// log_message('debug', '***************** Chart BY Admin *****************' . $firstpayout['amount']);


		$data['amounts'] = $amount;
		$data['dates'] = $dates;

		return json_encode($data);
	}
	public function dashboard()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$data = [];
			$users = new Users();
			$id =  $_SESSION['user_data']['id'];
			$alert_status = new AlertStatus();
			$profitLoss = new ProfitLoss();
			$data['allUsers'] = $users->getCustomers();
			$data['notification'] = $alert_status->getCurrentAlertNotificationById($id);
			// echo "<pre>" ;
			// print_r($data['notification']) ;
			// die ;
			foreach ($data['allUsers'] as $singleuser) {
				$profit = $profitLoss->getTotalProfitById($singleuser['id']);
				$loss = $profitLoss->getTotalLossById($singleuser['id']);
				$data['profitLoss'][] = $profit - $loss;
			}
			return view('/home/admin-dashboard', $data);
		} else {
			return redirect()->to('/');
		}
	}
	public function customerdetails()
	{


		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$data = [];
			$users = new Users();
			$payout = new Payout();
			$profitLoss = new ProfitLoss();
			$chat = new ChatMessage();
			$payoutInfo = $payout->getrow($_GET['userid']);
			$data['payoutInfo'] = $payoutInfo;
			// log_message('debug', '***************** Payout *****************' . var_export($data['payoutInfo']));
			$data['allChat'] = $chat->getChatByUserId($_GET['userid']);
			$data['profileData'] = $users->getrow($_GET['userid']);
			$data['userDetails'] = $users->getrow($_GET['userid']);
			// log_message('debug', '***************** Payout *****************' . var_export($data['userDetails'], true));
			$data['profitLossDetails'] = $profitLoss->getByUserId($_GET['userid']);
			return view('/home/customer-info', $data);
		} else {
			return redirect()->to('/');
		}
	}

	public function addScheduleProfitLoss()
	{
		$users = new Users();
		$withdraw = new withdraw();
		$deposit = new Deposit();
		$payout = new Payout();
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$responsePost = $_POST['data']['json'];
			$json_decoded_array = json_decode($responsePost);
			if (isset($_POST['json'])) {

				log_message('debug', '***************** json received *****************');
			}
			// log_message('debug', '***************** Add Profit/Loss Amount *****************' . var_export($json_decoded_array->item, true));

			$profitLoss = new ProfitLoss();
			$id =  $json_decoded_array->id;
			foreach ($json_decoded_array->item as $singleItem) {
				$checkDate = $profitLoss->getByDate($id, $singleItem->date);
				log_message('debug', "juygefybrdjgf" . var_export($checkDate, true));
				// For get current balance
				$userInfo = $users->getrow($id);
				$profit = $profitLoss->getTotalProfitById($id);
				$loss = $profitLoss->getTotalLossById($id);
				$pendingWithdraw = $withdraw->getAllPendingByUserId($id);
				$allProfitLoss = $profit - $loss;
				$payoutSum = $payout->getsum($id);
				$depositAcceptedAll = $deposit->getAcceptedDepositByUserId($id);
				$depositAcceptedAll = $depositAcceptedAll ? $depositAcceptedAll : 0;
				$payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;
				$completedWithdrawals = $withdraw->getCompletedByUserId($id);
				$payoutAll += $completedWithdrawals;
				$totalBalance = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll + (float)$allProfitLoss) - (float)$pendingWithdraw - (float)$payoutAll;

				if ($checkDate) {
					$updateDate = date('Y-m-d H:i:s', strtotime($singleItem->date . '+0 hours'));
					// update profit/loss
					$profitLoss->update($checkDate[0]['id'], [
						'amount' => $singleItem->amount,
						'type' => $singleItem->action,
						'publishDate' => $updateDate,
						'current_balance' => $totalBalance,
						'schedule' => 'Y',
					]);
				} else {
					log_message('debug', "no");
					$insertDate = date('Y-m-d H:i:s', strtotime($singleItem->date . '+0 hours'));

					// Insert/save profit loss
					$data = [
						'userid' => $json_decoded_array->id,
						'amount' => $singleItem->amount,
						'type' => $singleItem->action,
						'publishDate' => $insertDate,
						'current_balance' => $totalBalance,
						'schedule' => 'Y',

					];
					$profitLoss->save($data);
				}
			}

			return json_encode(base_url() . '/admin/scheduleProfitLoss?userid=' . $id);
		} else {
			return redirect()->to('/');
		}
	}
	public function getUserAmount()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$responsePost = $_POST['data']['json'];
			$profitLoss = new ProfitLoss();
			$chat = new ChatMessage();
			$users = new Users();
			$payout = new Payout();
			$notifications = new Notifications();
			$singleNotification = new Singlenotification();
			$deposit = new Deposit();
			$withdraw = new Withdraw();
			$userInfo = $users->getrow($responsePost['userId']);
			$payoutSum = $payout->getsum($responsePost['userId']);
			$profit = $profitLoss->getTotalProfitById($responsePost['userId']);
			$loss = $profitLoss->getTotalLossById($responsePost['userId']);
			$data['profitLoss'] = $profit - $loss;
			$data['firstpayout'] = $payout->getPayoutsasc($responsePost['userId']);
			$profitByMonth = $profitLoss->getProfitsMonthlyById($responsePost['userId']);
			$lossByMonth = $profitLoss->getLossMonthlyById($responsePost['userId']);

			$depositAcceptedAll = $deposit->getAcceptedDepositByUserId($responsePost['userId']);
			$depositAcceptedAll = $depositAcceptedAll ? $depositAcceptedAll : 0;
			$payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;
			$completedWithdrawals = $withdraw->getCompletedByUserId($responsePost['userId']);
			$payoutAll += $completedWithdrawals;
			$pendingWithdraw = $withdraw->getAllPendingByUserId($responsePost['userId']);
			$totalBalance = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll + (float)$data['profitLoss']) - (float)$pendingWithdraw - (float)$payoutAll;

			$currentAmount = ($totalBalance);
			return json_encode($currentAmount);
		} else {
			return redirect()->to('/');
		}
	}
	public function addBulkUpdate()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$responsePost = $_POST['data']['json'];
			$json_decoded_array = json_decode($responsePost);
			if (isset($_POST['data']['json'])) {

				log_message('debug', '***************** json received *****************');
			}
			//log_message('debug', '***************** Add Profit/Loss Amount *****************' . var_export($json_decoded_array->item, true));

			$profitLoss = new ProfitLoss();
			$users = new Users();
			$payout = new Payout();
			$deposit = new Deposit();
			$withdraw = new Withdraw();
			foreach ($json_decoded_array->item as $singleItem) {
				$checkDate = $profitLoss->getByDate($singleItem->id, $singleItem->date);
				// For get current balance
				$id = $singleItem->id;
				$userInfo = $users->getrow($id);
				$profit = $profitLoss->getTotalProfitById($id);
				$loss = $profitLoss->getTotalLossById($id);
				$pendingWithdraw = $withdraw->getAllPendingByUserId($id);
				$allProfitLoss = $profit - $loss;
				$payoutSum = $payout->getsum($id);
				$depositAcceptedAll = $deposit->getAcceptedDepositByUserId($id);
				$depositAcceptedAll = $depositAcceptedAll ? $depositAcceptedAll : 0;
				$payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;
				$completedWithdrawals = $withdraw->getCompletedByUserId($id);
				$payoutAll += $completedWithdrawals;
				$totalBalance = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll + (float)$allProfitLoss) - (float)$pendingWithdraw - (float)$payoutAll;

				log_message('debug', "juygefybrdjgf" . var_export($checkDate, true));

				if ($checkDate) {
					$updateDate = date('Y-m-d H:i:s', strtotime($singleItem->date . '+0 hours'));
					// update profit/loss
					$profitLoss->update($checkDate[0]['id'], [
						'percentage' => $singleItem->percentage,
						'amount' => $singleItem->amount,
						'type' => $singleItem->action,
						'current_balance' => $totalBalance,
						'publishDate' => $updateDate,
					]);
				} else {
					log_message('debug', "no");
					$insertDate = date('Y-m-d H:i:s', strtotime($singleItem->date . '+0 hours'));

					// Insert/save profit loss
					$data = [
						'userid' => $singleItem->id,
						'amount' => $singleItem->amount,
						'percentage' => $singleItem->percentage,
						'type' => $singleItem->action,
						'current_balance' => $totalBalance,
						'publishDate' => $insertDate,
					];
					$profitLoss->save($data);
				}
			}

			return json_encode(base_url() . '/admin/bulkUpdate');
		} else {
			return redirect()->to('/');
		}
	}

	public function bulkUpdaterecord()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$responsePost = $_POST['data'];
			//	log_message('debug', '***************** Add Profit/Loss Amount *****************' . var_export($responsePost, true));

			$data = [];
			$users = new Users();
			//$profitLoss = new ProfitLoss();
			//$data['bulkData'] = $users->getCustomers();

			$data['bulkData'] = $users->DataforBulkUpdate($responsePost['date']);
			//log_message('debug', '***************** Schedule Profit/Loss Amount88 *****************' . var_export($responsePost['date'], true));
			return json_encode($data);
		} else {
			return redirect()->to('/');
		}
	}

	public function bulkUpdate()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			//log_message('debug', '***************** Bulk Update Profit/Loss *****************' . date("Y-m-d", strtotime(date("Y-m-d"))));
			$data = [];
			$users = new Users();
			$id =  $_SESSION['user_data']['id'];
			$alert_status = new AlertStatus();
			$data['bulkData'] = $users->DataforBulkUpdate(date("Y-m-d", strtotime(date("Y-m-d"))));
			//log_message('debug', '***************** Schedule Profit/Loss Amount *****************' . var_export($data['bulkData'], true));
			$data['notification'] = $alert_status->getCurrentAlertNotificationById($id);
			return view('/home/updateBulkRecords', $data);
		} else {
			return redirect()->to('/');
		}
	}

	public function scheduleProfitLoss()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			// log_message('debug', '***************** Schedule Profit/Loss Amount *****************');
			$data = [];
			$users = new Users();
			$profitLoss = new ProfitLoss();
			$data['userId'] = $_GET['userid'];
			$data['profitLossData'] = $profitLoss->getByUserIdAndDate($_GET['userid']);
			// log_message('debug', '***************** Schedule Profit/Loss Amount *****************' . var_export($data, true));
			return view('/home/schedulePage', $data);
		} else {
			return redirect()->to('/');
		}
	}

	public function addInvestment()
	{
		// log_message('debug', '***************** Update Investment Amount *****************');

		$users = new Users();
		$users->update($_POST['id'], [
			'initialInvestment' => $_POST['amount'],
			// 'transactionType' => $_POST['transaction'],
			// 'returntype_id' => $_POST['payout'],
			// 'payoutDate' => $_POST['payoutdate'],
			// 'payout_per' => $_POST['payout_per'],
			// 'nextpayoutDate' => $_POST['nextpayoutdate'],
			'updatedAt' => date('Y-m-d H:i:s'),
			'flagfor_accountant' => $_POST['showtoaccount'],
		]);
		return redirect()->to('/admin/customerdetails?userid=' . $_POST['id']);
	}
	public function addPayouts()
	{
		// log_message('debug', '***************** Update Investment Amount *****************');

		$pauout = new Payout();
		$pauout->save([
			'user_id' => $_POST['id'],
			'amount' => $_POST['amount'],
			'payoutdate' => $_POST['payoutdate'],
		]);
		return redirect()->to('/admin/customerdetails?userid=' . $_POST['id']);
	}

	public function deletePayouts()
	{
		$pauout = new Payout();
		$pauout->delete($_GET['id']);
		return redirect()->to('/admin/customerdetails?userid=' . $_GET['userid']);
	}

	public function editPayout()
	{
		// log_message('debug', '***************** Edit PayOut Amount *****************' . var_export($_GET, true));


		$pauout = new Payout();

		$pauout->update($_GET['id'], [
			'user_id' => $_POST['user_id'],
			'amount' => $_POST['amount'],
			'payoutdate' => $_POST['payoutdate'],
		]);
		log_message('debug', '***************** PayOut Amount succefuly Edited in database *****************');
		return redirect()->to('/admin/customerdetails?userid=' . $_POST['user_id']);
	}

	public function addProfitLoss()
	{
		log_message('debug', '***************** Add Profit/Loss Amount *****************');
		$profitFound = array(
			'status' => true,
			'message' => '* Record already exist on this date you can only update or delete a record once a record is added.'
		);
		$profitLoss = new ProfitLoss();
		$newdate = date('Y-m-d', strtotime($_POST['date']));
		$profitResult = $profitLoss->getByDate($_POST['id'], $newdate);
		$creationDate = date('Y-m-d H:i:s', strtotime($_POST['date'] . '+0 hours'));
		log_message('debug', $newdate);
		log_message('debug', var_export($profitResult, true));
		$id = $_POST['id'];
		$users = new Users();
		$payout = new Payout();
		$deposit = new Deposit();
		$withdraw = new Withdraw();
		$data = [];
		$userInfo = $users->getrow($id);
		$profit = $profitLoss->getTotalProfitById($id);
		$loss = $profitLoss->getTotalLossById($id);
		$pendingWithdraw = $withdraw->getAllPendingByUserId($id);
		$data['profitLoss'] = $profit - $loss;
		$depositAcceptedAll = $deposit->getAcceptedDepositByUserId($id);
		$payoutSum = $payout->getsum($id);
		$depositAcceptedAll = $depositAcceptedAll ? $depositAcceptedAll : 0;
		$payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;
		$completedWithdrawals = $withdraw->getCompletedByUserId($id);
		$payoutAll += $completedWithdrawals;
		$totalBalance = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll + (float)$data['profitLoss']) - (float)$pendingWithdraw - (float)$payoutAll;
		if ($profitResult != NULL) {
			return json_encode($profitFound);
		} else {
			$profitLoss->save([
				'userid' => $_POST['id'],
				'type' => $_POST['action'],
				'amount' => $_POST['amount'],
				'current_balance' => $totalBalance,
				'publishDate' => $creationDate,
			]);
			return json_encode(base_url() . '/admin/customerdetails?userid=' . $_POST['id']);
		}
		// return redirect()->to('/admin/customerdetails?userid=' . $_POST['id']);
	}
	public function deleteProfit()
	{
		$profitLoss = new ProfitLoss();
		$profitLoss->delete($_GET['id']);
		return redirect()->to('/admin/customerdetails?userid=' . $_GET['userid']);;
	}
	public function editProfile()
	{
		$message = array(
			'status' => false,
			'message' => '* Email or Phone already exists on this date'
		);
		log_message('debug', '***************** Edit Profile *****************');
		$users = new Users();
		$emailExist = $users->emailExist($_POST['email']);
		$phoneExist = $users->phoneExist($_POST['phone']);
		// log_message('debug', '***************** Edit Profile DATA *****************' . $phoneExist[0]['phone']);
		// log_message('debug', '***************** Profit/Loss Amount succefuly Edit in database *****************' . var_export($profitResult, true));
		// return redirect()->to('/admin/customerdetails?userid=' . $_POST['id']);
		if ((isset($emailExist[0]['email']) && $emailExist[0]['email'] != null && $emailExist[0]['id'] != $_POST['userid'])) {
			log_message('debug', '***************** Edit Profile DATA *****************' . $emailExist[0]['email']);
			return json_encode($message);
		} elseif ((isset($phoneExist[0]['phone']) && $phoneExist[0]['phone'] != null && $phoneExist[0]['id'] != $_POST['userid'])) {
			log_message('debug', '***************** Edit Profile DATA *****************' . $emailExist[0]['email']);
			return json_encode($message);
		} else {
			$users->update($_POST['userid'], [
				'firstName' => $_POST['firstName'],
				'lastName' => $_POST['lastName'],
				'email' => $_POST['email'],
				'phone' => $_POST['phone'],
			]);
			return json_encode(base_url() . '/admin/customerdetails?userid=' . $_POST['userid']);
		}
	}

	public function editProfitLoss()
	{
		$message = array(
			'status' => false,
			'message' => '* Record already exists on this date'
		);
		// log_message('debug', '***************** Edit Profit/Loss Amount *****************' . base_url());
		$profitLoss = new ProfitLoss();
		$users = new Users();
		$payout = new Payout();
		$deposit = new Deposit();
		$withdraw = new Withdraw();
		$newdate = date('Y-m-d', strtotime($_POST['date']));
		$profitResult = $profitLoss->getByDate($_POST['userid'], $newdate);
		$creationDate = date('Y-m-d H:i:s', strtotime($_POST['date'] . '+0 hours'));
		log_message('debug', $newdate);
		log_message('debug', 'record Found' . var_export($profitResult, true));

		// For get current balance
		$id = $_POST['userid'];
		$userInfo = $users->getrow($id);
		$profit = $profitLoss->getTotalProfitById($id);
		$loss = $profitLoss->getTotalLossById($id);
		$pendingWithdraw = $withdraw->getAllPendingByUserId($id);
		$allProfitLoss = $profit - $loss;
		$depositAcceptedAll = $deposit->getAcceptedDepositByUserId($id);
		$depositAcceptedAll = $depositAcceptedAll ? $depositAcceptedAll : 0;
		$payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;
		$completedWithdrawals = $withdraw->getCompletedByUserId($id);
		$payoutAll += $completedWithdrawals;
		$totalBalance = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll + (float)$allProfitLoss) - (float)$pendingWithdraw - (float)$payoutAll;


		// log_message('debug', '***************** Profit/Loss Amount succefuly Edit in database *****************' . var_export($profitResult, true));
		// return redirect()->to('/admin/customerdetails?userid=' . $_POST['id']);
		if (isset($profitResult) && $profitResult != null && $profitResult[0]['id'] != $_POST['profit_id']) {
			return json_encode($message);
		} else {
			$profitLoss->update($_POST['profit_id'], [
				'type' => $_POST['action'],
				'amount' => $_POST['amount'],
				'current_balance' => $totalBalance,
				'publishDate' => $creationDate
			]);
			return json_encode(base_url() . '/admin/customerdetails?userid=' . $_POST['userid']);
		}
	}

	public function submitMessage()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$chat = new ChatMessage();
			$chat->save([
				'msgFrom' => 'Admin',
				'msgTo' => $_POST['userid'],
				'message' => $_POST['sendingMesage']
			]);
			return redirect()->to('/admin/customerdetails?userid=' . $_POST['userid']);
		} else {
			return redirect()->to('/');
		}
	}

	public function createuser()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$id =  $_SESSION['user_data']['id'];
			$alert_status = new AlertStatus();
			$data['notification'] = $alert_status->getCurrentAlertNotificationById($id);
			return view('/home/createUser', $data);
		} else {
			return redirect()->to('/');
		}
	}
	public function usercreatedsuccess()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$title = "New User Created";
			$message = "New user created. Email with password successfully sent to the user.";
			$data = [];
			$data['title'] = $title;
			$data['message'] = $message;
			return redirect()->to('/admin/dashboard?success=true');
		} else {
			return redirect()->to('/');
		}
	}
	public function updateBulkRecord()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			return view('/home/updateBulkRecords');
		} else {
			return redirect()->to('/');
		}
	}
	public function notifications()
	{
		
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$id =  $_SESSION['user_data']['id'];
			$notification = new Notifications();
			$alert_status = new AlertStatus();
			$data = [];
			$data['allNotifications'] = $notification->getdata();
			$data['notification'] = $alert_status->getCurrentAlertNotificationById($id);
			return view('/home/notificationpage', $data);
		} else {
			return redirect()->to('/');
		}
	}
	public function addnotification()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		$users = new Users();
		$id =  $_SESSION['user_data']['id'];
		$notification = new Notifications();
		$alert_status = new AlertStatus();
		$data = [];
		$data['allNotifications'] = $notification->getdata();
		$data['notification'] = $alert_status->getCurrentAlertNotificationById($id);
		$data['userData'] = $users->getDataForNotification();
		if ($response == true) {
			return view('/home/addnotification', $data);
		} else {
			return redirect()->to('/');
		}
	}
	public function updatenotification()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$notification = new Notifications();
			$data = [];
			$data['notificationInfo'] = $notification->getrow($_GET['id']);
			//log_message('debug', '***************** Profit/Loss Amount succefuly added in database *****************' . var_export($data['notificationInfo'], true));
			return view('/home/addnotification', $data);
		} else {
			return redirect()->to('/');
		}
	}
	public function updatenotificationData()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$notification = new Notifications();
			//$data = [];
			//$data['notificationInfo'] = $notification->getrow($_GET['id']);
			$notification->update($_GET['id'], [
				'title' => $_POST['title'],
				'description' => $_POST['description'],
				'status' => $_POST['status'],
			]);

			//log_message('debug', '***************** Profit/Loss Amount succefuly added in database *****************' . var_export($data['notificationInfo'], true));
			return redirect()->to('/admin/updatenotification?id=' . $_GET['id']);
		} else {
			return redirect()->to('/');
		}
	}
	public function submitnotification()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$notification = new Notifications();
			$singleNotification = new Singlenotification();
			$users = new Users();
			$emailsss = new Emails();
			// $date = $_POST['date'] . " " . date("h:i:s");
			$date = date("Y-m-d h:i:s");
			// $_POST['forSingelNoti'];
			$userId = $users->getAllid();

			$notification->save([
				'title' => $_POST['title'],
				'description' => $_POST['description'],
				'status' => $_POST['status'],
				'publishDate' => $date,
			]);
			$notificationId = $notification->get_last_data_id();
			// log_message('debug', '***************** UN Session_ID *****************' . var_export($_POST,true));
			if ($_POST['forSingelNoti'] != 'alluser') {
				$singleNotification->save([
					'user_id' => $_POST['forSingelNoti'],
					'notification_id' => $notificationId['id'],
				]);
				$this->sendNotification($_POST['title'], $_POST['description'], $_POST['forSingelNoti']);
			} else {
				$userId = $users->getAllid();
				foreach ($userId as $singleId) {
					$singleNotification->save([
						'user_id' => $singleId['id'],
						'notification_id' => $notificationId['id'],
					]);
					$this->sendNotification($_POST['title'], $_POST['description'], $singleId['id']);
				}
			}
			$notification = $_POST['description'];


			//log_message('debug', '***************** UN Session_ID *****************' . $_POST['date']);

			// if (date('Y-m-d') >= $_POST['date']) {
			// if ($_POST['forSingelNoti'] == 'alluser') {
			// 	$users->update($users, [
			// 		'notificationStatus' => 'unread',
			// 	]);
			// 	$allUserEmails = $users->getAllemail();
			// 	for ($i = 0; $i < sizeof($allUserEmails); $i++) {
			// 		$email = $allUserEmails[$i]['email'];
			// 		$emailsss->sendNotification($email, $notification);
			// 	}
			// } else {
			// 	$users->update($_POST['forSingelNoti'], [
			// 		'notificationStatus' => 'unread',
			// 	]);
			// 	$UserEmail = $users->getAllemailfornotifi($_POST['forSingelNoti']);
			// 	$emailsss->sendNotification($UserEmail[0]['email'], $notification);
			// }
			// }

			return redirect()->to('/admin/notifications?success=true');
		} else {
			return redirect()->to('/');
		}
	}
	public function deleteUser()
	{
		$users = new Users();
		$users->update($_GET['userid'], [
			'isDeleted' => 'Y',
		]);
		$userdata = $users->getrow($_GET['userid']);
		if (isset($userdata['sessionid'])) {
			session_id($userdata['sessionid']);
			session_start();
			session_destroy();
			$adminData = $users->getrow($_GET['adminid']);
			session_id($adminData['sessionid']);
			session_start();
			//		log_message('debug', '***************** UN Session_ID *****************' . $userdata['sessionid']);
		}
		return redirect()->to('/admin/dashboard');
	}
	public function notificationcount()
	{
		$singleNotification = new Singlenotification();
		$data['notification'] = $singleNotification->getCurrentDataNotificationsByUserIdCount($_POST['id']);
		$count = sizeof($data['notification']);
		//log_message('debug', '**************** UN Session_ID ****************' . sizeof($data['notification']));

		return json_encode($count);
	}
	public function alertnotificationcount()
	{
		$alert_status = new AlertStatus();
		$data = $alert_status->getCurrentAlertNotificationsByIdCount($_POST['id']);
		$count = sizeof($data);
		log_message('debug', '**************** Admin Session_ID ****************' . var_export($data, true));

		return json_encode($count);
	}
	public function updateNotificationStatus()
	{
		$singleNotification = new Singlenotification();
		$data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($_POST['id']);
		// log_message('debug', '**************** UN Session_ID ****************' . $data['notification'][0]['id']);
		if (isset($data['notification'])) {
			for ($i = 0; $i < sizeof($data['notification']); $i++) {
				$singleNotification->update($data['notification'][$i]['id'], [
					'is_read' => 'Y',
				]);
			}
			return json_encode("Record updated");
		} else {
			return json_encode("No record found");
		}
	}
	public function adminAlerts()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$alert_status = new AlertStatus();
			$data['notification'] = $alert_status->getCurrentDataAlertsByUserId($_SESSION['user_data']['id']);
			$data['viewall'] = 'Y';
			return view('/home/customernotifications', $data);
		} else {
			return redirect()->to('/');
		}
	}
	public function updateAlertStatus()
	{
		$alert_status = new AlertStatus();
		$data['notification'] = $alert_status->getCurrentAlertNotificationById($_POST['id']);
		// log_message('debug', '**************** UN Session_ID ****************' . $data['notification'][0]['id']);
		if (isset($data['notification'])) {
			for ($i = 0; $i < sizeof($data['notification']); $i++) {
				$alert_status->update($data['notification'][$i]['id'], [
					'is_read' => 'Y',
				]);
			}
			return json_encode("Record updated");
		} else {
			return json_encode("No record found");
		}
	}
	public function deleteNotification()
	{
		$notificationId = $_GET['id'];
		$singleNotification = new Singlenotification();
		$notification = new Notifications();
		$data['notification'] = $singleNotification->getCurrentDataNotificationsByNotificationId($notificationId);
		//log_message('debug', '***************** Notification Delete *****************' . var_export($data['notification'], true));
		//log_message('debug', '***************** Notification Delete *****************' . sizeof($data['notification']));
		if (isset($data)) {
			for ($i = 0; $i < sizeof($data['notification']); $i++) {
				log_message('debug', '***************** Notification Delete *****************' . $data['notification'][$i]['id']);
				$singleNotification->delete($data['notification'][$i]['id']);
			}
		}

		$notification->delete($_GET['id']);

		return redirect()->to('/admin/notifications');
	}

	public function deposit_requests()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$data = [];
			$deposit = new Deposit();
			$id =  $_SESSION['user_data']['id'];
			$alert_status = new AlertStatus();
			$allDeposits = $deposit->getAllDeposits();
			$data['allDeposits'] = $allDeposits;
			$data['notification'] = $alert_status->getCurrentAlertNotificationById($id);
			return view('/home/adminDepositRequests', $data);
		} else {
			return redirect()->to('/');
		}
	}
	public function accept_deposit_requests($id)
	{
		$permission_library = new permissions();
		$deposit = new Deposit();
		$users = new Users();
		$notification = new Notifications();
		$singleNotification = new Singlenotification();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$deposit->update($id, [
				'status' => 'Accepted',
				'accepted_date' => date('Y-m-d H:i:s')
			]);

			$deposit_data = $deposit->getDepositsbyid($id);
			$user_data = $users->getrow($deposit_data[0]['user_id']);
			$name = $user_data['firstName'] . " " . $user_data['lastName'];
			$message = "Your deposit request has been Accepted.";
			$title = "Deposit Request has been Accepted";
			$notification->save([
				'title' => $title,
				'description' => $message,
				'status' => "Enable"
			]);
			$notificationId = $notification->get_last_data_id();
			$singleNotification->save([
				'user_id' => $user_data['id'],
				'notification_id' => $notificationId['id'],
			]);

			$this->statusNotification($title, $message, $user_data['id']);
			$email = $user_data['email'];
			// 			log_message('debug', '***************** Edit Profile DATA *****************' . var_export($user_data,true)."ID".$id);
			$emailsss = new Emails();
			$emailsss->sendDepositaccept($name, $email, $message, '');
			return redirect()->to('/admin/deposit_requests');
		} else {
			return redirect()->to('/');
		}
	}
	public function reject_deposit_requests()
	{
		$permission_library = new permissions();
		$deposit = new Deposit();
		$users = new Users();
		$notification = new Notifications();
		$singleNotification = new Singlenotification();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$deposit->update($_POST['deposit_id'], [
				'status' => 'Rejected',
				'reject_reason' => $_POST['reason'],
				'accepted_date' => date('Y-m-d H:i:s')
			]);
			$deposit_data = $deposit->getDepositsbyid($_POST['deposit_id']);
			$user_data = $users->getrow($deposit_data[0]['user_id']);
			$name = $user_data['firstName'] . " " . $user_data['lastName'];
			$message = "Your deposit request has been Rejected.";
			$title = "Deposit Request has been Rejected";
			$notification->save([
				'title' => $title,
				'description' => $message,
				'status' => "Enable"
			]);
			$notificationId = $notification->get_last_data_id();
			$singleNotification->save([
				'user_id' => $user_data['id'],
				'notification_id' => $notificationId['id'],
			]);

			$this->statusNotification($title, $message, $user_data['id']);
			$email = $user_data['email'];
			// 			log_message('debug', '***************** Edit Profile DATA *****************' . var_export($user_data,true)."ID".$id);
			$emailsss = new Emails();
			$emailsss->sendDepositaccept($name, $email, $message, $_POST['reason']);
			return redirect()->to('/admin/deposit_requests');
		} else {
			return redirect()->to('/');
		}
	}
	public function complete_deposit_requests($id)
	{
		$permission_library = new permissions();
		$users = new Users();
		$notification = new Notifications();
		$singleNotification = new Singlenotification();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$deposit = new Deposit();
			$userId = $deposit->getDepositsbyid($id);
			// print_r($userId[0]['user_id']) ;
			// die ;
			// $user = $users->getrow($userId['user_id']) ;
			$deposit->update($id, [
				'status' => 'Completed',
				'accepted_date' => date('Y-m-d H:i:s')
			]);
			$message = "Your deposit request has been Completed.";
			$title = "Deposit Request has been Completed";
			$notification->save([
				'title' => $title,
				'description' => $message,
				'status' => "Enable"
			]);
			$notificationId = $notification->get_last_data_id();
			$singleNotification->save([
				'user_id' => $userId[0]['user_id'],
				'notification_id' => $notificationId['id'],
			]);

			$this->statusNotification($title, $message, $userId[0]['user_id']);
			return redirect()->to('/admin/deposit_requests');
		} else {
			return redirect()->to('/');
		}
	}

	public function withdrawal_requests()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$data = [];
			$withdraw = new Withdraw();
			$id =  $_SESSION['user_data']['id'];
			$alert_status = new AlertStatus();
			$allWithdrawals = $withdraw->getAllWithdrawals();
			$data['allWithdrawals'] = $allWithdrawals;
			$data['notification'] = $alert_status->getCurrentAlertNotificationById($id);
			return view('/home/adminWithdrawalRequests', $data);
		} else {
			return redirect()->to('/');
		}
	}
	public function accept_withdrawal_requests($id)
	{
		$permission_library = new permissions();
		$users = new Users();
		$notification = new Notifications();
		$singleNotification = new Singlenotification();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$withdraw = new Withdraw();
			$withdraw->update($id, [
				'status' => 'Accepted',
				'paid_date' => date('Y-m-d H:i:s')
			]);
			$withdraw_data = $withdraw->getWithdrawalsByid($id);
			$user_data = $users->getrow($withdraw_data[0]['user_id']);
			$name = $user_data['firstName'] . " " . $user_data['lastName'];
			$message = "Your withdrawal request has been Accepted.";
			$title = "Withdrawal Request has been Accepted";
			$notification->save([
				'title' => $title,
				'description' => $message,
				'status' => "Enable"
			]);
			$notificationId = $notification->get_last_data_id();
			$singleNotification->save([
				'user_id' => $user_data['id'],
				'notification_id' => $notificationId['id'],
			]);

			$this->statusNotification($title, $message, $user_data['id']);
			$email = $user_data['email'];
			$emailsss = new Emails();
			$emailsss->sendDepositaccept($name, $email, $message, '');
			return redirect()->to('/admin/withdrawal_requests');
		} else {
			return redirect()->to('/');
		}
	}
	public function reject_withdrawal_requests()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		$users = new Users();
		$notification = new Notifications();
		$singleNotification = new Singlenotification();
		if ($response == true) {
			$withdraw = new Withdraw();
			$withdraw->update($_POST['withdraw_id'], [
				'status' => 'Rejected',
				'reject_reason' => $_POST['reason'],
				'paid_date' => date('Y-m-d H:i:s')
			]);
			$withdraw_data = $withdraw->getWithdrawalsByid($_POST['withdraw_id']);
			$user_data = $users->getrow($withdraw_data[0]['user_id']);
			$name = $user_data['firstName'] . " " . $user_data['lastName'];
			$message = "Your withdrawal request has been rejected.";
			$title = "Withdrawal Request has been Rejected";
			$notification->save([
				'title' => $title,
				'description' => $message,
				'status' => "Enable"
			]);
			$notificationId = $notification->get_last_data_id();
			$singleNotification->save([
				'user_id' => $user_data['id'],
				'notification_id' => $notificationId['id'],
			]);

			$this->statusNotification($title, $message, $user_data['id']);
			$email = $user_data['email'];
			$emailsss = new Emails();
			$emailsss->sendDepositaccept($name, $email, $message, $_POST['reason']);
			return redirect()->to('/admin/withdrawal_requests');
		} else {
			return redirect()->to('/');
		}
	}
	public function complete_withdrawal_requests($id)
	{
		$permission_library = new permissions();
		$users = new Users();
		$notification = new Notifications();
		$singleNotification = new Singlenotification();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$withdraw = new Withdraw();
			$userId = $withdraw->getWithdrawalsByid($id);
			// print_r($userId) ;
			// die ;
			// $user = $users->getrow($userId[0]['user_id']) ;
			$withdraw->update($id, [
				'status' => 'Completed',
				'paid_date' => date('Y-m-d H:i:s')
			]);
			$message = "Your Withdrawal request has been Completed.";
			$title = "Withdrawal Request has been Completed";
			$notification->save([
				'title' => $title,
				'description' => $message,
				'status' => "Enable"
			]);
			$notificationId = $notification->get_last_data_id();
			$singleNotification->save([
				'user_id' => $userId[0]['user_id'],
				'notification_id' => $notificationId['id'],
			]);

			$this->statusNotification($title, $message, $userId[0]['user_id']);
			return redirect()->to('/admin/withdrawal_requests');
		} else {
			return redirect()->to('/');
		}
	}

	public function admin_tax_form()
	{
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$data = [];
			$id = $_GET['userid'];
			$tax_form = new TaxForm();
			$data['tax_form_data'] = $tax_form->get_By_UserId($id);
			$singleNotification = new Singlenotification();
			$data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
			$data['callChartAdmin'] = true;
			return view('/home/tax_from', $data);
		} else {
			return redirect()->to('/');
		}
	}
	public function report_genrate()
	{
		log_message('debug', '***************** Chart BY Adminaaaaaaaaaaa *****************' . var_export($_POST, true));
		$date = '';
		$cdate = 0;
		$data = [];
		if (isset($_POST['select_duration'])) {
			if ($_POST['select_duration'] == 'TM') {
				$date = date('Y-m');
				$data['start_date'] = date('F-01-Y');
				$data['end_date'] = date('F-t-Y');
			} elseif ($_POST['select_duration'] == 'CY') {
				$date = date('Y');
				$currentYear = date("Y");
				$data['start_date'] = date("Y-m-d", strtotime("January 1 $currentYear"));
				$data['end_date'] = date("Y-m-d", strtotime("December 31 $currentYear"));
			} elseif ($_POST['select_duration'] == 'LM') {
				$date = date('Y-m', strtotime("-1 month"));
				$currentYear = date("Y");
				$currentMonth = date("m");
				$previousMonth = date("m", strtotime("-1 month"));
				if ($previousMonth == "12") {
					$previousYear = $currentYear - 1;
				} else {
					$previousYear = $currentYear;
				}
				$data['start_date'] = date("Y-m-d", strtotime("first day of $previousYear-$previousMonth"));
				$data['end_date'] = date("Y-m-d", strtotime("last day of $previousYear-$previousMonth"));
			} elseif ($_POST['select_duration'] == 'L9D') {
				$date = date('Y-m-d 00:00:00', strtotime("-3 month"));
				$cdate = date('Y-m-d 23:00:00');
				$data['start_date'] = date('F-01-Y', strtotime("-3 month"));
				$data['end_date'] = date('F-d-Y');
				// $cdate = date('Y-m-d H:i:s', strtotime($cdate . ' +1 day'));

			} elseif ($_POST['select_duration'] == 'Custom_date') {
				$date =  $_POST['start_date'] . " " . '23:00:00';
				// $date = date('Y-m-d H:i:s', strtotime($date . ' +1 day'));
				$cdate = $_POST['end_date'] . " " . '23:00:00';
				// $cdate = date('Y-m-d H:i:s', strtotime($cdate . ' +1 day'));
				$sdatee = strtotime($_POST['start_date']);
				$edatee = strtotime($_POST['end_date']);
				$data['start_date'] = date("j M Y", $sdatee);
				$data['end_date'] = date("j M Y", $edatee);
			}
		} else {
			$data['callChartAdmin'] = true;
			return view('/home/report_view', $data);
		}
		$permission_library = new permissions();
		$response = $permission_library->checksessionadmin();
		if ($response == true) {
			$id = $_POST['userid'];
			$data['userid'] = $id;
			$profitLoss = new ProfitLoss();
			$users = new Users();
			$deposit = new Deposit();
			$payout = new Payout();
			$withdraw = new Withdraw();
			$profitLos = array();
			$withdra = array();
			$deposi = array();
			$userInfo = $users->getrow($id);
			if ($cdate == 0) {
				$profitLos = $profitLoss->getByUserId_current_month($id, $date);
				$withdra = $withdraw->getByUserId_current_month($id, $date);
				$deposi = $deposit->getByUserId_current_month($id, $date);
				$payou = $payout->getByUserId_current_month($id, $date);
			} else {
				$profitLos = $profitLoss->getByUserId_months($id, $cdate, $date);
				$withdra = $withdraw->getByUserId_months($id, $cdate, $date);
				$deposi = $deposit->getByUserId_months($id, $cdate, $date);
				$payou = $payout->getByUserId_months($id, $cdate, $date);
				// log_message('debug', '***************** Chart BY Admin *****************'.var_export($payou,true));
			}
			$a = array();
			$report = new Report();
			for ($i = 0; $i < sizeof($profitLos); $i++) {
				$data['profitLossDetails'] = $profitLoss->getByUserId($id);
				$payoutSum = $payout->getsum_month($id, $profitLos[$i]['publishDate']);
				$data['payoutSum'] = $payoutSum;
				$data['lastpayout'] = $payout->getPayoutsdesc($id);
				$returnType = $users->getReturnTypeId($id);
				$data['returnType'] = $returnType;
				$profit = $profitLoss->getTotalProfitById_by_date($id, $profitLos[$i]['publishDate']);
				$loss = $profitLoss->getTotalLossById_by_date($id, $profitLos[$i]['publishDate']);
				$data['profitLoss'] = $profit - $loss;
				if ($cdate == 0) {
					$depositAcceptedAll = $deposit->getAcceptedDepositByUserId_month($id, $date, $profitLos[$i]['publishDate']);
				} else {
					$depositAcceptedAll = $deposit->getAcceptedDepositByUserId_range($id, $date, $cdate, $profitLos[$i]['publishDate']);
				}
				$depositAcceptedAll = $depositAcceptedAll ? $depositAcceptedAll : 0;
				$payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;
				$completedWithdrawals = $withdraw->getCompletedByUserId_month($id, $date, $profitLos[$i]['publishDate']);
				$payoutAll += $completedWithdrawals;
				$data['payoutAll'] = $payoutAll;
				$pendingWithdraw = $withdraw->getAllPendingByUserId_month($id, $date);
				$data['pendingWithdraw'] = $pendingWithdraw;
				$totalBalance = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll + (float)$data['profitLoss']) - (float)$pendingWithdraw - (float)$payoutAll;
				//  log_message('debug', '***************** Chart BY Admin43 *****************' . var_export($totalBalance,true) ." ".var_export($userInfo['initialInvestment'],true) ." ".var_export($depositAcceptedAll,true) ." Tp".var_export($data['profitLoss'],true) ." ".var_export($pendingWithdraw,true)." ".var_export($payoutAll,true));
				$report->save([
					'userid' => $profitLos[$i]['userid'],
					'balance' => $totalBalance,
					'trasition' => $profitLos[$i]['amount'],
					'type' => $profitLos[$i]['type'],
					'date' => $profitLos[$i]['publishDate']
				]);
			}
			for ($i = 0; $i < sizeof($withdra); $i++) {
				$data['profitLossDetails'] = $profitLoss->getByUserId($id);
				$payoutSum = $payout->getsum_month($id, $withdra[$i]['paid_date']);
				$data['payoutSum'] = $payoutSum;
				$data['lastpayout'] = $payout->getPayoutsdesc($id);
				$returnType = $users->getReturnTypeId($id);
				$data['returnType'] = $returnType;
				$data['userInfo'] = $userInfo;
				$profit = $profitLoss->getTotalProfitById_by_daterange($id, $withdra[$i]['paid_date'], $cdate);
				$loss = $profitLoss->getTotalLossById_by_daterange($id, $withdra[$i]['paid_date'], $cdate);
				$data['profitLoss'] = $profit - $loss;
				if ($cdate == 0) {
					$depositAcceptedAll = $deposit->getAcceptedDepositByUserId_month($id, $date, $withdra[$i]['paid_date']);
				} else {
					$depositAcceptedAll = $deposit->getAcceptedDepositByUserId_range($id, $date, $cdate, $withdra[$i]['paid_date']);
				}
				$depositAcceptedAll = $depositAcceptedAll ? $depositAcceptedAll : 0;
				$payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;
				$completedWithdrawals = $withdraw->getCompletedByUserId_month($id, $date, $withdra[$i]['paid_date']);
				$payoutAll += $completedWithdrawals;
				$data['payoutAll'] = $payoutAll;
				$pendingWithdraw = $withdraw->getAllPendingByUserId_month($id, $date);
				$data['pendingWithdraw'] = $pendingWithdraw;
				$totalBalance = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll + (float)$data['profitLoss']) - (float)$pendingWithdraw - (float)$payoutAll;
				// log_message('debug', '***************** Chart BY Admin123 *****************' . var_export($totalBalance,true) ." ".var_export($userInfo['initialInvestment'],true) ." ".var_export($depositAcceptedAll,true) ." ".var_export($data['profitLoss'],true) ." ".var_export($pendingWithdraw,true)." ".var_export($payoutAll,true));

				$report->save([
					'userid' => $withdra[$i]['user_id'],
					'widthra' => $withdra[$i]['amount'],
					'balance' => $totalBalance,
					'date' => $withdra[$i]['paid_date']
				]);
			}
			for ($i = 0; $i < sizeof($deposi); $i++) {
				$data['profitLossDetails'] = $profitLoss->getByUserId($id);
				$payoutSum = $payout->getsum_month($id, $deposi[$i]['accepted_date']);
				$data['payoutSum'] = $payoutSum;
				$data['lastpayout'] = $payout->getPayoutsdesc($id);
				$returnType = $users->getReturnTypeId($id);
				$data['returnType'] = $returnType;
				$profit = $profitLoss->getTotalProfitById_by_date($id, $deposi[$i]['accepted_date']);
				$loss = $profitLoss->getTotalLossById_by_date($id, $deposi[$i]['accepted_date']);
				$data['profitLoss'] = $profit - $loss;
				if ($cdate == 0) {
					$depositAcceptedAll = $deposit->getAcceptedDepositByUserId_month($id, $date, $deposi[$i]['accepted_date']);
				} else {
					$depositAcceptedAll = $deposit->getAcceptedDepositByUserId_range($id, $date, $cdate, $deposi[$i]['accepted_date']);
				}
				$depositAcceptedAll = $depositAcceptedAll ? $depositAcceptedAll : 0;
				$payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;
				$completedWithdrawals = $withdraw->getCompletedByUserId_month($id, $date, $deposi[$i]['accepted_date']);
				$payoutAll += $completedWithdrawals;
				$data['payoutAll'] = $payoutAll;
				$pendingWithdraw = $withdraw->getAllPendingByUserId_month($id, $date);
				$data['pendingWithdraw'] = $pendingWithdraw;
				$totalBalance = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll + (float)$data['profitLoss']) - (float)$pendingWithdraw - (float)$payoutAll;
				//  log_message('debug', '***************** Chart BY Admin44 *****************' . var_export($totalBalance,true) ." ".var_export($userInfo['initialInvestment'],true) ." ".var_export($depositAcceptedAll,true) ." Tp".var_export($data['profitLoss'],true) ." ".var_export($pendingWithdraw,true)." ".var_export($payoutAll,true));
				$report->save([
					'userid' => $deposi[$i]['user_id'],
					'deposit' => $deposi[$i]['amount'],
					'balance' => $totalBalance,
					'date' => $deposi[$i]['accepted_date']
				]);
			}
			for ($i = 0; $i < sizeof($payou); $i++) {
				$data['profitLossDetails'] = $profitLoss->getByUserId($id);
				$payoutSum = $payout->getsum_month($id, $payou[$i]['payoutdate']);
				$data['payoutSum'] = $payoutSum;
				$data['lastpayout'] = $payout->getPayoutsdesc($id);
				$returnType = $users->getReturnTypeId($id);
				$data['returnType'] = $returnType;
				$profit = $profitLoss->getTotalProfitById_by_date_for_payout($id, $payou[$i]['payoutdate']);
				$loss = $profitLoss->getTotalLossById_for_payout($id, $payou[$i]['payoutdate']);
				$data['profitLoss'] = $profit - $loss;
				if ($cdate == 0) {
					$depositAcceptedAll = $deposit->getAcceptedDepositByUserId_month($id, $date, $payou[$i]['payoutdate']);
				} else {
					$depositAcceptedAll = $deposit->getAcceptedDepositByUserId_range($id, $date, $cdate, $payou[$i]['payoutdate']);
				}
				$depositAcceptedAll = $depositAcceptedAll ? $depositAcceptedAll : 0;
				$payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;
				$completedWithdrawals = $withdraw->getCompletedByUserId_month($id, $date, $payou[$i]['payoutdate']);
				$payoutAll += $completedWithdrawals;
				$data['payoutAll'] = $payoutAll;
				$pendingWithdraw = $withdraw->getAllPendingByUserId_month($id, $date);
				$data['pendingWithdraw'] = $pendingWithdraw;
				$totalBalance = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll + (float)$data['profitLoss']) - (float)$pendingWithdraw - (float)$payoutAll;
				log_message('debug', '***************** Chart BY Admin44 *****************' . $payou[$i]['amount'] . var_export($totalBalance, true) . " " . var_export($userInfo['initialInvestment'], true) . " " . var_export($depositAcceptedAll, true) . " Tp" . var_export($data['profitLoss'], true) . " " . var_export($pendingWithdraw, true) . " " . var_export($payoutAll, true));
				$report->save([
					'userid' => $payou[$i]['user_id'],
					'payout' => $payou[$i]['amount'],
					'balance' => $totalBalance,
					'date' => $payou[$i]['payoutdate']
				]);
			}
			$b_amount = $report->getData();
			$data['all_Data'] = $report->getData();
			// log_message('debug', '**************** report_genrate321 ****************' . var_export($report->getData(),true));
			$data['depositSum'] = (float)$report->get_sum_of_diposit($id);
			$data['PSum'] = (float)$report->get_sum_of_profit($id);
			$data['LSum'] = (float)$report->get_sum_of_Loss($id);
			$data['withdrawSum'] = (float)$report->get_sum_of_withdraw($id);
			$data['payoutSum'] = (float)$report->get_sum_of_payout($id);
			$data['startAmount'] = 0;
			if ($b_amount) {
				$data['startAmount'] = (float)$b_amount[0]['balance'];
			}
			if (isset($b_amount[0]['payout'])) {
				$data['startAmount'] = (float)$b_amount[0]['balance'] + (float)$b_amount[0]['payout'];
			} elseif (isset($b_amount[0]['widthra'])) {
				$data['startAmount'] = $b_amount[0]['balance'] + $b_amount[0]['widthra'];
			} elseif (isset($b_amount[0]['deposit'])) {
				$data['startAmount'] = $b_amount[0]['balance'] - $b_amount[0]['deposit'];
			} elseif (isset($b_amount[0]['trasition'])) {
				if (isset($b_amount[0]['type']) && $b_amount[0]['type'] == 'Profit') {
					$data['startAmount'] = $b_amount[0]['balance'] - $b_amount[0]['trasition'];
				} elseif (isset($b_amount[0]['type']) && $b_amount[0]['type'] == 'Loss') {
					$data['startAmount'] = $b_amount[0]['balance'] + $b_amount[0]['trasition'];
				}
			}
			// $data['endAmount'] =  (float)($data['startAmount'] + $data['depositSum'] + ($data['PSum']-$data['LSum'])) - ($data['withdrawSum'] + $data['payoutSum']);
			$data['endAmount'] = 0;
			if (sizeof($b_amount) > 0) {
				$data['endAmount'] = (float)$b_amount[sizeof($b_amount) - 1]['balance'];
			}
			$report->deleteData($id);
			$all_user = new Users();
			$all_taransaction = new ProfitLoss();
			$data['alluser'] = $all_user->getCustomers();
			$data['userInfo'] = $userInfo;
			$data['allprofitloass'] = $all_taransaction->getByUserId($id);
			$data['callChartAdmin'] = true;
			return view('/home/report_view', $data);
		} else {
			return redirect()->to('/');
		}
	}

	public function mailCronJob()
	{
		$notification = new Notifications();
		$singleNotification = new Singlenotification();
		$emailsss = new Emails();
		$allNotification = $singleNotification->getCurrentDataNotificationsByUserIdCronJob();
		log_message('debug', '**************** UN Session_ID ****************' . var_export($allNotification, true));
		log_message('debug', '**************** UN Session_ID ****************' . $allNotification[0]['email']);
		for ($i = 0; $i < sizeof($allNotification); $i++) {
			$email = $allNotification[$i]['email'];
			$emailsss->sendNotification($email, $allNotification[$i]['description']);
		}
	}
}
