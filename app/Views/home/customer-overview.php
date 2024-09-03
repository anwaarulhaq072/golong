<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Archive History</title>
  <?php echo view("/home/new-header-links"); ?>
</head>

<body>
  <div class="app_wrapper">
    <?php echo view("/home/left-sidebar-new"); ?>
    <main class="main">
      <h2 class="cus-details-card__hadng cus-details-card__hadng--arhh">Update Total Investment</h2>
      <p class="arcHisCard-sub-h">Details of archive history of 2024</p>
      <div class="row row-gap archiveHistoryCard-row">
        <div class="col-md-6 col-xl-3">
          <div class="card archiveHistoryCard">
            <h6 class="archiveHistoryCard__sub-hdng">Total Payout</h6>
            <h2 class="archiveHistoryCard__hdng">$<?php echo $payoutAll ?></h2>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card archiveHistoryCard">
            <h6 class="archiveHistoryCard__sub-hdng">Total Profit</h6>
            <h2 class="archiveHistoryCard__hdng">$<?php if ($profitLoss > 0) : echo $profitLoss;
                                                  else : echo 0;
                                                  endif; ?></h2>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card archiveHistoryCard">
            <h6 class="archiveHistoryCard__sub-hdng">Total Positions</h6>
            <h2 class="archiveHistoryCard__hdng">$<?php echo sizeof($profitLossDetails); ?></h2>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card archiveHistoryCard">
            <h6 class="archiveHistoryCard__sub-hdng">Percentage Profit</h6>
            <h2 class="archiveHistoryCard__hdng"><?php if ($profitLoss > 0) : echo round(($profitLoss / $initial) * 100, 2);
                                                  else: echo 0;
                                                  endif; ?>%</h2>
          </div>
        </div>
      </div>
      <h2 class="cus-details-card__hadng cus-details-card__hadng--arhh">Transactions</h2>
      <p class="arcHisCard-sub-h">Details of transactions</p>
      <div class="row row-gap">
        <div class="col-lg-6 col-xl-4">
          <div class="card transaction-card">
            <div class="flex-i justify-between transaction-card-wrapper">
              <div class="transaction-card__content">
                <h6 class="trnHdng">Total positions</h6>
                <p class="transaction-card__desc">Total positions from start to till now</p>
              </div>
              <div class="transaction-card__chart-holder">
                <canvas class="progressChart" id="progressChart1"></canvas>
                <div class="chart-value" id="chartValue1"><?php echo sizeof($profitLossDetails); ?></div>
              </div>
            </div>
          </div>
        </div>
        <?php
        $profitable = 0;
        if ($totalProfitNum) {
          $profitable = number_format((float)(($totalProfitNum / (float)sizeof($profitLossDetails)) * 100), 1, '.', '');
        }
        ?>
        <div class="col-lg-6 col-xl-4">
          <div class="card transaction-card">
            <div class="flex-i justify-between transaction-card-wrapper">
              <div class="transaction-card__content">
                <h6 class="trnHdng">Total win rate</h6>
                <p class="transaction-card__desc">Total win rate from start to till now</p>
              </div>
              <div class="transaction-card__chart-holder">
                <canvas class="progressChart" id="progressChart2"></canvas>
                <div class="chart-value" id="chartValue2"><?php echo $profitable; ?>%</div>
              </div>
            </div>
          </div>
        </div>
        <?php
        $losing = 0;
        if ($totalLossNum) {
          $losing = number_format((float)(($totalLossNum / (float)sizeof($profitLossDetails)) * 100), 1, '.', '');
        }
        ?>
        <div class="col-lg-6 col-xl-4">
          <div class="card transaction-card">
            <div class="flex-i justify-between transaction-card-wrapper">
              <div class="transaction-card__content">
                <h6 class="trnHdng">Total loss rate</h6>
                <p class="transaction-card__desc">Total loss rate from start to till now</p>
              </div>
              <div class="transaction-card__chart-holder">
                <canvas class="progressChart" id="progressChart3"></canvas>
                <div class="chart-value" id="chartValue3"><?php echo $losing; ?>%</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  <?php echo view("/home/new-footer-scripts"); ?>
  <script>
    const ctx1 = document.getElementById("progressChart1").getContext("2d");
    var value1 = <?php echo json_encode(sizeof($profitLossDetails)); ?>;
    var value2 = <?php echo json_encode($profitable); ?>;
    var value3 = <?php echo json_encode($losing); ?>;
    const progressChart1 = new Chart(ctx1, {
      type: "doughnut",
      data: {
        datasets: [{
          data: [value1, 100 - value1],
          backgroundColor: ["#0073B6", "#59595933"],
          borderWidth: 0, // Remove the white border
          borderRadius: 10, // Round the corners
        }, ],
      },
      options: {
        cutout: "90%",
        rotation: 140,
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          tooltip: {
            enabled: false,
          },
        },
      },
    });
    document.getElementById("chartValue1").textContent = value1 + "%";
    const ctx2 = document.getElementById("progressChart2").getContext("2d");
    const progressChart2 = new Chart(ctx2, {
      type: "doughnut",
      data: {
        datasets: [{
          data: [value2, 100 - value2],
          backgroundColor: ["#1ABC9C", "#59595933"],
          borderWidth: 0, // Remove the white border
          borderRadius: 10, // Round the corners
        }, ],
      },
      options: {
        cutout: "90%",
        rotation: 140,
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          tooltip: {
            enabled: false,
          },
        },
      },
    });
    document.getElementById("chartValue2").textContent = value2 + "%";
    const ctx3 = document.getElementById("progressChart3").getContext("2d");
    const progressChart3 = new Chart(ctx3, {
      type: "doughnut",
      data: {
        datasets: [{
          data: [value3, 100 - value3],
          backgroundColor: ["#BC1D1E", "#59595933"],
          borderWidth: 0, // Remove the white border
          borderRadius: 10, // Round the corners
        }, ],
      },
      options: {
        cutout: "90%",
        rotation: 220,
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          tooltip: {
            enabled: false,
          },
        },
      },
    });
    document.getElementById("chartValue3").textContent = value3 + "%";
  </script>
</body>

</html>