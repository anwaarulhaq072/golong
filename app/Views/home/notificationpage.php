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
          <h2 class="notification-card__hdng">All Notifications</h2>
        </div>
        <a href="<?php echo base_url(); ?>/admin/addnotification" class="flex-a wthdrwlBtn">Add New Notification</a>
      </div>
      <div class="card cus-details-card ">
        <div class="flex trnsc-tbl-top-row">
        </div>

        <table class="table withdrawalTable" id="withdrawalTable">
          <thead>
            <tr class="withdrawalTable__row profit-row">
              <th class="withdrawalTable__col">Title</th>
              <th class="withdrawalTable__col">Status</th>
              <th class="withdrawalTable__col">Date</th>
              <th class="withdrawalTable__col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($allNotifications as $singleNotification) :  ?>
              <?php if (strpos($singleNotification['title'], "Request") == ''): ?>
                <tr class="withdrawalTable__row profit-row">
                  <td class="withdrawalTable__col "><?php echo $singleNotification['title'] ?></td>
                  <td class="withdrawalTable__col withdrawalTable___col"><?php echo $singleNotification['status'] ?></td>
                  <td class="withdrawalTable__col withdrawalTable___col"><?php echo  date('M d, Y', strtotime($singleNotification['publishDate'])); ?></td>
                  <td class="withdrawalTable__col">
                    <div class="flex-i " style="column-gap: 22px;">
                      <a href="<?php echo base_url(); ?>/admin/updatenotification?id=<?php echo $singleNotification['id']; ?>" class="table-mdl-btn flex-a r-50 edit_notification_button">
                        <i class="fa-solid fa-pencil"></i>
                      </a>
                      <button  value="<?php echo base_url(); ?>/admin/deleteNotification?id=<?php echo $singleNotification['id']; ?>" class="table-mdl-btn flex-a r-50 delete_btn_notification" type="button" data-bs-toggle="modal"
                      data-bs-target="#delete_notification">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              <?php endif; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </main>
    <div class="modal fade" id="delete_notification" tabindex="-1" aria-labelledby="edit-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content profile-edit profile-edit2">
        <button class="profile-edit__btnclose flex-a" data-bs-dismiss="modal">
          <i class="fa-solid fa-xmark"></i>
        </button>

        <h2 class="profile-edit__hdng profile-edit__hdng2--danger text-center">
          <i class="fa-solid fa-trash d-block"></i>
        </h2>
        <p class="delete-text">Are you sure you want to delete record?</p>
        <div class="flex-a profile-edit-btns-wrpr">
        <a href="" id="delYesNotification"><button type="submit" class="profile-edit__btn profile-edit__btn--del">Delete</button></a>
          <button type="button" class="profile-edit__btn profile-edit__btn--tr profile-edit__btn--tr-red"
            data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  </div>

  <?php echo view("/home/new-footer-scripts"); ?>
  <script src="<?= base_url(); ?>/assets/js/modalWorking.js"></script>
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