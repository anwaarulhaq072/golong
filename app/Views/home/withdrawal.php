<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Withdrawal History</title>
  <?php echo view("/home/new-header-links"); ?>
</head>

<body>
  <div class="app_wrapper">
    <?php echo view("/home/left-sidebar-new"); ?>
    <main class="main">
      <div class="flex-i wdthtopBox-wrpr">
        <div class="notiHeadingBox notiHeadingBox--wdthtop">
          <h2 class="notification-card__hdng">Withdrawal History</h2>
          <p class="notification-card__para">Withdrawal history of 2024</p>
        </div>
        <a href="<?= base_url(); ?>/user/add_withdrawal" class="flex-a wthdrwlBtn">New Withdrawal Request</a>
      </div>
          <div class="card cus-details-card ">
            <div class="flex trnsc-tbl-top-row">
              <p class="trnsList-text">
                Following are the records of your withdrawal history
              </p>
              <select class="tn-list-card__select filterselect" id="transactionfilterSelect">
                <option value="all" selected>Show All</option>
                <option value="pending">Pending</option>
                <option value="accepted">Accepted</option>
                <option value="completed">Completed</option>
                <option value="rejected">Rejected</option>
              </select>
            </div>

            <table class="table withdrawalTable" id="withdrawalTable">
              <thead>
                <tr class="withdrawalTable__row profit-row">
                  <th class="withdrawalTable__col">Requested Date</th>
                  <th class="withdrawalTable__col">Status</th>
                  <th class="withdrawalTable__col">Method</th>
                  <th class="withdrawalTable__col">Method Details</th>
                  <th class="withdrawalTable__col">Amount</th>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($allWithdrawals)) : ?>
                  <?php foreach ($allWithdrawals as $singleWithdrawal) : ?>
                    <tr class="withdrawalTable__row profit-row <?php if ($singleWithdrawal['status'] == 'Pending')  echo 'pending'; elseif($singleWithdrawal['status'] == 'Accepted') echo 'accepted'; elseif($singleWithdrawal['status'] == 'Completed') echo 'completed'; elseif($singleWithdrawal['status'] == 'Rejected') echo 'rejected';  ?>">
                      <td class="withdrawalTable__col"><?php echo date('M d, Y', strtotime($singleWithdrawal['request_date'])); ?></td>
                      <td class="withdrawalTable__col">
                        <?php if ($singleWithdrawal['status'] == 'Pending') : ?>
                          <div class="withdrawalTable__tab pending flex-a"><?= $singleWithdrawal['status']; ?></div>
                        <?php elseif ($singleWithdrawal['status'] == 'Accepted') : ?>
                          <div class="withdrawalTable__tab accepted flex-a"><?= $singleWithdrawal['status']; ?></div>
                        <?php elseif ($singleWithdrawal['status'] == 'Completed') : ?>
                          <div class="withdrawalTable__tab completed flex-a"><?= $singleWithdrawal['status']; ?></div>
                        <?php elseif ($singleWithdrawal['status'] == 'Rejected') : ?>
                          <div class="withdrawalTable__tab rejected flex-a"><?= $singleWithdrawal['status']; ?></div>
                        <?php endif; ?>
                      </td>
                      <td class="withdrawalTable__col"><?= $singleWithdrawal['currency'] ?></td>
                      <td class="withdrawalTable__col"><?= $singleWithdrawal['currency_option'] ?></td>
                      <td class="withdrawalTable__col">$<?= $singleWithdrawal['amount'] ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else : ?>
                  <h3 style="text-align: center;">No Record Found</h3>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
    </main>
  </div>
  <?php echo view("/home/new-footer-scripts"); ?>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      function filterTableRows(filterSelector) {
        const filterElements = document.getElementsByClassName(filterSelector);
        if (!filterElements.length) {
          console.error(`Elements with class "${filterSelector}" not found.`);
          return;
        }
        Array.from(filterElements).forEach((filterElement) => {
          filterElement.addEventListener("change", function() {
            const filterValue = this.value;
            const rows = document.querySelectorAll(`.withdrawalTable .withdrawalTable__row`);

            rows.forEach((row) => {
              const isPending = row.classList.contains("pending");
              const isAccepted = row.classList.contains("accepted");
              const isCompleted = row.classList.contains("completed");
              const isRejected = row.classList.contains("rejected");

              if (filterValue === "pending") {
                row.style.display = isPending ? "table-row" : "none";
              } else if (filterValue === "accepted") {
                row.style.display = isAccepted ? "table-row" : "none";
              } else if (filterValue === "completed") {
                row.style.display = isCompleted ? "table-row" : "none";
              } else if (filterValue === "rejected") {
                row.style.display = isRejected ? "table-row" : "none";
              } else {
                row.style.display = "table-row";
              }
            });
          });
        });
      }
      filterTableRows("filterselect");
    });
  </script>
</body>

</html>