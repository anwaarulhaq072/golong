<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Deposit Request</title>
  <?php echo view("/home/new-header-links"); ?>
</head>

<body>
  <div class="app_wrapper">
    <?php echo view("/home/left-sidebar-new"); ?>
    <main class="main">
      <div class="flex-i wdthtopBox-wrpr">
        <div class="notiHeadingBox notiHeadingBox--wdthtop">
          <h2 class="notification-card__hdng mb-0">Deposit Request</h2>
        </div>
      </div>
      <div class="card cus-details-card ">
        <div class="flex trnsc-tbl-top-row">
          <p class="trnsList-text">
            Following are the records of your deposit history
          </p>
          <select class="tn-list-card__select filterselect" id="transactionfilterSelect">
            <option value="all" selected>Show All</option>
            <option value="pending">Pending</option>
            <option value="accepted">Accepted</option>
            <option value="completed">Completed</option>
            <option value="rejected">Rejected</option>
          </select>
        </div>
        <table class="table withdrawalTable admin-withdrawalTable" id="withdrawalTable">
          <thead>
            <tr class="withdrawalTable__row profit-row">
              <th class="withdrawalTable__col">
                Requested Date
              </th>
              <th class="withdrawalTable__col">User Name</th>
              <th class="withdrawalTable__col">Status</th>
              <th class="withdrawalTable__col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (isset($allDeposits)) : ?>
              <?php foreach ($allDeposits as $singleDeposit) : ?>
                <tr class="withdrawalTable__row profit-row <?php if ($singleDeposit['status'] == 'Pending') echo 'pending';
                                                            else if ($singleDeposit['status'] == 'Accepted') echo 'accepted';
                                                            else if ($singleDeposit['status'] == 'Completed') echo 'completed';
                                                            else if ($singleDeposit['status'] == 'Rejected') echo 'rejected'; ?>">
                  <td class="withdrawalTable__col">
                    <div class="flex-i wthtblBtn-wrpr">
                      <button class="wthtblBtn flex-a detail-modal" single_deposit='<?= json_encode($singleDeposit) ?>' type="button" data-bs-toggle="modal1" data-bs-target="#modal1">
                        <i class="fa-solid fa-eye"></i>
                      </button>
                      <span><?php echo date('M d, Y', strtotime($singleDeposit['deposite_date'])); ?></span>
                    </div>
                  </td>
                  <td class="withdrawalTable__col">
                    <div class="flex-i userimg-wrpr">
                      <img src="<?= $singleDeposit['profile_img'] ? base_url() . $singleDeposit['profile_img'] : base_url() . '/assets/images/users/user-1.jpg' ?>" alt="" class="userimg__wtdtbl">
                      <span><?= $singleDeposit['firstName'] . ' ' . $singleDeposit['lastName']; ?></span>
                    </div>
                  </td>
                  <td class="withdrawalTable__col">
                    <?php if ($singleDeposit['status'] == 'Pending') : ?>
                      <div class="withdrawalTable__tab pending btn"><?= $singleDeposit['status']; ?></div>
                    <?php elseif ($singleDeposit['status'] == 'Accepted') : ?>
                      <div class="withdrawalTable__tab accepted btn"><?= $singleDeposit['status']; ?></div>
                    <?php elseif ($singleDeposit['status'] == 'Completed') : ?>
                      <div class="withdrawalTable__tab completed btn"><?= $singleDeposit['status']; ?></div>
                    <?php elseif ($singleDeposit['status'] == 'Rejected') : ?>
                      <div class="withdrawalTable__tab rejected btn"><?= $singleDeposit['status']; ?></div>
                    <?php endif; ?>
                  </td>
                  <td class="withdrawalTable__col">
                    <?php if ($singleDeposit['status'] == 'Pending') : ?>
                      <div class="flex-i table-btns-wrpr table-btns-wrpr--justify-start">
                        <a href="<?= base_url(); ?>/admin/accept_deposit_requests/<?= $singleDeposit['id']; ?>" class="table-btn flex-a table-btn--accept withdrawalTable__tab">Accept</a href="<?= base_url(); ?>/admin/accept_withdrawal_requests/<?= $singleDeposit['id']; ?>">
                        <button class="table-btn flex-a table-btn--reject table-btn-reject withdrawalTable__tab " deposit_id="<?= $singleDeposit['id']; ?>">Reject</button>
                      </div>
                    <?php elseif ($singleDeposit['status'] == 'Accepted') : ?>
                      <div class="flex-i table-btns-wrpr table-btns-wrpr--justify-start">
                        <a href="<?= base_url(); ?>/admin/complete_deposit_requests/<?= $singleDeposit['id']; ?>"><button class="table-btn flex-a table-btn--accept withdrawalTable__tab "> Complete </button></a>
                      </div>
                    <?php elseif ($singleDeposit['status'] == 'Completed') : ?>
                      <div class="flex-i table-btns-wrpr table-btns-wrpr--justify-start">
                        <p class="topaz">Amount added in user’s account successfully</p>
                      </div>
                    <?php elseif ($singleDeposit['status'] == 'Rejected') : ?>
                      <p class="chili-paper">User’s deposit request rejected</p>
                    <?php endif; ?>

                  </td>
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
  <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="profilee-dit-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content profile-edit">
        <button class="profile-edit__btnclose flex-a" data-bs-dismiss="modal">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="details__row">
          <span class="details__row-sp1">Method:</span>
          <span class="details__row-sp2" id="method"></span>
        </div>
        <div class="details__row">
          <span class="details__row-sp1">Method Details:</span>
          <span class="details__row-sp2" id="methodDatils"></span>
        </div>
        <div class="details__row">
          <span class="details__row-sp1">Amount:</span>
          <span class="details__row-sp2" id="amount"></span>
        </div>
        <div class="details__row">
          <span class="details__row-sp1">Paid Date:</span>
          <span class="details__row-sp2" id="paidDate"></span>
        </div>
        <div class="details__row">
          <span class="details__row-sp1">Message:</span>
          <span class="details__row-sp2" id="message"></span>
        </div>
        <div class="details__row">
          <span class="details__row-sp1">Reject Reason (if rejected):</span>
          <span class="details__row-sp2" id="rejectReason"></span>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="reject-modal" tabindex="-1" aria-labelledby="profilee-dit-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content profile-edit">
        <button class="profile-edit__btnclose flex-a" data-bs-dismiss="modal">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <form action="<?php echo base_url(); ?>/admin/reject_deposit_requests" id="rejectReasonModal" method="POST">
          <div class="modal-body">
            <input type="hidden" name="deposit_id" id="deposit_id" value="">
            <p>The reason will be shared to the customer</p>

            <label for="reason" class="form-label">Reason:</label></br>
            <textarea class="form-label" id="reason" name="reason" rows="6" style="min-width: 100%" required></textarea>
          </div>
          <div class="modal-body mt-2">
            <a href="#" class="btn btn-primary" data-bs-dismiss="modal" style="padding: 7px 60px; border: 1px solid #000000; background-color: #000000; float:right">Cancel</a>
            <button id="reject_btn" type="submit" class="btn btn-danger" style="padding: 7px 60px;">Reject</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php echo view("/home/new-footer-scripts"); ?>
  <script>
    $(document).ready(function() {
      $(document).on("click", ".detail-modal", function() {
        let single_deposit = JSON.parse($(this).attr("single_deposit"));
        $("#method").text(single_deposit['currency']);
        $("#methodDatils").text(single_deposit['currency_option']);
        $("#amount").text(single_deposit['amount']);
        $("#paidDate").text(single_deposit['accepted_date']);
        $("#message").text(single_deposit['message']);
        $("#rejectReason").text(single_deposit['reject_reason']);
        console.log(single_deposit);

        $("#modal").modal("show");
      })
      $(document).on("click", ".table-btn-reject", function() {
        let deposit_id = $(this).attr("deposit_id");
        console.log(deposit_id);
        $('#deposit_id').val(deposit_id);
        $("#reject-modal").modal("show");
      })
    })
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