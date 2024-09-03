<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Client Dashboard - <?php echo APP_NAME ?></title>
  <?php echo view("/home/new-header-links"); ?>
 
</head>
 
<body>
<svg style="width: 0; height: 0; position: absolute;">
    <defs>
      <linearGradient id="Gradient2" x1="0" x2="0" y1="0" y2="1">
        <stop offset="0%" stop-color="#6B788E" />
        <stop offset="100%" stop-color="#6B788E" stop-opacity="0" />
      </linearGradient>
    </defs>
  </svg>
  <div class="app_wrapper">

    <?php echo view("/home/left-sidebar-new"); ?>

    <main class="main">

      <?php if (isset($callChartAdmin) && $callChartAdmin == true) : ?>
        <a href="<?php echo base_url(); ?>"><button style="margin-bottom: 10px;" class="statement_btn">Back</button></a>
        <a href="<?php echo base_url() . "/admin/report_genrate?userid=" . $_GET['userid']; ?>"><button style="margin-bottom: 10px;" class="statement_btn">Client Statement</button></a>
        <?php if (array_key_exists(0, $tax_form_data)) : ?>
          <!-- <a href="<?php echo base_url() . "/admin/admin_tax_form?userid=" . $_GET['userid']; ?>"><button style="margin-bottom: 10px;" class="statement_btn">Tax Form</button></a> -->
        <?php endif; ?>
        <input type="hidden" id="forChartUserId" value="<?php echo $userInfo['id']; ?>">
      <?php endif; ?>
      <!-- Start Content-->
      <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
      <input type="hidden" id="user_id" value="<?php if (isset($_GET['userid'])) echo $_GET['userid'] ? $_GET['userid'] : $_SESSION['user_data']['id'];
                                                else $_SESSION['user_data']['id']; ?>">
      <div class="row row-gap">
        <div class="col-lg-8 col-xl-9">
          <div class="row row-gap">
            <div class="col-sm-6 col-xl-3">
              <div class="card details-card">
                <p class="details-card__sub-hdng">Total Balance</p>
                <h2 class="details-card__hdng">$<?php echo number_format((int)$totalBalance); ?></h2>
                <!-- <p class="details-card__desc">will be increase in this year</p> -->
                <div class="details-card__desc" style="height: 23px;"> <span class="text-color-topaz"></span> 
                </div>
              </div>
            </div>
            <?php $totalProfit = round((float)($userInfo['initialInvestment'] - ((float)$userInfo['initialInvestment'] - (float)$profitLoss)), 2);
            $totalProfit = number_format($totalProfit);
            ?>
            <div class="col-sm-6 col-xl-3">
              <div class="card details-card">
                <p class="details-card__sub-hdng">Total Profit</p>
                <h2 class="details-card__hdng">$<?= $totalProfit  ?></h2>
                <div class="details-card__desc"> <span class="text-color-topaz"><?php echo number_format($percentage_fot_profit_box, 1, '.', ''); ?>%</span> Increase
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xl-3">
              <div class="card details-card">
                <p class="details-card__sub-hdng">Pending Payout</p>
                <h2 class="details-card__hdng">$<?= number_format(round(((float)$pendingWithdraw), 2));  ?></h2>
                <div class="details-card__desc"> <span class="text-color-topaz"><?php echo number_format($percentage_fot_p_payout_box, 1, '.', ''); ?>%</span> Under Review
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xl-3">
              <div class="card details-card">
                <p class="details-card__sub-hdng">Total Payout (Till Date)</p>
                <h2 class="details-card__hdng">$<?php echo number_format((int)$payoutAll); ?></h2>
                <div class="details-card__desc"> <span class="text-color-topaz"><?php echo number_format($percentage_fot_payout_box, 1, '.', ''); ?>%</span> Withdrawn
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card profit-loss-card">
                <div class="profit-loss-card__hdr">
                  <h1 class="profit-loss-card__hdng">Profit and Loss Chart</h1>
                  <p class="profit-loss-card__desc">Transaction Chart</p>
                </div>
                <!-- <div id="chart"></div> -->
                <div id="apex-line-2" class="apex-charts" data-colors="#f672a7"></div>
                <!-- <canvas id="profitLossChart"></canvas> -->
              </div>
            </div>
             <!-- TradingView Widget BEGIN -->
