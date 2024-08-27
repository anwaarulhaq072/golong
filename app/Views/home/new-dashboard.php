<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Client Dashboard - <?php echo APP_NAME ?></title>
  <?php echo view("/home/new-header-links"); ?>
 
</head>
 
<body>
  <div class="app_wrapper">

    <?php echo view("/home/left-sidebar-new"); ?>

    <main class="main">
      <?php if (isset($callChartAdmin) && $callChartAdmin == true) : ?>
        <a href="<?php echo base_url(); ?>"><button style="margin-bottom: 10px;" class="statement_btn">Back</button></a>
        <a href="<?php echo base_url() . "/admin/report_genrate?userid=" . $_GET['userid']; ?>"><button style="margin-bottom: 10px;" class="statement_btn">Client Statement</button></a>
        <?php if (array_key_exists(0, $tax_form_data)) : ?>
          <a href="<?php echo base_url() . "/admin/admin_tax_form?userid=" . $_GET['userid']; ?>"><button style="margin-bottom: 10px;" class="statement_btn">Tax Form</button></a>
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
                <p class="details-card__sub-hdng">Total Investment</p>
                <h2 class="details-card__hdng">$<?php echo number_format((int)$totalBalance); ?></h2>
                <!-- <p class="details-card__desc">will be increase in this year</p> -->
              </div>
            </div>
            <?php $totalProfit = round((float)($userInfo['initialInvestment'] - ((float)$userInfo['initialInvestment'] - (float)$profitLoss)), 2);
            $totalProfit = number_format($totalProfit);
            ?>
            <div class="col-sm-6 col-xl-3">
              <div class="card details-card">
                <p class="details-card__sub-hdng">Total Profit</p>
                <h2 class="details-card__hdng">$<?= $totalProfit  ?></h2>
                <!-- <div class="details-card__desc"> <span class="text-color-topaz">0.8%</span> will be increase in this
                  year
                </div> -->
              </div>
            </div>
            <div class="col-sm-6 col-xl-3">
              <div class="card details-card">
                <p class="details-card__sub-hdng">Pending Payout</p>
                <h2 class="details-card__hdng">$<?= number_format(round(((float)$pendingWithdraw), 2));  ?></h2>
                <!-- <div class="details-card__desc"> <span class="text-color-topaz">0.8%</span> will be increase in this
                  year
                </div> -->
              </div>
            </div>
            <div class="col-sm-6 col-xl-3">
              <div class="card details-card">
                <p class="details-card__sub-hdng">Total Payout (Till Date)</p>
                <h2 class="details-card__hdng">$<?php echo number_format((int)$payoutAll); ?></h2>
                <!-- <div class="details-card__desc"> <span class="text-color-topaz">0.8%</span> will be increase in this
                  year
                </div> -->
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
            <div class="col-md-6 col-lg-12 col-xl-6">
              <h2 class="transaction__hdng">Transactions</h2>
              <p class="transaction__desc">Details of transactions</p>
              <div class="card transaction-card">
                <div class="flex-i justify-between transaction-card-wrapper">
                  <div class="transaction-card__content">
                    <h6 class="trnHdng">Positions</h6>
                    <p class="transaction-card__desc">Total position from start to till now</p>
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
                    <h6 class="trnHdng">Profit</h6>
                    <p class="transaction-card__desc">Total profit from start to till now</p>
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
                    <h6 class="trnHdng">Losing</h6>
                    <p class="transaction-card__desc">Total loss from start to till now</p>
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
                <h2 class="monthly-return__hdng">Monthly Return</h2>
                <ul class="monthly-return-list cols-2">
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">January</div>
                    <div class="">
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
                    February
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
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">March</div>
                    <div class="">
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
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">May</div>
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
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">June</div>
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
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">july</div>
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
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">August</div>
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
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">September</div>
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
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">October</div>
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
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">November</div>
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
                  </li>
                  <li class="monthly-return-list__item flex-i justify-between">
                    <div class="">December</div>
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
                  </li>
                </ul>
                <div class="monthly-return__total flex-i justify-between">
                  <span>Total</span>
                  <span><?php

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
          <div class="card tn-list-card">
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
  </script>
  <?php if (isset($callChartAdmin) && $callChartAdmin == true) : ?>
    <script src="<?php echo base_url(); ?>/assets/js/pages/admincharts.init.js"></script>
  <?php else : ?>
    <script src="<?php echo base_url(); ?>/assets/js/pages/apexcharts.init.js"></script>
  <?php endif; ?>
</body>
</html>