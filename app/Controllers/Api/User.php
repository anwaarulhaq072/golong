<?php

namespace App\Controllers\Api;
use App\Controllers\BaseController;

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
use App\Controllers\Logs ;
use App\Models\Alerts;
use App\Models\AlertStatus;
use App\Models\Report;

// use CodeIgniter\Debug\Toolbar\Collectors\Logs;

class User extends BaseController
{
    public function verify()
    { 
      
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
    public function chat(){
        $permission_library = new permissions();
        $response = $permission_library->checksessionuser();
        if ($response == true) {
            $data = [];
            $id = $_SESSION['user_data']['id'];
            $chat = new ChatMessage();
            $users = new Users();
            $singleNotification = new Singlenotification();
            $data['allChat'] = $chat->getChatByUserId($id);
            $userInfo = $users->getrow($id);
            $data['userInfo'] = $userInfo;
            $data['id'] = $id;
            $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
            return view('/home/customer-chat', $data);
        } else {
            return redirect()->to('/');
        }
    }
    public function dashboard()
    {
        $data = [];
        $profitLoss = new ProfitLoss();
        $chat = new ChatMessage();
        $users = new Users();
        $payout = new Payout();
        $notifications = new Notifications();
        $singleNotification = new Singlenotification();
        $deposit = new Deposit();
        $withdraw = new Withdraw();
        if(!isset($_GET['bearer_token']) || !isset($_GET['id'])){
            return json_encode("User Not Authenticate.");
        }else{
			$user = $users->getrow($_GET['id']) ;
		}
        if($_GET['bearer_token'] != $user['bearer_token']){
            return json_encode("User Not Authenticate.");
        }else{
            $id = $_GET['id'];
        }
        // if (isset($_SESSION['superAdminTypeId'])) {
        //     $superadminid = $_SESSION['superAdminTypeId'];
        //     $data['superadminid'] = $superadminid;
        // }
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
        log_message("debug" , "Notifications CHeck ".var_export($data['notification'] , true)) ;
        
        $data['profitLossDetails'] = $profitLoss->getByUserId($id);
        $data['profitLossDetails_for_graph'] = $profitLoss->getByUserId_for_transition($id);
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
        for($a=0;$a<sizeof($data['profitLossDetails_for_graph']);$a++){
            $data['profitLossDetails_for_graph'][$a]['type'] == 'Profit' ? $data['totalProfitNum']++ : $data['totalLossNum']++;
        }
        $j = $k = 0;
        if(!empty($profitByMonth) && (int)$profitByMonth[$j]['year'] < 2022 ){
            while((int)$profitByMonth[$j]['year'] < 2022){
                $j++;
            }
        }
        if(!empty($lossByMonth) && (int)$lossByMonth[$k]['year'] < 2022){
            while((int)$lossByMonth[$k]['year'] < 2022){
                $k++;
            }
        }
        // echo (int)$profitByMonth[$j]['month'];
        // die();
        
        for($i = 1; $i < 13; $i++){
            if((!empty($profitByMonth[$j]) && $i==(int)$profitByMonth[$j]['month']) || (!empty($lossByMonth[$k]) && $i==(int)$lossByMonth[$k]['month'])){
                if(!empty($lossByMonth) && !empty($profitByMonth) && isset($lossByMonth[$k])  && isset($profitByMonth[$j]) && (int)$profitByMonth[$j]['month'] === (int)$lossByMonth[$k]['month'] ){
                    $data['profitLossMonthly'][$i] = number_format((float)(($profitByMonth[$j]['amount'] - $lossByMonth[$k]['amount'])), 2, '.', '');
                    $data['profitLossMonthly']['total'] += (float)($profitByMonth[$j]['amount'] - $lossByMonth[$k]['amount']); 
                    $j++;
                    $k++;
                }else if((empty($lossByMonth) || !isset($lossByMonth[$k])) || (int)$profitByMonth[$j]['month'] < (int)$lossByMonth[$k]['month'] ){
                    $data['profitLossMonthly'][$i] = number_format((float)(($profitByMonth[$j]['amount'])), 2, '.', '');
                    $data['profitLossMonthly']['total'] += (float)($profitByMonth[$j]['amount']);
                    $j++;
                }else if((empty($profitByMonth) || !isset($profitByMonth[$j])) || (int)$profitByMonth[$j]['month'] > (int)$lossByMonth[$k]['month'] ){
                    $data['profitLossMonthly'][$i] = number_format((float)(($lossByMonth[$k]['amount'])), 2, '.', '') * -1;
                    $data['profitLossMonthly']['total'] += (float)($lossByMonth[$k]['amount']) * -1;
                    $k++;
                }
            }else{
                $data['profitLossMonthly'][$i] = 0;
            }
        }
        $data['profitLossMonthly']['total'] = $data['profitLossMonthly']['total'] ? number_format((float)($data['profitLossMonthly']['total']), 2, '.', '') : 0;
        log_message('debug', 'Token =>'.$userInfo['bearer_token']);
        log_message('debug', 'Token =>'.$_GET['bearer_token']);
        return json_encode($data);
        
        
        // $permission_library = new permissions();
        // $response = $permission_library->checksessionuser();
        // if ($response == true) {
            
        // } else {
        //     return redirect()->to('/');
        // }
    }
    // Run by AJAX call
    public function chartDetails()
    {
        // log_message('debug', '***************** Chart BY Customer *****************');
        // session_start();
        
        
        $data = [];
		$profitLoss = new ProfitLoss();
		$users = new Users();
		$payout = new Payout();
		$deposit = new Deposit();
		$withdraw = new Withdraw();
        if(!isset($_GET['bearer_token']) || !isset($_GET['id'])){
            return json_encode('User not Authenticate');
        }else{
			$user = $users->getrow($_GET['id']) ;
		}
        if($_GET['bearer_token'] != $user['bearer_token']){
            return json_encode("User Not Authenticate.");
        }else{
            $id = $_GET['id'] ;
        }
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
        $newAmount = $investmentAmount;//$completedDeposits + $completedWithdrawals;
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
            $dates[] = date('M d, Y  H:i:s', strtotime($single['publishDate'].' +11 hours'));
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
        for ($i=1; $i < count($dates); $i++) {
             for ($j=0; $j < count($dates); $j++) {
           if(strtotime($dates[$j]) > strtotime($dates[$i])){
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
    public function transactionChart(){
        session_start();
        $id = $_SESSION['user_data']['id'];
        log_message("error", $_SESSION['user_data']['id']) ;
        $data = [];
        $profitLoss = new ProfitLoss();
        $profitLossDetails = $profitLoss->getByUserId_for_transition($id);
        log_message("error", sizeof($profitLossDetails)) ;
        $totalProfitNum = 0;
        $totalLossNum = 0;
        for($a=0;$a<sizeof($profitLossDetails);$a++){
            $profitLossDetails[$a]['type'] == 'Profit' ? $totalProfitNum++ : $totalLossNum++;
        }

        $data['profitLoss'][0] = $totalProfitNum ? round(( $totalProfitNum / sizeof($profitLossDetails)) * 100,1) : 0;
        $data['profitLoss'][1] = $totalLossNum ? round(( $totalLossNum / sizeof($profitLossDetails)) * 100, 1) : 0;
        return json_encode($data);
    }
    public function transactionChart_Overview(){
        session_start();
        $id = $_SESSION['user_data']['id'];
        // log_message("error", $_SESSION['user_data']['id']) ;
        $data = [];
        $profitLoss = new ProfitLoss();
        $profitLossDetails = $profitLoss->getByUserId_Overview($id);
        $totalProfitNum = 0;
        $totalLossNum = 0;
        for($a=0;$a<sizeof($profitLossDetails);$a++){
            $profitLossDetails[$a]['type'] == 'Profit' ? $totalProfitNum++ : $totalLossNum++;
        }
        $data['profitLoss'][0] = $totalProfitNum ? round(( $totalProfitNum / sizeof($profitLossDetails)) * 100,1) : 0;
        $data['profitLoss'][1] = $totalLossNum ? round(( $totalLossNum / sizeof($profitLossDetails)) * 100, 1) : 0;

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
        $users = new Users() ;
        $singleNotification = new Singlenotification();
        if(!isset($_GET['id']) || !isset($_GET['bearer_token'])){
            return json_encode('User not Authenticate') ;
        }else{
            $user = $users->getrow($_GET['id']) ;
        }
        if($_GET['bearer_token'] != $user['bearer_token'] ){
            return json_encode('User not Authenticate') ;
        }else{
            $id = $_GET['id'];
        }
        $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
        $data['viewall'] = 'Y';
        return json_encode($data) ;
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

    public function deposit(){
        $data = [];
        $singleNotification = new Singlenotification();
        $deposit = new Deposit();
        $users = new Users();
        if(!isset($_GET['id']) || !isset($_GET['bearer_token'])){
            return json_encode('User not Authenticate') ;
        }else{
			$user = $users->getrow($_GET['id']) ;
		}
        if($_GET['bearer_token'] != $user['bearer_token']){
            return json_encode("User Not Authenticate.");
        }else{
            $id = $_GET['id'];
        }
        // $userInfo = $users->getrow($id);
        $allDeposits = $deposit->getAllDepositsByUserId($id);
        $data['allDeposits'] = $allDeposits;
        $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
        return json_encode($data);
        
    }

    public function add_deposit(){
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
            foreach($allCurrencies as $single){
                $data['currency_options'][$single['slug']] = $currency_option->getByCurrencyId($single['id']);
            }
            $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
            return view('/home/addDeposit',$data);
        } else {
            return redirect()->to('/');
        }
    }

    public function submit_deposit(){
        

        $deposit = new Deposit();
        $users = new Users();
        $alert = new Alerts() ;
        $alert_status = new AlertStatus() ;
        if(!isset($_POST['id']) || !isset($_POST['bearer_token'])){
            return json_encode('User not Authenticate') ;
        }else{
			$user = $users->getrow($_POST['id']) ;
		}
        if($_POST['bearer_token'] != $user['bearer_token']){
            return json_encode('User not Authenticate') ;
        }else{
            $id = $_POST['id'];
        }
        $deposit->save([
            'user_id' => $id,
            'currency_id' => $_POST['currency_type'],
            'currency_option_id' => $_POST['crypto_type'],
            'amount' => $_POST['amount'],
            'status' => 'Pending',
            'message' => $_POST['message']
        ]);
        $user = $users->getrow($id) ;
        $fullName = $user['firstName'] . " " . $user['lastName'];
        log_message('debug' , 'User Names => '.$fullName);
        $alert->save([
            'title' => 'Deposit Request Received from '.ucfirst($user['firstName']). " " .ucfirst($user['lastName']),
            'description' => 'You have received a new Deposit Request from '.ucfirst($user['firstName']). " " .ucfirst($user['lastName']),
        ]) ;
        $alert_id = $alert->get_last_alert_id() ;
        $userId = $users->getAllAdminId() ;
        foreach ($userId as $key => $singleId) {
            $alert_status->save([
                'user_id' => $singleId['id'] ,
                'alerts_id' => $alert_id['id']
            ]);
        } 
        // if(!isset($_POST['id'])){
        //     $this->alertnotification('Deposit Request Received from '.ucfirst($user['firstName']). " " .ucfirst($user['lastName'])) ;
        // }
        $adminEmails = $users->getAllAdminEmails();
        $allAdminEmails = [];
        foreach ($adminEmails as  $single) {
            $allAdminEmails[] = $single['email'];
        }
        // print_r($allAdminEmails);
        // die();

        $cur = new Currency() ;// Getting Currency Type
        $currency = $cur->getById($_POST['currency_type']);
        $currname = $currency['name'] ;
        
        $opcur = new CurrencyOption() ; //Getting Currency Option
        $opcurrency = $opcur->getById($_POST['crypto_type']) ;
        $opcurrname = $opcurrency['name'] ;
        // $this->senddepositNotification();
        // $emailslib = new Emails ;  //Sending Email 
        // $emailslib->sendDeposit( $fullName , $currname  , $_POST['amount'] , $opcurrname , $allAdminEmails);
        
        $data = [];
        $singleNotification = new Singlenotification();
        $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
        return json_encode($data);
       
    }

    public function withdrawal(){
        $data = [];
        $users = new Users();
        if(!isset($_GET['id']) || !isset($_GET['bearer_token'])){
            return json_encode('User not Authenticate') ;
        }else{
			$user = $users->getrow($_GET['id']) ;
		}
        if($_GET['bearer_token'] != $user['bearer_token']){
            return json_encode("User Not Authenticate.");
        }else{
            $id = $_GET['id'];
        }
        // $userInfo = $users->getrow($id);
        $singleNotification = new Singlenotification();
        $withdraw = new Withdraw();
        $allWithdrawals = $withdraw->getAllWithdrawalsByUserId($id);
        $data['allWithdrawals'] = $allWithdrawals;
        $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
        return json_encode($data);
        
        
    }

    public function add_withdrawal(){
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
            foreach($allCurrencies as $single){
                $data['currency_options'][$single['slug']] = $currency_option->getByCurrencyId($single['id']);
            }
            $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
            
            return view('/home/addWithdrawal',$data);
        } else {
            return redirect()->to('/');
        }
    }

    public function submit_withdrawal(){
        // print_r($_POST);
        $alert = new Alerts() ;
        $alert_status = new AlertStatus() ;
        $users = new Users() ;
        $withdraw = new Withdraw();

        if(!isset($_POST['id']) || !isset($_POST['bearer_token'])){
            return json_encode('User not Authenticate') ;
        }else{
			$user = $users->getrow($_POST['id']) ;
		}
        if($_POST['bearer_token'] != $user['bearer_token']){
            return json_encode('User not Authenticate') ;
        }else{
            $id = $_POST['id'];
        }
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
        $user = $users->getrow($id) ; 
        $fullName = $user['firstName'] . " " . $user['lastName'];
        $alert->save([
            'title' => 'Withdrawal Request Received from '.ucfirst($user['firstName']). " " .ucfirst($user['lastName']),
            'description' => 'You have received a new Withdrawal Request from '.ucfirst($user['firstName']). " " .ucfirst($user['lastName']),
        ]) ;
        $alert_id = $alert->get_last_alert_id() ;
        $userId = $users->getAllAdminId() ;
        foreach ($userId as $key => $singleId) {
            $alert_status->save([
                'user_id' => $singleId['id'] ,
                'alerts_id' => $alert_id['id']
            ]);
        } 
        // if(!isset($_POST['id'])){
        //     $this->alertnotification('Withdrawal Request Received from '.ucfirst($user['firstName']). " " .ucfirst($user['lastName'])) ;
        // }
        // $users = new Users();
        $adminEmails = $users->getAllAdminEmails();
        $allAdminEmails = [];
        foreach ($adminEmails as  $single) {
            $allAdminEmails[] = $single['email'];
        }
        // print_r($allAdminEmails);
        // die();
        
        $cur = new Currency() ;// Getting Currency Type
        $currency = $cur->getById($_POST['currency_type']);
        $currname = $currency['name'] ;
        
        $opcur = new CurrencyOption() ; //Getting Currency Option
        $opcurrency = $opcur->getById($_POST['crypto_type']) ;
        $opcurrname = $opcurrency['name'] ;
        
        // $emailslib = new Emails ;  //Sending Email 
        // $emailslib->sendWithdrawa( $fullName , $currname  , $_POST['amount'] , $opcurrname , $allAdminEmails,$_POST['wallet_address']);

        $data = [];
        $singleNotification = new Singlenotification();
        $data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
        return json_encode($data) ;
        
        // return view('/home/successWithdrawal',$data);
    }
    
    public function overview(){
        $data = [];
        $profitLoss = new ProfitLoss();
        // $chat = new ChatMessage();
        $users = new Users();
        $payout = new Payout();
        $withdraw = new Withdraw();
        if(!isset($_GET['id']) || !isset($_GET['bearer_token'])){
            return json_encode('User not Authenticate') ;
        }else{
            $user = $users->getrow($_GET['id']) ;
        }
        if($_GET['bearer_token'] != $user['bearer_token'] ){
            return json_encode('User not Authenticate') ;
        }else{
            $id = $_GET['id'];
        }
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

        $data['initial'] = $users->getrow($id) ;
        $data['initial'] = $data['initial']['initialInvestment'] ;
        $data['totalProfitNum'] = 0;
        $data['totalLossNum'] = 0;
        for($a=0;$a<sizeof($data['profitLossDetails']);$a++){
            $data['profitLossDetails'][$a]['type'] == 'Profit' ? $data['totalProfitNum']++ : $data['totalLossNum']++;
        }
        return json_encode($data) ;
    }
    

    public function get_monthly_return(){
        $id = $_GET['user_id'];
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
		if(!empty($profitByMonth) && (int)$profitByMonth[$j]['year'] < (int)$_GET['year'] ){
		    while((int)$profitByMonth[$j]['year'] && (int)$profitByMonth[$j]['year'] < (int)$_GET['year']){
			    $j++;
			}
		}
		if(!empty($lossByMonth) && (int)$lossByMonth[$k]['year'] < (int)$_GET['year']){
			while((int)$lossByMonth[$k]['year'] && (int)$lossByMonth[$k]['year'] < (int)$_GET['year']){
			    $k++;
			}
		}
        for($i = 1; $i < 13; $i++){
		    if((!empty($profitByMonth[$j]) && $i==(int)$profitByMonth[$j]['month']) || (!empty($lossByMonth[$k]) && $i==(int)$lossByMonth[$k]['month'])){
			    if((!empty($profitByMonth[$j]) && !empty($lossByMonth[$k]) ) && ((int)$profitByMonth[$j]['month'] === (int)$lossByMonth[$k]['month'] )){
			        $data['profitLossMonthly'][$i] = number_format(((float)$profitByMonth[$j]['amount'] - (float)$lossByMonth[$k]['amount']), 2, '.', '');
			        $data['profitLossMonthly']['total'] += (($profitByMonth[$j]['amount'] - $lossByMonth[$k]['amount'])); 
    		        $j++;
    		        $k++;
			    }else if(empty($lossByMonth[$k]) || (!empty($profitByMonth[$j]) && (int)$profitByMonth[$j]['month'] < (int)$lossByMonth[$k]['month']) ){
			        $data['profitLossMonthly'][$i] = number_format((float)(($profitByMonth[$j]['amount'])), 2, '.', '');
			        $data['profitLossMonthly']['total'] += (float)($profitByMonth[$j]['amount']);
			        $j++;
			    }else if(empty($profitByMonth[$j]) || (!empty($lossByMonth[$k]) && (int)$profitByMonth[$j]['month'] > (int)$lossByMonth[$k]['month']) ){
			        $data['profitLossMonthly'][$i] = number_format((float)((($lossByMonth[$k]['amount']))), 2, '.', '') * -1;
			        $data['profitLossMonthly']['total'] += (float)($lossByMonth[$k]['amount']) * -1;
			        $k++;
			    }
		    }else{
		        $data['profitLossMonthly'][$i] = 0;
		    }
		}
		$data['profitLossMonthly']['total'] = $data['profitLossMonthly']['total'] ? number_format((float)($data['profitLossMonthly']['total']), 2, '.', '') : 0;
			
		return json_encode($data);
    }
    public function report_genrate()
	{
	    log_message('debug', '***************** Chart BY Admin *****************' .var_export($_POST,true));
        $date = '';
        $cdate = 0;
        $data = [];
        if(isset($_POST['select_duration'])){
            if($_POST['select_duration'] == 'TM'){
                $date = date('Y-m');
                $data['start_date'] = date('m-01-Y');
                $data['end_date'] = date('m-t-Y');
            }elseif($_POST['select_duration'] == 'CY'){
                $date = date('Y');
                $data['start_date'] = '01-01-'.$date;
                $data['end_date'] = '12-30-'.$date;
            }elseif($_POST['select_duration'] == 'LM'){
                $date = date('Y-m',strtotime("-1 month"));
                $data['start_date'] = date('m-01-Y',strtotime("-1 month"));
                $data['end_date'] = date('m-t-Y',strtotime("-1 month"));
            }elseif($_POST['select_duration'] == 'L9D'){
                $date = date('Y-m-d 00:00:00',strtotime("-3 month"));
                $cdate = date('Y-m-d 23:00:00');
                // $cdate = date('Y-m-d H:i:s', strtotime($cdate . ' +1 day'));

            }elseif($_POST['select_duration'] == 'Custom_date'){
                $date =  $_POST['start_date']." ".'23:00:00';
                // $date = date('Y-m-d H:i:s', strtotime($date . ' +1 day'));
                $cdate = $_POST['end_date']." ".'23:00:00';
                // $cdate = date('Y-m-d H:i:s', strtotime($cdate . ' +1 day'));
                $data['start_date'] = $_POST['start_date'];
                $data['end_date'] = $_POST['end_date'];

            }
        }
        $profitLoss = new ProfitLoss();
        $users = new Users();
        $deposit = new Deposit();
        $payout = new Payout();
        $withdraw = new Withdraw();
        if(!isset($_POST['id'])||!isset($_POST['bearer_token'])){
            return json_encode('User Not Authentication');
        }else{
			$user = $users->getrow($_POST['id']) ;
		}
        if($_POST['bearer_token'] != $user['bearer_token']){
            return json_encode('User not Authenticate');
        }else{
            $id = $_POST['id'];
        }
        $profitLos = array();
        $withdra = array();
        $deposi = array();
        $userInfo = $users->getrow($id);
        if($cdate == 0){
            $profitLos = $profitLoss->getByUserId_current_month($id,$date);
            $withdra = $withdraw->getByUserId_current_month($id,$date);
            $deposi = $deposit->getByUserId_current_month($id,$date);
            $payou = $payout->getByUserId_current_month($id,$date);
        }else{
            $profitLos = $profitLoss->getByUserId_months($id,$cdate,$date);
            $withdra = $withdraw->getByUserId_months($id,$cdate,$date);
            $deposi = $deposit->getByUserId_months($id,$cdate,$date);
            $payou = $payout->getByUserId_months($id,$cdate,$date);
            // log_message('debug', '***************** Chart BY Admin *****************'.var_export($payou,true));
        }
        $a = array();
        $report = new Report();
        for($i = 0 ;$i<sizeof($profitLos);$i++){
            $data['profitLossDetails'] = $profitLoss->getByUserId($id);
            $payoutSum = $payout->getsum_month($id,$profitLos[$i]['publishDate']);
            $data['payoutSum'] = $payoutSum;
            $data['lastpayout'] = $payout->getPayoutsdesc($id);
            $returnType = $users->getReturnTypeId($id);
            $data['returnType'] = $returnType;
            $profit = $profitLoss->getTotalProfitById_by_date($id,$profitLos[$i]['publishDate']);
            $loss = $profitLoss->getTotalLossById_by_date($id,$profitLos[$i]['publishDate']);
            $data['profitLoss'] = $profit - $loss;
            if($cdate == 0){
                $depositAcceptedAll = $deposit->getAcceptedDepositByUserId_month($id,$date,$profitLos[$i]['publishDate']);
            }else{
                $depositAcceptedAll = $deposit->getAcceptedDepositByUserId_range($id,$date,$cdate,$profitLos[$i]['publishDate']);
            }
            $depositAcceptedAll = $depositAcceptedAll ? $depositAcceptedAll : 0;
            $payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;
            $completedWithdrawals = $withdraw->getCompletedByUserId_month($id,$date,$profitLos[$i]['publishDate']);
            $payoutAll += $completedWithdrawals;
            $data['payoutAll'] = $payoutAll;
            $pendingWithdraw = $withdraw->getAllPendingByUserId_month($id,$date);
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
        for($i = 0 ;$i<sizeof($withdra);$i++){    
            $data['profitLossDetails'] = $profitLoss->getByUserId($id);
            $payoutSum = $payout->getsum_month($id,$withdra[$i]['paid_date']);
            $data['payoutSum'] = $payoutSum;
            $data['lastpayout'] = $payout->getPayoutsdesc($id);
            $returnType = $users->getReturnTypeId($id);
            $data['returnType'] = $returnType;
            $data['userInfo'] = $userInfo;
            $profit = $profitLoss->getTotalProfitById_by_daterange($id,$withdra[$i]['paid_date'],$cdate);
            $loss = $profitLoss->getTotalLossById_by_daterange($id,$withdra[$i]['paid_date'],$cdate);
            $data['profitLoss'] = $profit - $loss;
            if($cdate == 0){
                $depositAcceptedAll = $deposit->getAcceptedDepositByUserId_month($id,$date,$withdra[$i]['paid_date']);
            }else{
                $depositAcceptedAll = $deposit->getAcceptedDepositByUserId_range($id,$date,$cdate,$withdra[$i]['paid_date']);
            }
            $depositAcceptedAll = $depositAcceptedAll ? $depositAcceptedAll : 0;
            $payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;
            $completedWithdrawals = $withdraw->getCompletedByUserId_month($id,$date,$withdra[$i]['paid_date']);
            $payoutAll += $completedWithdrawals;
            $data['payoutAll'] = $payoutAll;
            $pendingWithdraw = $withdraw->getAllPendingByUserId_month($id,$date);
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
        for($i = 0 ;$i<sizeof($deposi);$i++){
            $data['profitLossDetails'] = $profitLoss->getByUserId($id);
            $payoutSum = $payout->getsum_month($id,$deposi[$i]['accepted_date']);
            $data['payoutSum'] = $payoutSum;
            $data['lastpayout'] = $payout->getPayoutsdesc($id);
            $returnType = $users->getReturnTypeId($id);
            $data['returnType'] = $returnType;
            $profit = $profitLoss->getTotalProfitById_by_date($id,$deposi[$i]['accepted_date']);
            $loss = $profitLoss->getTotalLossById_by_date($id,$deposi[$i]['accepted_date']);
            $data['profitLoss'] = $profit - $loss;
            if($cdate == 0){
                $depositAcceptedAll = $deposit->getAcceptedDepositByUserId_month($id,$date,$deposi[$i]['accepted_date']);
            }else{
                $depositAcceptedAll = $deposit->getAcceptedDepositByUserId_range($id,$date,$cdate,$deposi[$i]['accepted_date']);
            }
            $depositAcceptedAll = $depositAcceptedAll ? $depositAcceptedAll : 0;
            $payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;
            $completedWithdrawals = $withdraw->getCompletedByUserId_month($id,$date,$deposi[$i]['accepted_date']);
            $payoutAll += $completedWithdrawals;
            $data['payoutAll'] = $payoutAll;
            $pendingWithdraw = $withdraw->getAllPendingByUserId_month($id,$date);
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
        for($i = 0 ;$i<sizeof($payou);$i++){
            $data['profitLossDetails'] = $profitLoss->getByUserId($id);
            $payoutSum = $payout->getsum_month($id,$payou[$i]['payoutdate']);
            $data['payoutSum'] = $payoutSum;
            $data['lastpayout'] = $payout->getPayoutsdesc($id);
            $returnType = $users->getReturnTypeId($id);
            $data['returnType'] = $returnType;
            $profit = $profitLoss->getTotalProfitById_by_date_for_payout($id,$payou[$i]['payoutdate']);
            $loss = $profitLoss->getTotalLossById_for_payout($id,$payou[$i]['payoutdate']);
            $data['profitLoss'] = $profit - $loss;
            if($cdate == 0){
                $depositAcceptedAll = $deposit->getAcceptedDepositByUserId_month($id,$date,$payou[$i]['payoutdate']);
            }else{
                $depositAcceptedAll = $deposit->getAcceptedDepositByUserId_range($id,$date,$cdate,$payou[$i]['payoutdate']);
            }
            $depositAcceptedAll = $depositAcceptedAll ? $depositAcceptedAll : 0;
            $payoutAll = (float)$payoutSum[0]['amount'] ? (float)$payoutSum[0]['amount'] : 0;
            $completedWithdrawals = $withdraw->getCompletedByUserId_month($id,$date,$payou[$i]['payoutdate']);
            $payoutAll += $completedWithdrawals;
            $data['payoutAll'] = $payoutAll;
            $pendingWithdraw = $withdraw->getAllPendingByUserId_month($id,$date);
            $data['pendingWithdraw'] = $pendingWithdraw;
            $totalBalance = ((float)$userInfo['initialInvestment'] + (float)$depositAcceptedAll + (float)$data['profitLoss']) - (float)$pendingWithdraw - (float)$payoutAll;
            log_message('debug', '***************** Chart BY Admin44 *****************'.$payou[$i]['amount'] . var_export($totalBalance,true) ." ".var_export($userInfo['initialInvestment'],true) ." ".var_export($depositAcceptedAll,true) ." Tp".var_export($data['profitLoss'],true) ." ".var_export($pendingWithdraw,true)." ".var_export($payoutAll,true));
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
        $data['startAmount'] = '' ;
        if(isset($b_amount[0]['balance'])){
            $data['startAmount'] = (float)$b_amount[0]['balance'];
        }
        if(isset($b_amount[0]['payout'])){
            $data['startAmount'] = (float)$b_amount[0]['balance']+(float)$b_amount[0]['payout']; 
        }elseif(isset($b_amount[0]['widthra'])){
            $data['startAmount'] = $b_amount[0]['balance']+$b_amount[0]['widthra']; 
        }elseif(isset($b_amount[0]['deposit'])){
            $data['startAmount'] = $b_amount[0]['balance']-$b_amount[0]['deposit']; 
        }elseif(isset($b_amount[0]['trasition'])){
        if (isset($b_amount[0]['type']) && $b_amount[0]['type'] == 'Profit'){
            $data['startAmount'] = $b_amount[0]['balance']-$b_amount[0]['trasition']; 
        }elseif(isset($b_amount[0]['type']) && $b_amount[0]['type'] == 'Loss'){
            $data['startAmount'] = $b_amount[0]['balance']+$b_amount[0]['trasition']; 
        }
        }
         $data['endAmount'] = '' ;
        // $data['endAmount'] =  (float)($data['startAmount'] + $data['depositSum'] + ($data['PSum']-$data['LSum'])) - ($data['withdrawSum'] + $data['payoutSum']);
        if(sizeof($b_amount)>0){
            $data['endAmount'] = (float)$b_amount[sizeof($b_amount) - 1]['balance'];
        }
        $report->deleteData($id);
        $all_user = new Users();
        $all_taransaction = new ProfitLoss();
        $data['alluser'] = $all_user->getCustomers();
        $data['userInfo'] = $userInfo;
        $data['allprofitloass'] = $all_taransaction->getByUserId($id);
        return json_encode($data);
        
	}
}