<!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-tickers.js" async>
  {
  "symbols": [
    {
      "proName": "FOREXCOM:SPXUSD",
      "title": "S&P 500 Index"
    },
    {
      "proName": "BITSTAMP:BTCUSD",
      "title": "Bitcoin"
    },
    {
      "proName": "BITSTAMP:ETHUSD",
      "title": "Ethereum"
    },
    {
      "description": "Dow Jones",
      "proName": "BLACKBULL:US30"
    },
    {
      "description": "GOLD",
      "proName": "OANDA:XAUUSD"
    }
  ],
  "isTransparent": false,
  "showSymbolLogo": true,
  "colorTheme": "light",
  "locale": "en"
}
  </script>
</div>
<!-- TradingView Widget END -->
            <div class="col-md-6 col-lg-12 col-xl-6">
              <h2 class="transaction__hdng">Transactions</h2>
              <p class="transaction__desc">Details of transactions</p>
              <div class="card transaction-card">
                <div class="flex-i justify-between transaction-card-wrapper">
                  <div class="transaction-card__content">
                    <h6 class="trnHdng">Positions:</h6>
                    <p class="transaction-card__desc">Total Positions</p>
                  </div>
                  <div class="transaction-card__chart-holder">
                    <canvas class="progressChart" id="progressChart1"></canvas>
                    <div class="chart-value" id="chartValue1"></div>
                  </div>
                </div>
              </div>
              <div class="card transaction-card">
                <div class="flex-i justify-between transaction-card-wrapper">
                  <div class="transaction-card__content">
                    <h6 class="trnHdng">Profit:</h6>
                    <p class="transaction-card__desc">Total Win Rate</p>
                  </div>
                  <?php
                  $profitable = 0;
                  if ($totalProfitNum) {
                    $profitable = number_format((float)(($totalProfitNum / (float)sizeof($profitLossDetails)) * 100), 1, '.', '');
                  }
                  ?>
                  <div class="transaction-card__chart-holder">
                    <canvas class="progressChart" id="progressChart2"></canvas>
                    <div class="chart-value" id="chartValue2"></div>
                  </div>
                </div>
              </div>
              <div class="card transaction-card">
                <div class="flex-i justify-between transaction-card-wrapper">
                  <div class="transaction-card__content">
                    <h6 class="trnHdng">Loss:</h6>
                    <p class="transaction-card__desc">Total Loss Rate</p>
                  </div>
                  <?php
                  $losing = 0;
                  if ($totalLossNum) {
                    $losing = number_format((float)(($totalLossNum / (float)sizeof($profitLossDetails)) * 100), 1, '.', '');
                  }
                  ?>
                  <div class="transaction-card__chart-holder">
                    <canvas class="progressChart" id="progressChart3"></canvas>
                    <div class="chart-value" id="chartValue3"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-12 col-xl-6">
              <div class="card monthly-return">
                <div class="row">
                <div class="col-md-6 col-lg-6 col-sm-12">
                <h2 class="monthly-return__hdng">Monthly Return</h2>
                </div>
                <div class="offset-md-7 col-md-2 offset-lg-7 col-lg-2 offset-sm-1 col-sm-1 monthly-return-year">
                                  <select class="tn-list-card__select" name="year" id="monthlyReturnYear" style="text-align: center; margin-bottom: 30px; cursor:pointer;">
                                      <?php 
                                            $currentYear = date("Y");
                                            $minYear = 2023;
                                            $noOfYears = $currentYear - $minYear +1;
                                      ?>
                                      <?php for($i=0; $i < $noOfYears; $i++): ?>
                                        <option value="<?php echo $currentYear - $i; ?> "><?php echo $currentYear - $i; ?></option>
                                      <?php endfor; ?>
                                  </select>
                                </div>
                </div>
                <ul class="monthly-return-list cols-2">
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">January</div>
                    <div id="t_jan" class="">
                      <?php if ($profitLossMonthly[1] == 0) : ?>
                        <?php echo $profitLossMonthly[1]; ?>
                      <?php elseif ($profitLossMonthly[1] > 0) : ?>
                        <div class="text-color-topaz flex-i">
                          <img src="<?php echo base_url(); ?>/assets-new/images/icons/up.svg" alt="">
                          &nbsp; <?php echo $profitLossMonthly[1]; ?>
                        </div>
                      <?php else : ?>
                        <div class="text-color-chili-papper flex-i">
                          <img src="<?php echo base_url(); ?>/assets-new/images/icons/down.svg" alt="">
                          &nbsp; <?php echo $profitLossMonthly[1]; ?>
                        </div>
                      <?php endif; ?>
                    </div>
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">February</div>
                    <div id="t_feb" class="">
                    <?php if ($profitLossMonthly[2] == 0) : ?>
                      <?php echo $profitLossMonthly[2]; ?>
                    <?php elseif ($profitLossMonthly[2] > 0) : ?>
                      <div class="text-color-topaz flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/up.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[2]; ?>
                      </div>
                    <?php else : ?>
                      <div class="text-color-chili-papper flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/down.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[2]; ?>
                      </div>
                    <?php endif; ?>
                    </div>
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">March</div>
                    <div id="t_mar" class="">
                      <?php if ($profitLossMonthly[3] == 0) : ?>
                        <?php echo $profitLossMonthly[3]; ?>
                      <?php elseif ($profitLossMonthly[3] > 0) : ?>
                        <div class="text-color-topaz flex-i">
                          <img src="<?php echo base_url(); ?>/assets-new/images/icons/up.svg" alt="">
                          &nbsp; <?php echo $profitLossMonthly[3]; ?>
                        </div>
                      <?php else : ?>
                        <div class="text-color-chili-papper flex-i">
                          <img src="<?php echo base_url(); ?>/assets-new/images/icons/down.svg" alt="">
                          &nbsp; <?php echo $profitLossMonthly[3]; ?>
                        </div>
                      <?php endif; ?>
                    </div>
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">April</div>
                    <div id="t_apr" class="">
                    <?php if ($profitLossMonthly[4] == 0) : ?>
                      <?php echo $profitLossMonthly[4]; ?>
                    <?php elseif ($profitLossMonthly[4] > 0) : ?>
                      <div class="text-color-topaz flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/up.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[4]; ?>
                      </div>
                    <?php else : ?>
                      <div class="text-color-chili-papper flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/down.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[4]; ?>
                      </div>
                    <?php endif; ?>
                    </div>
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">May</div>
                    <div id="t_may" class="">
                    <?php if ($profitLossMonthly[5] == 0) : ?>
                      <?php echo $profitLossMonthly[5]; ?>
                    <?php elseif ($profitLossMonthly[5] > 0) : ?>
                      <div class="text-color-topaz flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/up.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[5]; ?>
                      </div>
                    <?php else : ?>
                      <div class="text-color-chili-papper flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/down.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[5]; ?>
                      </div>
                    <?php endif; ?>
                    </div>
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">June</div>
                    <div id="t_jun" class="">
                    <?php if ($profitLossMonthly[6] == 0) : ?>
                      <?php echo $profitLossMonthly[6]; ?>
                    <?php elseif ($profitLossMonthly[6] > 0) : ?>
                      <div class="text-color-topaz flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/up.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[6]; ?>
                      </div>
                    <?php else : ?>
                      <div class="text-color-chili-papper flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/down.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[6]; ?>
                      </div>
                    <?php endif; ?>
                    </div>
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">July</div>
                    <div id="t_jul" class="">
                    <?php if ($profitLossMonthly[7] == 0) : ?>
                      <?php echo $profitLossMonthly[7]; ?>
                    <?php elseif ($profitLossMonthly[7] > 0) : ?>
                      <div class="text-color-topaz flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/up.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[7]; ?>
                      </div>
                    <?php else : ?>
                      <div class="text-color-chili-papper flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/down.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[7]; ?>
                      </div>
                    <?php endif; ?>
                    </div>
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">August</div>
                    <div id="t_aug" class="">
                    <?php if ($profitLossMonthly[8] == 0) : ?>
                      <?php echo $profitLossMonthly[8]; ?>
                    <?php elseif ($profitLossMonthly[8] > 0) : ?>
                      <div class="text-color-topaz flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/up.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[8]; ?>
                      </div>
                    <?php else : ?>
                      <div class="text-color-chili-papper flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/down.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[8]; ?>
                      </div>
                    <?php endif; ?>
                    </div>
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">September</div>
                    <div id="t_sep" class="">
                    <?php if ($profitLossMonthly[9] == 0) : ?>
                      <?php echo $profitLossMonthly[9]; ?>
                    <?php elseif ($profitLossMonthly[9] > 0) : ?>
                      <div class="text-color-topaz flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/up.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[9]; ?>
                      </div>
                    <?php else : ?>
                      <div class="text-color-chili-papper flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/down.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[9]; ?>
                      </div>
                    <?php endif; ?>
                    </div>
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">October</div>
                    <div id="t_oct" class="">
                    <?php if ($profitLossMonthly[10] == 0) : ?>
                      <?php echo $profitLossMonthly[10]; ?>
                    <?php elseif ($profitLossMonthly[10] > 0) : ?>
                      <div class="text-color-topaz flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/up.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[10]; ?>
                      </div>
                    <?php else : ?>
                      <div class="text-color-chili-papper flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/down.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[10]; ?>
                      </div>
                    <?php endif; ?>
                    </div>
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">November</div>
                    <div id="t_nov" class="">
                    <?php if ($profitLossMonthly[11] == 0) : ?>
                      <?php echo $profitLossMonthly[11]; ?>
                    <?php elseif ($profitLossMonthly[11] > 0) : ?>
                      <div class="text-color-topaz flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/up.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[11]; ?>
                      </div>
                    <?php else : ?>
                      <div class="text-color-chili-papper flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/down.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[11]; ?>
                      </div>
                    <?php endif; ?>
                    </div>
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">December</div>
                    <div id="t_dec" class="">
                    <?php if ($profitLossMonthly[12] == 0) : ?>
                      <?php echo $profitLossMonthly[12]; ?>
                    <?php elseif ($profitLossMonthly[12] > 0) : ?>
                      <div class="text-color-topaz flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/up.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[12]; ?>
                      </div>
                    <?php else : ?>
                      <div class="text-color-chili-papper flex-i">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/down.svg" alt="">
                        &nbsp; <?php echo $profitLossMonthly[12]; ?>
                      </div>
                    <?php endif; ?>
                    </div>
                  </li>
                </ul>
                <div class="monthly-return__total flex-i justify-between">
                  <span>Total</span>
                  <span id="t_total"><?php

                        // Create a sub-array excluding the first element (index 0)
                        $subArray = array_slice($profitLossMonthly, 1);

                        // Calculate the sum of the sub-array
                        $totalSum = array_sum($subArray);

                        echo $totalSum;
                        ?></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-xl-3">
          <div class="card tn-list-card" style="height: 100%;">
            <h2 class="tn-list-card__hdng">Transaction List</h2>
            <p class="tn-list-card__desc">
              Following are the detail records of your transactions
            </p>
            <select class="tn-list-card__select filterselect" id="filterSelectl">
              <option value="all">Show All</option>
              <option value="profit">Profit</option>
              <option value="loss">Loss</option>
            </select>
            <table class="table profitlossTable" id="profitLoss-table">
              <thead>
                <tr class="table-head__row">
                  <th class="table__hdng">Profit/loss</th>
                  <th class="table__hdng">Date</th>
                  <th class="table__hdng">Amount</th>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($profitLossDetails)) : ?>
                  <?php foreach ($profitLossDetails as $singleDetail) : ?>
                    <tr class="table__row <?php if ($singleDetail['type'] == 'Profit') :  echo "profit-row"; ?><?php else : echo "loss-row"; endif;?>">
                      <td class="teble__col1"><?php echo $singleDetail['type']; ?></td>
                      <td class="teble__col2"><?php echo date('M d, Y', strtotime($singleDetail['publishDate'])); ?></td>
                      <td class="teble__col3">
                        <?php if ($singleDetail['type'] == 'Profit') : ?>
                          <div class="text-color-topaz flex-i">
                            <img src="<?php echo base_url(); ?>/assets-new/images/icons/up.svg" alt="">
                            &nbsp; $<?php echo $singleDetail['amount']; ?>
                          </div>
                        <?php else : ?>
                          <div class="text-color-chili-papper flex-i">
                            <img src="<?php echo base_url(); ?>/assets-new/images/icons/down.svg" alt="">
                            &nbsp; $<?php echo $singleDetail['amount']; ?>
                          </div>
                        <?php endif; ?>

                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else : ?>
                  <h3 style="text-align: center;">No Profit/Loss found</h3>
                <?php endif; ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
  <?php echo view("/home/new-footer-scripts"); ?>
  
 
  <script>
    var value1 = <?php echo json_encode(sizeof($profitLossDetails)); ?>;
    var value2 = <?php echo json_encode($profitable); ?>;
    var value3 = <?php echo json_encode($losing); ?>;
    var waveChart = <?php echo $waveChart; ?>;
    $("#monthlyReturnYear").change(function(){
            let year = $(this).val();
            let base_url = $("#base_url").val();
            let user_id = $("#user_id").val();
                profitLossWithIcon('t_jan',0);
                profitLossWithIcon('t_feb',0);
                profitLossWithIcon('t_mar',0);
                profitLossWithIcon('t_apr',0);
                profitLossWithIcon('t_may',0);
                profitLossWithIcon('t_jun',0);
                profitLossWithIcon('t_jul',0);
                profitLossWithIcon('t_aug',0);
                profitLossWithIcon('t_sep',0);
                profitLossWithIcon('t_oct',0);
                profitLossWithIcon('t_nov',0);
                profitLossWithIcon('t_dec',0);
                profitLossWithIcon('t_total',0);
            $.get(base_url + "/user/get_monthly_return?user_id=" + user_id + "&year=" + year, function( data ) {
                let response = JSON.parse(data);
                console.log(response);
                $("#t_year").text(year);
                profitLossWithIcon('t_jan',response['profitLossMonthly'][1]);
                profitLossWithIcon('t_feb',response['profitLossMonthly'][2]);
                profitLossWithIcon('t_mar',response['profitLossMonthly'][3]);
                profitLossWithIcon('t_apr',response['profitLossMonthly'][4]);
                profitLossWithIcon('t_may',response['profitLossMonthly'][5]);
                profitLossWithIcon('t_jun',response['profitLossMonthly'][6]);
                profitLossWithIcon('t_jul',response['profitLossMonthly'][7]);
                profitLossWithIcon('t_aug',response['profitLossMonthly'][8]);
                profitLossWithIcon('t_sep',response['profitLossMonthly'][9]);
                profitLossWithIcon('t_oct',response['profitLossMonthly'][10]);
                profitLossWithIcon('t_nov',response['profitLossMonthly'][11]);
                profitLossWithIcon('t_dec',response['profitLossMonthly'][12]);
                profitLossWithIcon('t_total',response['profitLossMonthly']['total']);
            });
        });
        function profitLossWithIcon(id, value){
            if(value == 0){
                $("#"+id).text(value);
            }else if(value > 0){
                $("#"+id).html('<img src="https://localhost/golong-anwar/assets-new/images/icons/up.svg" alt="">&nbsp;' + value);
            }else{
                $("#"+id).html('<img src="https://localhost/golong-anwar/assets-new/images/icons/down.svg" alt="">&nbsp;' + (value * -1));
            }
        }
  </script>
   <?php if (isset($callChartAdmin) && $callChartAdmin == true) : ?>
    <script src="<?php echo base_url(); ?>/assets/js/pages/admincharts.init.js?v=<?php echo date('Y-m-d H:i:s'); ?>"></script>
  <?php else : ?>
    <script src="<?php echo base_url(); ?>/assets/js/pages/apexcharts2.init.js?v=<?php echo date('Y-m-d H:i:s') ?>"></script>
  <?php endif; ?>
</body>
</html>