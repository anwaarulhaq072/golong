<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Withdrawal Request</title>
  <?php echo view("/home/new-header-links"); ?>
</head>

<body>
  <div class="app_wrapper">
  <?php echo view("/home/left-sidebar-new"); ?>
    <main class="main">
      <div class="flex-i wdthtopBox-wrpr">
        <div class="notiHeadingBox notiHeadingBox--wdthtop">
          <h2 class="notification-card__hdng mb-0">Withdrawal Request</h2>
        </div>
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
            <tr class="withdrawalTable__row profit-row pending">
              <td class="withdrawalTable__col">
                <div class="flex-i wthtblBtn-wrpr">
                  <button class="wthtblBtn flex-a" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <span>Aug 19, 2024</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i userimg-wrpr">
                  <img src="assets/images/profile.png" alt="" class="userimg__wtdtbl">
                  <span>Ahsan</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="withdrawalTable__tab pending flex-a">Pending</div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i table-btns-wrpr table-btns-wrpr--justify-start">
                  <button class="table-btn flex-a table-btn--accept">Accept</button>
                  <button class="table-btn flex-a table-btn--reject">Reject</button>
                </div>
              </td>
            </tr>
            <tr class="withdrawalTable__row profit-row accepted">
              <td class="withdrawalTable__col">
                <div class="flex-i wthtblBtn-wrpr">
                  <button class="wthtblBtn flex-a" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <span>Aug 19, 2024</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i userimg-wrpr">
                  <img src="assets/images/profile.png" alt="" class="userimg__wtdtbl">
                  <span>Ahsan</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="withdrawalTable__tab accepted flex-a">Accepted</div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i table-btns-wrpr table-btns-wrpr--justify-start">
                  <p class="yellow">User withdrawal request Accepted</p>
                </div>
              </td>
            </tr>
            <tr class="withdrawalTable__row profit-row completed">
              <td class="withdrawalTable__col">
                <div class="flex-i wthtblBtn-wrpr">
                  <button class="wthtblBtn flex-a" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <span>Aug 19, 2024</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i userimg-wrpr">
                  <img src="assets/images/profile.png" alt="" class="userimg__wtdtbl">
                  <span>Ahsan</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="withdrawalTable__tab completed flex-a">Completed</div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i table-btns-wrpr table-btns-wrpr--justify-start">
                  <p class="topaz">User withdrawal request Completed</p>
                </div>
              </td>
            </tr>
            <tr class="withdrawalTable__row profit-row rejected">
              <td class="withdrawalTable__col">
                <div class="flex-i wthtblBtn-wrpr">
                  <button class="wthtblBtn flex-a" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <span>Aug 19, 2024</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i userimg-wrpr">
                  <img src="assets/images/profile.png" alt="" class="userimg__wtdtbl">
                  <span>Ahsan</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="withdrawalTable__tab rejected flex-a">Rejected</div>
              </td>
              <td class="withdrawalTable__col">
                <p class="chili-paper">User withdrawal request rejected</p>
              </td>
            </tr>
            <tr class="withdrawalTable__row profit-row pending">
              <td class="withdrawalTable__col">
                <div class="flex-i wthtblBtn-wrpr">
                  <button class="wthtblBtn flex-a" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <span>Aug 19, 2024</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i userimg-wrpr">
                  <img src="assets/images/profile.png" alt="" class="userimg__wtdtbl">
                  <span>Ahsan</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="withdrawalTable__tab pending flex-a">Pending</div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i table-btns-wrpr table-btns-wrpr--justify-start">
                  <button class="table-btn flex-a table-btn--accept">Accept</button>
                  <button class="table-btn flex-a table-btn--reject">Reject</button>
                </div>
              </td>
            </tr>
            <tr class="withdrawalTable__row profit-row pending">
              <td class="withdrawalTable__col">
                <div class="flex-i wthtblBtn-wrpr">
                  <button class="wthtblBtn flex-a" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <span>Aug 19, 2024</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i userimg-wrpr">
                  <img src="assets/images/profile.png" alt="" class="userimg__wtdtbl">
                  <span>Ahsan</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="withdrawalTable__tab pending flex-a">Pending</div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i table-btns-wrpr table-btns-wrpr--justify-start">
                  <button class="table-btn flex-a table-btn--accept">Accept</button>
                  <button class="table-btn flex-a table-btn--reject">Reject</button>
                </div>
              </td>
            </tr>
            <tr class="withdrawalTable__row profit-row accepted">
              <td class="withdrawalTable__col">
                <div class="flex-i wthtblBtn-wrpr">
                  <button class="wthtblBtn flex-a" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <span>Aug 19, 2024</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i userimg-wrpr">
                  <img src="assets/images/profile.png" alt="" class="userimg__wtdtbl">
                  <span>Ahsan</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="withdrawalTable__tab accepted flex-a">Accepted</div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i table-btns-wrpr table-btns-wrpr--justify-start">
                  <p class="yellow">User withdrawal request Accepted</p>
                </div>
              </td>
            </tr>
            <tr class="withdrawalTable__row profit-row completed">
              <td class="withdrawalTable__col">
                <div class="flex-i wthtblBtn-wrpr">
                  <button class="wthtblBtn flex-a" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <span>Aug 19, 2024</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i userimg-wrpr">
                  <img src="assets/images/profile.png" alt="" class="userimg__wtdtbl">
                  <span>Ahsan</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="withdrawalTable__tab completed flex-a">Completed</div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i table-btns-wrpr table-btns-wrpr--justify-start">
                  <p class="topaz">User withdrawal request Completed</p>
                </div>
              </td>
            </tr>
            <tr class="withdrawalTable__row profit-row rejected">
              <td class="withdrawalTable__col">
                <div class="flex-i wthtblBtn-wrpr">
                  <button class="wthtblBtn flex-a" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <span>Aug 19, 2024</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i userimg-wrpr">
                  <img src="assets/images/profile.png" alt="" class="userimg__wtdtbl">
                  <span>Ahsan</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="withdrawalTable__tab rejected flex-a">Rejected</div>
              </td>
              <td class="withdrawalTable__col">
                <p class="chili-paper">User withdrawal request rejected</p>
              </td>
            </tr>
            <tr class="withdrawalTable__row profit-row pending">
              <td class="withdrawalTable__col">
                <div class="flex-i wthtblBtn-wrpr">
                  <button class="wthtblBtn flex-a" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <span>Aug 19, 2024</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i userimg-wrpr">
                  <img src="assets/images/profile.png" alt="" class="userimg__wtdtbl">
                  <span>Ahsan</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="withdrawalTable__tab pending flex-a">Pending</div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i table-btns-wrpr table-btns-wrpr--justify-start">
                  <button class="table-btn flex-a table-btn--accept">Accept</button>
                  <button class="table-btn flex-a table-btn--reject">Reject</button>
                </div>
              </td>
            </tr>
            <tr class="withdrawalTable__row profit-row pending">
              <td class="withdrawalTable__col">
                <div class="flex-i wthtblBtn-wrpr">
                  <button class="wthtblBtn flex-a" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <span>Aug 19, 2024</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i userimg-wrpr">
                  <img src="assets/images/profile.png" alt="" class="userimg__wtdtbl">
                  <span>Ahsan</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="withdrawalTable__tab pending flex-a">Pending</div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i table-btns-wrpr table-btns-wrpr--justify-start">
                  <button class="table-btn flex-a table-btn--accept">Accept</button>
                  <button class="table-btn flex-a table-btn--reject">Reject</button>
                </div>
              </td>
            </tr>
            <tr class="withdrawalTable__row profit-row accepted">
              <td class="withdrawalTable__col">
                <div class="flex-i wthtblBtn-wrpr">
                  <button class="wthtblBtn flex-a" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <span>Aug 19, 2024</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i userimg-wrpr">
                  <img src="assets/images/profile.png" alt="" class="userimg__wtdtbl">
                  <span>Ahsan</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="withdrawalTable__tab accepted flex-a">Accepted</div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i table-btns-wrpr table-btns-wrpr--justify-start">
                  <p class="yellow">User withdrawal request Accepted</p>
                </div>
              </td>
            </tr>
            <tr class="withdrawalTable__row profit-row completed">
              <td class="withdrawalTable__col">
                <div class="flex-i wthtblBtn-wrpr">
                  <button class="wthtblBtn flex-a" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <span>Aug 19, 2024</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i userimg-wrpr">
                  <img src="assets/images/profile.png" alt="" class="userimg__wtdtbl">
                  <span>Ahsan</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="withdrawalTable__tab completed flex-a">Completed</div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i table-btns-wrpr table-btns-wrpr--justify-start">
                  <p class="topaz">User withdrawal request Completed</p>
                </div>
              </td>
            </tr>
            <tr class="withdrawalTable__row profit-row rejected">
              <td class="withdrawalTable__col">
                <div class="flex-i wthtblBtn-wrpr">
                  <button class="wthtblBtn flex-a" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <span>Aug 19, 2024</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i userimg-wrpr">
                  <img src="assets/images/profile.png" alt="" class="userimg__wtdtbl">
                  <span>Ahsan</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="withdrawalTable__tab rejected flex-a">Rejected</div>
              </td>
              <td class="withdrawalTable__col">
                <p class="chili-paper">User withdrawal request rejected</p>
              </td>
            </tr>
            <tr class="withdrawalTable__row profit-row pending">
              <td class="withdrawalTable__col">
                <div class="flex-i wthtblBtn-wrpr">
                  <button class="wthtblBtn flex-a" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <span>Aug 19, 2024</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i userimg-wrpr">
                  <img src="assets/images/profile.png" alt="" class="userimg__wtdtbl">
                  <span>Ahsan</span>
                </div>
              </td>
              <td class="withdrawalTable__col">
                <div class="withdrawalTable__tab pending flex-a">Pending</div>
              </td>
              <td class="withdrawalTable__col">
                <div class="flex-i table-btns-wrpr table-btns-wrpr--justify-start">
                  <button class="table-btn flex-a table-btn--accept">Accept</button>
                  <button class="table-btn flex-a table-btn--reject">Reject</button>
                </div>
              </td>
            </tr>
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
          <span class="details__row-sp2">USD</span>
        </div>
        <div class="details__row">
          <span class="details__row-sp1">Method Details:</span>
          <span class="details__row-sp2">ACH Request</span>
        </div>
        <div class="details__row">
          <span class="details__row-sp1">Amount:</span>
          <span class="details__row-sp2">0 $</span>
        </div>
        <div class="details__row">
          <span class="details__row-sp1">Paid Date:</span>
          <span class="details__row-sp2">21 August , 2024</span>
        </div>
        <div class="details__row">
          <span class="details__row-sp1">Account Details:</span>
          <div>
            <div class="details__row">
              <span class="details__row-sp1">Account Name:</span>
              <span class="details__row-sp2">Irfan</span>
            </div>
            <div class="details__row">
              <span class="details__row-sp1">Account Number:</span>
              <span class="details__row-sp2">12330102449</span>
            </div>
            <div class="details__row">
              <span class="details__row-sp1">Rounting Number:</span>
              <span class="details__row-sp2">2098546n</span>
            </div>
          </div>
        </div>
        <div class="details__row">
          <span class="details__row-sp1">Message:</span>
          <span class="details__row-sp2">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Esse, officia.</span>
        </div>
        <div class="details__row">
          <span class="details__row-sp1">Reject Reason (if rejected):</span>
          <span class="details__row-sp2">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Esse, officia.</span>
        </div>
      </div>
    </div>
  </div>
  <?php echo view("/home/new-footer-scripts"); ?>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      function filterTableRows(filterSelector) {
        const filterElements = document.getElementsByClassName(filterSelector);
        if (!filterElements.length) {
          console.error(`Elements with class "${filterSelector}" not found.`);
          return;
        }
        Array.from(filterElements).forEach((filterElement) => {
          filterElement.addEventListener("change", function () {
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