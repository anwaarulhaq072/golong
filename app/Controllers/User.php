<?php

namespace App\Controllers;

use App\Libraries\permissions;
use App\Models\ProfitLoss;
use App\Models\ChatMessage;
use App\Models\Currency;
use App\Models\CurrencyOption;
use App\Models\Deposit;
use App\Models\Users;
use App\Models\Notifications;
use App\Models\Singlenotification;
use App\Models\Payout;
use App\Models\Withdraw;
use App\Libraries\Emails;
use App\Controllers\Logs;
use App\Models\Alerts;
use App\Models\AlertStatus;
use App\Models\Report;
use App\Models\TaxForm;

// use CodeIgniter\Debug\Toolbar\Collectors\Logs;

class User extends BaseController
{
    public function verify()
    {
        //   exit;
        return view('/home/verifycode');
    }
    public function accountantDashboard()
    {
        $permission_library = new permissions();
        $response = $permission_library->checksessionuser();
        session_start();
        if ($response == true && $_SESSION['user_data']['userTypeId'] == 4) {
            $data = [];
            $data1 = [];
            $id = $_SESSION['user_data']['id'];
            $users = new Users();
            $payout = new Payout();
            $profitLoss = new ProfitLoss();
            $data['userData'] = $users->getCustomersforaccountant();
            $data['accountantData'] = $users->getrow($id);
            $i = 0;
            foreach ($data['userData'] as $single) {
                $returnType = $users->getReturnTypeId($single['id']);
                $payoutSum = $payout->getsum($single['id']);
                $profit = $profitLoss->getTotalProfitById($single['id']);
                $loss = $profitLoss->getTotalLossById($single['id']);
                $data['profitLoss'] = $profit - $loss;
                $data['payoutSum'] = $payoutSum;
                if ($returnType[0]['name'] == 'noreturn') {
                    $data['profitAftersplit'] = ($data['profitLoss']) * ($single['payout_per'] / 100);
                    // For Payout available after Split Box 
                    $data['payoutAftersplit'] = round(((float)$data['profitAftersplit'] - (float)$payoutSum[0]['amount']), 2);

                    $data1[$i++] = $data['payoutAftersplit'];
                } else {
                    // For Profit after split
                    $data['profitAftersplit'] = ($data['profitLoss'] - $single['initialInvestment']) * ($single['payout_per'] / 100);
                    // For Payout available after Split Box 
                    if (empty($data['payoutSum'][0]['amount'])) {
                        $data['payoutAftersplit'] = $single['initialInvestment'] + $data['profitLoss'];
                        $data1[$i++] = $data['payoutAftersplit'];
                    } else {
                        $data1[$i++] = $data['profitAftersplit'];
                    }
                }
            }
            $data['pendingPayout'] = $data1;
            return view('/home/accountant-dashboard', $data);
        } else {
            return redirect()->to('/');
        }
    }
    public function chat()
    {
        $permission_library = new permissions();
        $response = $permission_library->checksessionuser();
        if ($response == true) {
            $data = [];
            $id = $_SESSION['user_data']['id'];
            $auth = $_SESSION['user_data'];
            $chat = new ChatMessage();
            $users = new Users();
            $singleNotification = new Singlenotification();
            $data['allChat'] = $chat->getChatByUserId($id);
            $userInfo = $users->getrow($id);
            $data['userInfo'] = $userInfo;
            $data['id'] = $id;
            $data['auth'] = $auth;
            $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
            $groupedChat = [];
            foreach ($data['allChat'] as $chat) {
                $date = date('Y-m-d', strtotime($chat['createdAt'])); // Extract the date part
                if (!isset($groupedChat[$date])) {
                    $groupedChat[$date] = [];
                }
                $groupedChat[$date][] = $chat;
            }
            log_message("debug", "Notifications CHeck " . var_export($groupedChat, true));
            return view('/home/customer-chat', $data);
        } else {
            return redirect()->to('/');
        }
    }
    public function dashboard()
    {
        $permission_library = new permissions();
        $response = $permission_library->checksessionuser();
        if ($response == true) {

            if ($_SESSION['user_data']['tax_form_flag'] == "No" && $_SESSION['user_data']['createdAt'] >= "2024-05-01 10:35:26") {
                return redirect()->to('/user/tax_form');
            }
            $data = [];
            $profitLoss = new ProfitLoss();
            $chat = new ChatMessage();
            $users = new Users();
            $payout = new Payout();
            $notifications = new Notifications();
            $singleNotification = new Singlenotification();
            $deposit = new Deposit();
            $withdraw = new Withdraw();
            $id = $_SESSION['user_data']['id'];
            if (isset($_SESSION['superAdminTypeId'])) {
                $superadminid = $_SESSION['superAdminTypeId'];
                $data['superadminid'] = $superadminid;
            }
            $data['allChat'] = $chat->getChatByUserId($id);
            $data['profitLossDetails'] = $profitLoss->getByUserId($id);
            $userInfo = $users->getrow($id);
            $payoutSum = $payout->getsum($id);
            $data['payoutSum'] = $payoutSum;
            $data['lastpayout'] = $payout->getPayoutsdesc($id);
            $returnType = $users->getReturnTypeId($id);
            $data['returnType'] = $returnType;
            // log_message('debug', '***************** Chart BY Admin *****************' . var_export($data['payoutSum'], true));
            $data['userInfo'] = $userInfo;
            //log_message('debug', '***************** Chart BY Admin *****************' . var_export($userInfo, true));
            $data['id'] = $id;
            $profit = $profitLoss->getTotalProfitById($id);
            $loss = $profitLoss->getTotalLossById($id);
            $data['profitLoss'] = $profit - $loss;
            $data['firstpayout'] = $payout->getPayoutsasc($id);

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
            $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
            log_message("debug", "Notifications CHeck " . var_export($data['notification'], true));

            $data['profitLossDetails'] = $profitLoss->getByUserId($id);
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
            $percentage_fot_profit_box = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll) - (float)$pendingWithdraw - (float)$payoutAll;
            $data['percentage_fot_profit_box'] = (float)$data['profitLoss'] / $percentage_fot_profit_box * 100;
            $percentage_fot_p_payout_box = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll + (float)$data['profitLoss']) - (float)$payoutAll;
            $data['percentage_fot_p_payout_box'] = (float)$pendingWithdraw / $percentage_fot_p_payout_box * 100;
            $percentage_fot_payout_box = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll + (float)$data['profitLoss']) - (float)$pendingWithdraw;
            $data['percentage_fot_payout_box'] = (float)$payoutAll / $percentage_fot_payout_box * 100;
            $totalBalance = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll + (float)$data['profitLoss']) - (float)$pendingWithdraw - (float)$payoutAll;
            $data['totalBalance'] = $totalBalance;
            $data['profitLossMonthly'] = [];
            $data['profitLossMonthly']['total'] = 0;
            $data['totalProfitNum'] = 0;
            $data['totalLossNum'] = 0;
            for ($a = 0; $a < sizeof($data['profitLossDetails']); $a++) {
				$data['profitLossDetails'][$a]['type'] == 'Profit' ? $data['totalProfitNum']++ : $data['totalLossNum']++;
			}
			// log_message('debug', '**************************************************' . var_export($profitByMonth, true));
			// log_message('debug', '**************************************************' . var_export($lossByMonth, true));
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
            $data['profitLossMonthly']['total'] = $data['profitLossMonthly']['total'] ? number_format((float)($data['profitLossMonthly']['total']), 2, '.', '') : 0;
            $waveChart = $this->chartDetails();
            $data['waveChart'] = $waveChart;

            return view('/home/new-dashboard', $data);
        } else {
            return redirect()->to('/');
        }
    }
    // Run by AJAX call
    public function chartDetails()
    {
        // log_message('debug', '***************** Chart BY Customer *****************');
        session_start();
        $id = $_SESSION['user_data']['id'];
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

        // $data['maxLoss'] = round(($ProfitAndLoss[0]['amount']) * ($userInfo['payout_per'] / 100), 2);
        // $data['maxProfit'] = round((($totalProfit) * ($userInfo['payout_per'] / 100)) + 100, 2);
        $data['maxLoss'] = 0;
        if(isset($ProfitAndLoss[0]['amount'])){
        $data['maxLoss'] = $investmentAmount + round(($ProfitAndLoss[0]['amount']), 2);
        }
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
    public function chartDetails_Overview()
    {
        // log_message('debug', '***************** Chart BY Customer *****************');
        session_start();
        $id = $_SESSION['user_data']['id'];
        $data = [];
        $profitLoss = new ProfitLoss();
        $users = new Users();
        $payout = new Payout();
        $deposit = new Deposit();
        $withdraw = new Withdraw();
        // $payoutSum = $payout->getsum($id);
        $userInfo = $users->getrow($id);
        $investmentAmount = $userInfo['initialInvestment'];
        $ProfitAndLoss = $profitLoss->getAllProfitAndLossById_Overview($id);
        // log_message('debug', '***************** Chart BY Customer *****************'.$ProfitAndLoss);
        // $maxLoss = $profitLoss->getMaxLossById($id);
        $profit = $profitLoss->getTotalProfitById_Overview($id);
        $loss = $profitLoss->getTotalLossById_Overview($id);
        $firstpayout = $payout->getPayoutsasc($id);
        // $returnType = $users->getReturnTypeId($id);
        $allPayouts = $payout->getrow_Overview($id);
        $completedDeposits = $deposit->getCompletedDepositByUserId_Overview($id);
        $completedWithdrawals = $withdraw->getCompletedWithdrawalsByUserId_Overview($id);
        $amount = [];
        $dates = [];
        $totalProfit = $investmentAmount + ($profit - $loss);
        // $data['maxLoss'] = $data['maxLoss'] = round(($ProfitAndLoss[0]['amount']) * ($userInfo['payout_per'] / 100), 2);
        // $data['maxProfit'] = round((($totalProfit) * ($userInfo['payout_per'] / 100)) + 100, 2);
        $data['maxLoss'] = $investmentAmount + round(($ProfitAndLoss[0]['amount']), 2);
        $data['maxProfit'] = $investmentAmount + 10;
        $payoutindex = 0;
        $depositIndex = 0;
        $withdrawIndex = 0;
        // if ($returnType[0]['name'] == 'noreturn') {
        //  for the customers of no return investment
        $newAmount = $investmentAmount;
        foreach ($ProfitAndLoss as $key => $single) {
            //   For Payouts the graph will go down as in case of loss
            if (isset($allPayouts[$payoutindex]) && $allPayouts[$payoutindex]) {
                $singlePayout = $allPayouts[$payoutindex];
                // if ((strtotime($singlePayout['payoutdate']) <= strtotime($single['publishDate'])) && ($payoutindex < sizeof($allPayouts))) {
                $newAmount -= $singlePayout['amount'];
                $amount[] = round($newAmount, 2);
                $dates[] = date('M d, Y  H:i:s', strtotime(date($singlePayout['payoutdate']) . '+11 hours'));
                $payoutindex++;
                if ($data['maxLoss'] > $newAmount) {
                    $data['maxLoss'] = round($newAmount, 2);
                }
                // }
            }
            // For Deposits which are accepted in this case graph will go up as in profit
            if (isset($completedDeposits[$depositIndex]) && $completedDeposits[$depositIndex]) {
                $singleDeposit = $completedDeposits[$depositIndex];
                // if ((strtotime($singleDeposit['accepted_date']) <= strtotime($single['publishDate'])) && ($depositIndex < sizeof($completedDeposits))) {
                $newAmount += $singleDeposit['amount'];
                $amount[] = round($newAmount, 2);
                $dates[] = date('M d, Y  H:i:s', strtotime(date($singleDeposit['accepted_date']) . ' +1 hours'));
                $depositIndex++;
                if ($data['maxProfit'] < $newAmount) {
                    $data['maxProfit'] = round($newAmount, 2);
                    // }
                }
            }
            // For Withdrawals which are accepted in this case graph will go down as in loss
            if (isset($completedWithdrawals[$withdrawIndex]) && $completedWithdrawals[$withdrawIndex]) {
                $singleWithdraw = $completedWithdrawals[$withdrawIndex];
                // if ((strtotime($singleWithdraw['paid_date']) <= strtotime($single['publishDate'])) && ($withdrawIndex < sizeof($completedWithdrawals))) {
                $newAmount -= $singleWithdraw['amount'];
                $amount[] = round($newAmount, 2);
                $dates[] = date('M d, Y  H:i:s', strtotime(date($singleWithdraw['paid_date']) . ' +5 hours'));
                $withdrawIndex++;
                if ($data['maxLoss'] > $newAmount) {
                    $data['maxLoss'] = round($newAmount, 2);
                    // }
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
            $dates[] = date('M d, Y  H:i:s', strtotime($single['publishDate'] . '+11 hours'));
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
        for ($i = 1; $i < count($dates); $i++) {
            for ($j = 0; $j < count($dates); $j++) {
                if (strtotime($dates[$j]) > strtotime($dates[$i])) {
                    $temp = $dates[$j];
                    $dates[$j] = $dates[$i];
                    $dates[$i] = $temp;
                    $temp = $amount[$j];
                    $amount[$j] = $amount[$i];
                    $amount[$i] = $temp;
                }
            }
        }
        $data['amounts'] = $amount;
        $data['dates'] = $dates;
        return json_encode($data);
    }
    public function transactionChart()
    {
        session_start();
        $id = $_SESSION['user_data']['id'];
        log_message("error", $_SESSION['user_data']['id']);
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
    public function transactionChart_Overview()
    {
        session_start();
        $id = $_SESSION['user_data']['id'];
        // log_message("error", $_SESSION['user_data']['id']) ;
        $data = [];
        $profitLoss = new ProfitLoss();
        $profitLossDetails = $profitLoss->getByUserId_Overview($id);
        $totalProfitNum = 0;
        $totalLossNum = 0;
        for ($a = 0; $a < sizeof($profitLossDetails); $a++) {
            $profitLossDetails[$a]['type'] == 'Profit' ? $totalProfitNum++ : $totalLossNum++;
        }
        $data['profitLoss'][0] = $totalProfitNum ? round(($totalProfitNum / sizeof($profitLossDetails)) * 100, 1) : 0;
        $data['profitLoss'][1] = $totalLossNum ? round(($totalLossNum / sizeof($profitLossDetails)) * 100, 1) : 0;

        return json_encode($data);
    }
    public function submitMessage()
    {

        $chat = new ChatMessage();
        $chat->save([
            'msgFrom' => $_POST['userid'],
            'msgTo' => 'Admin',
            'message' => $_POST['sendingMesage']
        ]);
        return redirect()->to('/user/chat');
    }
    public function notifications()
    {
        $permission_library = new permissions();
        $response = $permission_library->checksessionuser();
        if ($response == true) {
            $singleNotification = new Singlenotification();
            $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($_SESSION['user_data']['id']);
            $data['viewall'] = 'Y';
            return view('/home/customernotifications', $data);
        } else {
            return redirect()->to('/');
        }
    }
    public function viewAllPayout()
    {
        $permission_library = new permissions();
        $response = $permission_library->checksessionuser();
        if ($response == true) {
            $singleNotification = new Singlenotification();
            $id = $_GET['userid'];
            $payout = new Payout();
            $data['payoutInfo'] = $payout->getPayoutforviewAll($id);
            $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
            log_message('debug', '***************** View Payout *****************' . var_export($data['payoutInfo'], true));
            return view('/home/payout', $data);
        } else {
            return redirect()->to('/');
        }
    }

    public function deposit()
    {
        $permission_library = new permissions();
        $response = $permission_library->checksessionuser();
        if ($response == true) {
            $data = [];
            $id = $_SESSION['user_data']['id'];
            $singleNotification = new Singlenotification();
            $deposit = new Deposit();
            $allDeposits = $deposit->getAllDepositsByUserId($id);
            $data['allDeposits'] = $allDeposits;
            $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);

            return view('/home/deposit', $data);
        } else {
            return redirect()->to('/');
        }
    }

    public function add_deposit()
    {
        $permission_library = new permissions();
        $response = $permission_library->checksessionuser();
        if ($response == true) {
            $data = [];
            $id = $_SESSION['user_data']['id'];
            $singleNotification = new Singlenotification();
            $currency = new Currency();
            $currency_option = new CurrencyOption();
            $allCurrencies = $currency->getdata();
            $data['currency'] = $allCurrencies;
            foreach ($allCurrencies as $single) {
                $data['currency_options'][$single['slug']] = $currency_option->getByCurrencyId($single['id']);
            }
            $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);

            return view('/home/addDeposit', $data);
        } else {
            return redirect()->to('/');
        }
    }

    public function submit_deposit()
    {
        session_start();
        $permission_library = new permissions();
        $response = $permission_library->checksessionuser();
        if ($response == true) {
            $id = $_SESSION['user_data']['id'];
            $deposit = new Deposit();
            $users = new Users();
            $alert = new Alerts();
            $alert_status = new AlertStatus();
            $deposit->save([
                'user_id' => $id,
                'currency_id' => $_POST['currency_type'],
                'currency_option_id' => $_POST['crypto_type'],
                'amount' => $_POST['amount'],
                'status' => 'Pending',
                'message' => $_POST['message']
            ]);

            $fullName = $_SESSION['user_data']['firstName'] . " " . $_SESSION['user_data']['lastName'];
            $alert->save([
                'title' => 'Deposit Request Received from ' . ucfirst($_SESSION['user_data']['firstName']) . " " . ucfirst($_SESSION['user_data']['lastName']),
                'description' => 'You have received a new Deposit Request from ' . ucfirst($_SESSION['user_data']['firstName']) . " " . ucfirst($_SESSION['user_data']['lastName']),
            ]);
            $alert_id = $alert->get_last_alert_id();
            $userId = $users->getAllAdminId();
            foreach ($userId as $key => $singleId) {
                $alert_status->save([
                    'user_id' => $singleId['id'],
                    'alerts_id' => $alert_id['id']
                ]);
            }
            $this->alertnotification('Deposit Request Received from ' . ucfirst($_SESSION['user_data']['firstName']) . " " . ucfirst($_SESSION['user_data']['lastName']));
            $adminEmails = $users->getAllAdminEmails();
            $allAdminEmails = [];
            foreach ($adminEmails as  $single) {
                $allAdminEmails[] = $single['email'];
            }
            // print_r($allAdminEmails);
            // die();

            $cur = new Currency(); // Getting Currency Type
            $currency = $cur->getById($_POST['currency_type']);
            $currname = $currency['name'];

            $opcur = new CurrencyOption(); //Getting Currency Option
            $opcurrency = $opcur->getById($_POST['crypto_type']);
            $opcurrname = $opcurrency['name'];
            // $this->senddepositNotification();
            $emailslib = new Emails;  //Sending Email 
            $emailslib->sendDeposit($fullName, $currname, $_POST['amount'], $opcurrname, $allAdminEmails);


            $data = [];
            $singleNotification = new Singlenotification();
            $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
            if (isset($deposit)) {
				$_SESSION['success'] = 'Deposit added successfully!';
			}else{
				$_SESSION['danger'] = 'Something went wrong!';
			}
            return redirect()->to('/user/deposit');
            // return view('/home/successDeposit', $data);
        } else {
            return redirect()->to('/');
        }
    }

    public function withdrawal()
    {
        $permission_library = new permissions();
        $response = $permission_library->checksessionuser();
        if ($response == true) {
            $data = [];
            $id = $_SESSION['user_data']['id'];
            $singleNotification = new Singlenotification();
            $withdraw = new Withdraw();
            $allWithdrawals = $withdraw->getAllWithdrawalsByUserId($id);
            $data['allWithdrawals'] = $allWithdrawals;
            $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);

            return view('/home/withdrawal', $data);
        } else {
            return redirect()->to('/');
        }
    }

    public function add_withdrawal()
    {
     
        $permission_library = new permissions();
        $response = $permission_library->checksessionuser();
        if ($response == true) {
            $data = [];
            $id = $_SESSION['user_data']['id'];
            $singleNotification = new Singlenotification();
            $currency = new Currency();
            $currency_option = new CurrencyOption();
            $allCurrencies = $currency->getdata();
            $data['currency'] = $allCurrencies;
            $id = $_SESSION['user_data']['id'];
            $singleNotification = new Singlenotification();
            $withdraw = new Withdraw();
            $allWithdrawals = $withdraw->getAllWithdrawalsByUserId($id);
            $data['allWithdrawals'] = $allWithdrawals;
            $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
            $profitLoss = new ProfitLoss();
            $chat = new ChatMessage();
            $users = new Users();
            $payout = new Payout();
            $notifications = new Notifications();
            $singleNotification = new Singlenotification();
            $deposit = new Deposit();
            $withdraw = new Withdraw();
            $userInfo = $users->getrow($id);
            $payoutSum = $payout->getsum($id);
            $profit = $profitLoss->getTotalProfitById($id);
            $loss = $profitLoss->getTotalLossById($id);
            $data['profitLoss'] = $profit - $loss;
            $data['firstpayout'] = $payout->getPayoutsasc($id);
            $profitByMonth = $profitLoss->getProfitsMonthlyById($id);
            $lossByMonth = $profitLoss->getLossMonthlyById($id);

            $depositAcceptedAll = $deposit->getAcceptedDepositByUserId($id);
            $depositAcceptedAll = $depositAcceptedAll ? $depositAcceptedAll : 0;
            $payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;
            $completedWithdrawals = $withdraw->getCompletedByUserId($id);
            $payoutAll += $completedWithdrawals;
            $pendingWithdraw = $withdraw->getAllPendingByUserId($id);
            $totalBalance = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll + (float)$data['profitLoss']) - (float)$pendingWithdraw - (float)$payoutAll;
            $data['balance'] = $totalBalance;
            foreach ($allCurrencies as $single) {
                $data['currency_options'][$single['slug']] = $currency_option->getByCurrencyId($single['id']);
            }
            $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
         
            return view('/home/addWithdrawal', $data);
        } else {
            return redirect()->to('/');
        }
    }

    public function submit_withdrawal()
    {
        session_start();
        $permission_library = new permissions();
        $response = $permission_library->checksessionuser();
        if ($response == true) {
            $id = $_SESSION['user_data']['id'];
            // print_r($_POST);
            $alert = new Alerts();
            $alert_status = new AlertStatus();
            $users = new Users();
            $withdraw = new Withdraw();
            $withdraw->save([
                'user_id' => $id,
                'currency_id' => $_POST['currency_type'],
                'currency_option_id' => $_POST['crypto_type'],
                'status' => 'Pending',
                'amount' => $_POST['amount'],
                'wallet_address' => $_POST['wallet_address'],
                'account_name' => $_POST['account_name'],
                'account_no' => $_POST['account_no'],
                'routing_no' => $_POST['routing_no'],
                'message' => $_POST['message'],
            ]);
            $fullName = $_SESSION['user_data']['firstName'] . " " . $_SESSION['user_data']['lastName'];
            $alert->save([
                'title' => 'Withdrawal Request Received from ' . ucfirst($_SESSION['user_data']['firstName']) . " " . ucfirst($_SESSION['user_data']['lastName']),
                'description' => 'You have received a new Withdrawal Request from ' . ucfirst($_SESSION['user_data']['firstName']) . " " . ucfirst($_SESSION['user_data']['lastName']),
            ]);
            $alert_id = $alert->get_last_alert_id();
            $userId = $users->getAllAdminId();
            foreach ($userId as $key => $singleId) {
                $alert_status->save([
                    'user_id' => $singleId['id'],
                    'alerts_id' => $alert_id['id']
                ]);
            }
            $this->alertnotification('Withdrawal Request Received from ' . ucfirst($_SESSION['user_data']['firstName']) . " " . ucfirst($_SESSION['user_data']['lastName']));
            // $users = new Users();
            $adminEmails = $users->getAllAdminEmails();
            $allAdminEmails = [];
            foreach ($adminEmails as  $single) {
                $allAdminEmails[] = $single['email'];
            }
            // print_r($allAdminEmails);
            // die();

            $cur = new Currency(); // Getting Currency Type
            $currency = $cur->getById($_POST['currency_type']);
            $currname = $currency['name'];

            $opcur = new CurrencyOption(); //Getting Currency Option
            $opcurrency = $opcur->getById($_POST['crypto_type']);
            $opcurrname = $opcurrency['name'];

            // $emailslib = new Emails;  //Sending Email 
            // $emailslib->sendWithdrawa($fullName, $currname, $_POST['amount'], $opcurrname, $allAdminEmails, $_POST['wallet_address']);


            $data = [];
            $singleNotification = new Singlenotification();
            $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
            if (isset($withdraw)) {
				$_SESSION['success'] = 'Withdraw request added successfully!';
			}else{
				$_SESSION['danger'] = 'Something went wrong!';
			}
            return redirect()->to('/user/withdrawal');
            // return view('/home/withdrawal', $data);
        } else {
            return redirect()->to('/');
        }
    }

    public function overview()
    {
        $permission_library = new permissions();
        $response = $permission_library->checksessionuser();
        if ($response == true) {
            $data = [];
            $profitLoss = new ProfitLoss();
            // $chat = new ChatMessage();
            $users = new Users();
            $payout = new Payout();
            // $notifications = new Notifications();
            // $singleNotification = new Singlenotification();
            // $deposit = new Deposit();
            $withdraw = new Withdraw();
            $id = $_SESSION['user_data']['id'];

            $payoutSum = $payout->getsum_Overview($id);
            $data['payoutSum'] = $payoutSum; //payout Amount

            // log_message('debug', '***************** Chart BY Admin *****************' . var_export($data['payoutSum'], true));
            // $data['userInfo'] = $userInfo;
            //log_message('debug', '***************** Chart BY Admin *****************' . var_export($userInfo, true));

            $data['id'] = $id;
            $profit = $profitLoss->getTotalProfitById_Overview($id);
            $loss = $profitLoss->getTotalLossById_Overview($id);
            $data['profitLoss'] = $profit - $loss;

            $data['profitLossDetails'] = $profitLoss->getByUserId_Overview($id);
            $payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;

            $completedWithdrawals = $withdraw->getCompletedByUserId_Overview($id);
            $payoutAll += $completedWithdrawals;
            $data['payoutAll'] = $payoutAll; //Total Payout

            $data['initial'] = $users->getrow($id);
            $data['initial'] = $data['initial']['initialInvestment'];
            $data['totalProfitNum'] = 0;
            $data['totalLossNum'] = 0;
            for ($a = 0; $a < sizeof($data['profitLossDetails']); $a++) {
                $data['profitLossDetails'][$a]['type'] == 'Profit' ? $data['totalProfitNum']++ : $data['totalLossNum']++;
            }
            return view('/home/customer-overview', $data);
        } else {
            return redirect()->to('/');
        }
    }


    public function get_monthly_return()
    {
        $id = $_GET['user_id'];
        if (empty($id)) {
            session_start();
            $id = $_SESSION['user_data']['id'];
        }
        $users = new Users();
        $payout = new Payout();
        $profitLoss = new ProfitLoss();
        $deposit = new Deposit();
        $withdraw = new Withdraw();
        $data = [];
        $profitByMonth = $profitLoss->getProfitsMonthlyById($id);
        $lossByMonth = $profitLoss->getLossMonthlyById($id);
        $userInfo = $users->getrow($id);
        $profit = $profitLoss->getTotalProfitById($id);
        $loss = $profitLoss->getTotalLossById($id);
        $pendingWithdraw = $withdraw->getAllPendingByUserId($id);
        $payoutSum = $payout->getsum($id);
        $data['profitLoss'] = $profit - $loss;
        $depositAcceptedAll = $deposit->getAcceptedDepositByUserId($id);
        $depositAcceptedAll = $depositAcceptedAll ? $depositAcceptedAll : 0;
        $payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;
        $completedWithdrawals = $withdraw->getCompletedByUserId($id);
        $payoutAll += $completedWithdrawals;
        $totalBalance = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll + (float)$data['profitLoss']) - (float)$pendingWithdraw - (float)$payoutAll;
        $data['profitLossMonthly'] = [];
        $data['profitLossMonthly']['total'] = 0;
        $j = $k = 0;
        if (!empty($profitByMonth) && (int)$profitByMonth[$j]['year'] < (int)$_GET['year']) {
            while ($k < sizeof($profitByMonth) && (int)$profitByMonth[$j]['year'] && (int)$profitByMonth[$j]['year'] < (int)$_GET['year']) {
                $j++;
            }
        }
        if (!empty($lossByMonth) && (int)$lossByMonth[$k]['year'] < (int)$_GET['year']) {
            while ($k < sizeof($lossByMonth) && (int)$lossByMonth[$k]['year'] && (int)$lossByMonth[$k]['year'] < (int)$_GET['year']) {
                $k++;
            }
        }
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
        $data['profitLossMonthly']['total'] = $data['profitLossMonthly']['total'] ? number_format((float)($data['profitLossMonthly']['total']), 2, '.', '') : 0;

        return json_encode($data);
    }
    public function report_genrate()
    {

        log_message('debug', '***************** Chart BY Admin *****************' . var_export($_POST, true));
        session_start();
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
            return view('/home/report_view', $data);
        }
        $permission_library = new permissions();
        $response = $permission_library->checksessionuser();
        if ($response == true) {
            $id = $_SESSION['user_data']['id'];
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
            return view('/home/report_view', $data);
        } else {
            return redirect()->to('/');
        }
    }
    public function tax_form()
    {
        $permission_library = new permissions();
        $response = $permission_library->checksessionuser();
        if ($response == true) {
            if ($_SESSION['user_data']['tax_form_flag'] == "Yes") {
                return redirect()->to('/user/dashboard');
            }
            $data = [];
            $id = $_SESSION['user_data']['id'];
            $singleNotification = new Singlenotification();
            $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
            $data['callChartAdmin'] = false;

            return view('/home/tax_from', $data);
        } else {
            return redirect()->to('/');
        }
    }
    public function submit_tax_from()
    {
        log_message('debug', '***************** Chart BY Admin *****************' . var_export($_POST, true));
        $permission_library = new permissions();
        $response = $permission_library->checksessionuser();
        if ($response == true) {
            $id = $_SESSION['user_data']['id'];
            $tax_form = new TaxForm();
            $tax_form->save([
                'user_id' => $id,
                'address' => $_POST['address'],
                'payers_tin' => $_POST['payers_tin'],
                'recipients_tin' => $_POST['recipients_tin'],
                'recipients_name' => $_POST['recipients_name'],
                'street_address' => $_POST['street_address'],
                'city_or_town_state_or_province_country' => $_POST['city_or_town_state_or_province_country'],
                'account_number' => $_POST['account_number'],
                'rents' => $_POST['rents'],
                'royalties' => $_POST['royalties'],
                'other_income' => $_POST['other_income'],
                'federal_income_tax_withheld' => $_POST['federal_income_tax_withheld'],
                'fishing_boat_proceeds' => $_POST['fishing_boat_proceeds'],
                'medical_and_health_care_payments' => $_POST['medical_and_health_care_payments'],
                'payer_made_direct' => isset($_POST['payer_made_direct_sales_totaling_or_more_of_consumer_products_to_recipient_for_resale']) ? $_POST['payer_made_direct_sales_totaling_or_more_of_consumer_products_to_recipient_for_resale'] : "No",
                'substitute_payments' => $_POST['substitute_payments_in_lieu_of_dividends_or_interest'],
                'crop_insurance_proceeds' => $_POST['crop_insurance_proceeds'],
                'gross_proceeds' => $_POST['gross_proceeds_paid_to_anattorney'],
                'fish_purchased_for_resale' => $_POST['fish_purchased_for_resale'],
                'section_409A_deferrals' => $_POST['section_409A_deferrals'],
                'fatca_filing_requirement' => isset($_POST['fatca_filing_requirement']) ? $_POST['fatca_filing_requirement'] : "No",
                'excess_golden' => $_POST['excess_golden_parachute_payments'],
                'nonqualified_deferred_compensation' => $_POST['nonqualified_deferred_compensation'],
                'state_tax_withheld' => $_POST['state_tax_withheld'],
                'State_or_Payers_state_no' => $_POST['State_or_Payers_state_no'],
                'state_income' => $_POST['state_income'],
                '2nd_tin_not' => isset($_POST['2nd_tin_not']) ? $_POST['2nd_tin_not'] : "No",
            ]);
            $users = new Users();
            $users->update($id, [
                'tax_form_flag' => "Yes",
            ]);
            $_SESSION['user_data']['tax_form_flag'] = "Yes";
            return redirect()->to('/user/dashboard');
        } else {
            return redirect()->to('/');
        }
    }
}
