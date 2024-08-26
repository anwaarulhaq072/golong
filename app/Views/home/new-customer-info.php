<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Customers Details - <?php echo APP_NAME ?></title>
  <?php echo view("/home/new-header-links"); ?>
  
</head>

<body>
  <div class="app_wrapper">
    <?php echo view("/home/left-sidebar-new"); ?>


    <main class="main">
      <h2 class="cus-details-card__hadng">Update Total Investment</h2>

      <div class="row row-gap">
        <div class="col-xl-9">
          <div class="card cus-details-card">
            <form class="row row-gap2" action="<?php echo base_url(); ?>/admin/addInvestment" method="POST">
              <div class="col-sm-6">
                <input type="hidden" name="id" value="<?php echo $userDetails['id']; ?>">
                <p class="label-text">Change Amount</p>
                <input type="number" class="form-control cus-details-input" step="0.01" name="amount" value="<?php echo $userDetails['initialInvestment'] ?>" required>
                <!-- <div class="flex-i radioes-wraper">
                  <label class="radio-label flex-i">
                    <input type="radio" class="radiobtn" name="splitAmount">
                    <div></div>
                    <span class="radio-label__text">Payout Split Amount</span>
                  </label>
                  <label class="radio-label flex-i">
                    <input type="radio" class="radiobtn" name="splitAmount" checked>
                    <div></div>
                    <span class="radio-label__text">Payout Split Amount</span>
                  </label>
                </div> -->
              </div>
              <div class="col-sm-6">
                <?php
                $payoutDateString = $userDetails['payoutDate'];
                $payoutDate = DateTime::createFromFormat('Y-m-d', $payoutDateString);
                $nextpayoutDate = $userDetails['nextpayoutDate'];
                $nextpayoutDate = DateTime::createFromFormat('Y-m-d', $nextpayoutDate);
                ?>
                <p class="label-text">Payout Date</p>
                <input type="date" class="form-control cus-details-input dateInput" name="payoutdate" value="">
                <!-- <div class="flex-i radioes-wraper">
                  <label class="radio-label flex-i">
                    <input type="radio" class="radiobtn" name="returnAmount">
                    <div></div>
                    <span class="radio-label__text">Return Full Investment</span>
                  </label>
                  <label class="radio-label flex-i">
                    <input type="radio" class="radiobtn" name="returnAmount" checked>
                    <div></div>
                    <span class="radio-label__text">No Return</span>
                  </label>
                </div> -->
              </div>
              <div class="col-sm-6">
                <p class="label-text">Payout Split Percentage</p>
                <input type="number" id="payout_per" class="form-control cus-details-input" name="payout_per" value="<?php echo $userDetails['payout_per'] ?>">
                <div class="flex-i radioes-wraper">
                  <label class="radio-label flex-i">
                    <input type="radio" class="radiobtn" name="showtoaccount" <?php echo ($userDetails['flagfor_accountant'] == 'Y') ? 'checked' : '' ?>>
                    <div></div>
                    <span class="radio-label__text">Show to Accountant</span>
                  </label>
                </div>
              </div>
              <div class="col-sm-6">
                <p class="label-text">Next Payout Date</p>
                <input type="date" class="form-control cus-details-input dateInput" name="nextpayoutdate" value="">
              </div>
              <div class="col-12">
                <button class="flex-a w-fit from-btn">Update</button>
              </div>
            </form>
          </div>
          <div class="card cus-details-card">
            <form class="row row-gap2" action="<?php echo base_url(); ?>/admin/addPayouts" method="POST">
              <input type="hidden" name="id" value="<?php echo $userDetails['id']; ?>">
              <div class="col-sm-6">
                <p class="label-text">Payout Amount</p>
                <input type="number" class="form-control cus-details-input" step="0.01" name="amount" value="" required>
              </div>
              <div class="col-sm-6">
                <p class="label-text">Payout Date</p>
                <input type="date" class="form-control cus-details-input dateInput" name="payoutdate" value="" required>
              </div>
              <div class="col-12 mb-4">
                <button class="flex-a w-fit from-btn">Submit</button>
              </div>
            </form>
            <table class="table all-cutomers__table mt-5" id="payout">
              <thead>
                <tr class="all-cutomers-t__row">
                  <th class="all-cutomers-t__col all-cutomers-t__col1 all-cutomers-t__col--head">ID</th>
                  <th class="all-cutomers-t__col all-cutomers-t__col2 all-cutomers-t__col--head">Amount</th>
                  <th class="all-cutomers-t__col all-cutomers-t__col3 all-cutomers-t__col--head">
                    Payout Date
                  </th>
                  <th class="all-cutomers-t__col all-cutomers-t__col5 all-cutomers-t__col--head"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($payoutInfo as $singlepayout) : ?>
                  <tr class="all-cutomers-t__row">
                    <td class="all-cutomers-t__col"><?php echo $singlepayout['id'] ?></td>
                    <td class="all-cutomers-t__col">$<?php echo $singlepayout['amount'] ?></td>
                    <td class="all-cutomers-t__col"><?php echo $singlepayout['payoutdate'] ?></td>
                    <td class="all-cutomers-t__col">
                      <div class="flex-i table-btns-wrpr">
                        <button class="table-mdl-btn flex-a r-50 edit_payout_button" id="editbutton" type="button" data-bs-toggle="modal"
                          data-bs-target="#editPayoutmodal" value="<?php echo $singlepayout['id'] ?>">
                          <i class="fa-solid fa-pencil"></i>
                        </button>
                        <button class="table-mdl-btn flex-a r-50 delete_btn_payout" type="button" data-bs-toggle="modal"
                          data-bs-target="#delete_payout" value="<?php echo $singlepayout['id'] ?>">
                          <i class="fa-solid fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>

                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <h2 class="cus-details-card__hadng">Enter Profit & Loss</h2>
          <div class="card cus-details-card">
            <form class="row row-gap2" id="formProfitLoss" method="POST">
              <input type="hidden" id="id" name="id" value="<?php echo $userDetails['id']; ?>">
              <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
              <div class="col-sm-6 col-lg-4">
                <input type="hidden" name="id" value="<?php echo $userDetails['id']; ?>">
                <p class="label-text">Action</p>
                <select name="action" id="dropDown" class="form-control form-select cus-details-input" required>
                  <option>Profit</option>
                  <option>Loss</option>
                  <option value="0">Swing</option>
                </select>
              </div>
              <div class="col-sm-6 col-lg-4">
                <p class="label-text">Amount</p>
                <input type="number" id="fix_value" step="0.01" class="form-control cus-details-input" name="amount" required>
              </div>
              <div class="col-sm-6 col-lg-4">
                <p class="label-text">Date</p>
                <input type="date" value="<?= date("Y-m-d"); ?>" class="form-control cus-details-input dateInput" id="profit-loss" name="date" required>
              </div>
              <div class="col-12">
                <button class="flex-a w-fit from-btn">Submit</button>
              </div>
            </form>
          </div>

          <h2 class="cus-details-card__hadng">Transaction List</h2>
          <div class="card cus-details-card ">
            <div class="flex trnsc-tbl-top-row">
              <p class="trnsList-text">
                Following are the detail records of your transactions
              </p>
              <select class="tn-list-card__select filterselect" id="transactionfilterSelect">
                <option value="all" selected>Show All</option>
                <option value="profit">Profit</option>
                <option value="loss">Loss</option>
              </select>
            </div>

            <table class="table profitLoss__table profitlossTable" id="transactionTable">
              <thead>
                <tr class="table-head__row">
                  <th class="table__hdng">Profit/loss</th>
                  <th class="table__hdng">Date</th>
                  <th class="table__hdng">Amount</th>
                  <th class="table__hdng"></th>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($profitLossDetails)) : ?>
                  <?php foreach ($profitLossDetails as $singleDetail) : ?>
                    <tr class="table__row <?php if ($singleDetail['type'] == 'Profit') :  echo "profit-row"; ?><?php else : echo "loss-row";
                                                                                                              endif; ?>">
                      <td class="teble__col1" name="type"><?php echo $singleDetail['type']; ?></td>
                      <td class="teble__col2"><?php echo date('M d, Y', strtotime($singleDetail['publishDate'])); ?></td>
                      <td class="teble__col3">
                        <?php if ($singleDetail['type'] == 'Profit') : ?>
                          <i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 23px; color: #1ABC9C;"></i> &nbsp; $<?php echo $singleDetail['amount']; ?>
                        <?php else : ?>
                          <i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 23px; color: #D06162;"></i> &nbsp; $<?php echo $singleDetail['amount']; ?>
                        <?php endif; ?>
                      </td>
                      <td class="teble__col4">
                        <div class="flex-i table-btns-wrpr">
                          <button class="table-mdl-btn flex-a r-50 edit_btn" type="button" data-bs-toggle="modal"
                            data-bs-target="#editTransec" value="<?php echo $singleDetail['id'] ?>">
                            <i class="fa-solid fa-pencil"></i>
                          </button>
                          <button class="table-mdl-btn flex-a r-50 delete_btn_profit" type="button" data-bs-toggle="modal"
                            data-bs-target="#delete_profit" value="<?php echo $singleDetail['id'] ?>">
                            <i class="fa-solid fa-trash"></i>
                          </button>
                        </div>
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
        <div class="col-xl-3">
          <div class="card customerDetailsCard">
            <button class="table-mdl-btn table-mdl-btn--2 flex-a r-50" type="button" data-bs-toggle="modal"
              data-bs-target="#profilee-dit-modal2">
              <i class="fa-solid fa-pencil"></i>
            </button>
            <?php if (isset($userDetails) && empty($userDetails['profile_img'])) : ?>
              <img src="<?php echo base_url(); ?>/assets-new/images/profile.png" alt="" class="customerDetailsCard__img">
            <?php else : ?>
              <img src="<?php echo base_url() . $userDetails['profile_img']; ?>" alt="" class="customerDetailsCard__img">
            <?php endif; ?>
            <div class="flex-i customerDetailsCardRow">
              <span class="sp1">Name: </span>
              <span class="sp2"><?php echo $userDetails['firstName'] . " " . $userDetails['lastName']; ?></span>
            </div>
            <div class="flex-i customerDetailsCardRow">
              <span class="sp1">Mobile: </span>
              <span class="sp2"><?php echo $userDetails['phone']; ?></span>
            </div>
            <div class="flex-i customerDetailsCardRow">
              <span class="sp1">Email: </span>
              <span class="sp2"> <?php echo $userDetails['email']; ?></span>
            </div>
            <div class="flex-i customerDetailsCardRow">
              <span class="sp1"> Investment Amount: </span>
              <span class="sp2"> $<?php echo $userDetails['initialInvestment'] ?></span>
            </div>
          </div>
          <button class="deleteUserBtn flex-a delete_btn_user" data-bs-toggle="modal" data-bs-target="#delete_user">Delete
            User</button>
        </div>
      </div>
    </main>
  </div>
  <div class="modal fade" id="editPayoutmodal" tabindex="-1" aria-labelledby="edit-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content profile-edit profile-edit2">
        <button class="profile-edit__btnclose flex-a" data-bs-dismiss="modal">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <h2 class="profile-edit__hdng">Edit Information</h2>
        <form class="row row-gap2" action="<?php echo base_url(); ?>/admin/editPayout?id=" id="editModalpayout" method="POST">
          <div class="col-lg-6">
            <input type="hidden" name="user_id" value="<?php echo $userDetails['id']; ?>">
            <p class="label-text">Payout Amount</p>
            <input type="number" step="0.01" class="form-control cus-details-input" name="amount" required>
          </div>
          <div class="col-lg-6">
            <p class="label-text">Payout Date</p>
            <input type="date" class="form-control cus-details-input dateInput" name="payoutdate" required>
          </div>
          <div class="col-12 mb-4">
            <button type="submit" class="flex-a w-fit from-btn">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="editTransec" tabindex="-1" aria-labelledby="edit-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content profile-edit profile-edit2">
        <button class="profile-edit__btnclose flex-a" data-bs-dismiss="modal">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <h2 class="profile-edit__hdng">Edit Information</h2>
        <form class="row row-gap2" action="" id="editModalForm" method="POST">
          <input type="hidden" name="user_id" id="user_id" value="<?php echo $userDetails['id']; ?>">
          <input type="hidden" name="profit_id" id="profit_id" value="">
          <div class="col-lg-6">
            <p class="label-text">Action</p>
            <select name="action" class="form-control form-select cus-details-input">
              <option value="Profit">Profit</option>
              <option value="Loss">Loss</option>
            </select>
          </div>
          <div class="col-lg-6">
            <p class="label-text">Amount</p>
            <input type="number" name="amount" class="form-control cus-details-input" placeholder="250000" value="">
          </div>
          <div class="col-lg-6">
            <p class="label-text">Date</p>
            <input type="date" name="date" placeholder="MM/DD/YYYY" value=""
              class="form-control cus-details-input dateInput">
          </div>
          <div class="col-12 mb-4">
            <button class="flex-a w-fit from-btn">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="delete_payout" tabindex="-1" aria-labelledby="edit-modalLabel" aria-hidden="true">
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
          <a href="<?php echo base_url(); ?>/admin/deletePayouts?userid=<?php echo $userDetails['id']; ?>&id=" id="delYesPayout"><button type="submit" class="profile-edit__btn profile-edit__btn--del">Delete</button></a>
          <button type="button" class="profile-edit__btn profile-edit__btn--tr profile-edit__btn--tr-red"
            data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="delete_profit" tabindex="-1" aria-labelledby="edit-modalLabel" aria-hidden="true">
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
          <a href="<?php echo base_url(); ?>/admin/deleteProfit?userid=<?php echo $userDetails['id']; ?>&id=" id="delYesProfit"><button type="submit" class="profile-edit__btn profile-edit__btn--del">Delete</button></a>
          <button type="button" class="profile-edit__btn profile-edit__btn--tr profile-edit__btn--tr-red"
            data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="delete_user" tabindex="-1" aria-labelledby="edit-modalLabel" aria-hidden="true">
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
          <a href="<?php echo base_url(); ?>/admin/deleteUser?userid=<?php echo $userDetails['id']; ?>&adminid=<?php echo $_SESSION['user_data']['id']; ?>" id="delYes_user"><button type="submit" class="profile-edit__btn profile-edit__btn--del">Delete</button></a>
          <button type="button" class="profile-edit__btn profile-edit__btn--tr profile-edit__btn--tr-red"
            data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="profilee-dit-modal2" tabindex="-1" aria-labelledby="profilee-dit-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content profile-edit">
        <button class="profile-edit__btnclose flex-a" data-bs-dismiss="modal">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <?php if (isset($userDetails) && empty($userDetails['profile_img'])) : ?>
          <img src="<?php echo base_url(); ?>/assets-new/images/profile.png" alt="" class="customerDetailsCard__img">
        <?php else : ?>
          <img src="<?php echo base_url() . $userDetails['profile_img']; ?>" alt="" class="customerDetailsCard__img">
        <?php endif; ?>
        <p class="profile_edit__para_message" style="color:red"></p>
        <form class="row profile-edit-row" id="editProfileModalform" method="POST">
          <input type="hidden" id="first" value="<?php echo $userDetails['id']; ?>">
          <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
          <div class="col-lg-4">
            <p class="profile-edit__para">Name</p>
            <input type="text" placeholder="Name" id="name" value="<?php echo $userDetails['firstName'] . " " . $userDetails['lastName']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-lg-4">
            <p class="profile-edit__para">Mobile</p>
            <input type="text" placeholder="03156709807" id="phone" value="<?php echo $userDetails['phone']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-lg-4">
            <p class="profile-edit__para">Email</p>
            <input type="text" placeholder="naqashahsanaea@gmail.com" id="email" value="<?php echo $userDetails['email']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-lg-12">
            <p class="profile-edit__para">Investment Amount</p>
            <input type="text" placeholder="$2500" id="initialInvestment" value="<?php echo $userDetails['initialInvestment'] ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-lg-12">
            <div class="flex-a profile-edit-btns-wrpr">
              <button type="submit" class="profile-edit__btn">Update</button>
              <button type="button" class="profile-edit__btn profile-edit__btn--tr"
                data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php echo view("/home/new-footer-scripts"); ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="<?= base_url(); ?>/assets/js/modalWorking.js"></script>
  <script src="<?= base_url(); ?>/assets/js/addProfitLoss.js"></script>
  <script>
    $(document).ready(function() {
      // let icon = {
      //   success: '<span class="material-symbols-outlined">task_alt</span>',
      //   danger: '<span class="material-symbols-outlined">error</span>',
      //   warning: '<span class="material-symbols-outlined">warning</span>',
      //   info: '<span class="material-symbols-outlined">info</span>',
      // };

      // const showToast = (
      //   message = "Sample Message",
      //   toastType = "info",
      //   duration = 5000) => {

      //   if (
      //     !Object.keys(icon).includes(toastType))
      //     toastType = "info";

      //   let box = document.createElement("div");
      //   box.classList.add(
      //     "toast", `toast-${toastType}`);
      //   box.innerHTML = ` <div class="toast-content-wrapper">
      //                 <div class="toast-icon">
      //                 ${icon[toastType]}
      //                 </div>
      //                 <div class="toast-message">${message}</div>
      //                 <div class="toast-progress"></div>
      //                 </div>`;
      //   duration = duration || 5000;

      //   box.querySelector(".toast-progress").style.animationDuration =
      //     `${duration / 1000}s`;

      //   let toastAlready =
      //     document.body.querySelector(".toast");

      //   if (toastAlready) {
      //     toastAlready.remove();
      //   }
      //   console.log(toastAlready);
      //   document.body.appendChild(box)
      //   $('toast').addClass('d-block');
      // };
      // submit.addEventListener("click", (e) => {
      //   e.preventDefault();
      //   showToast("Article Submitted Successfully", "success", 5000);
      // });

      // information.addEventListener("click", (e) => {
      //   e.preventDefault();
      //   showToast("Do POTD and Earn Coins", "info", 5000);
      // });

      // failed.addEventListener("click", (e) => {
      //   e.preventDefault();
      //   showToast("Failed unexpected error", "danger", 5000);
      // });

      // warn.addEventListener("click", (e) => {
      //   e.preventDefault();
      //   showToast("!warning! server error", "warning", 5000);
      // });
    })
    $(document).ready(function() {


      const dataTables = [{
        selector: "#transactionTable",
        options: {
          searching: true,
          pageLength: 10
        },
      }];
      dataTables.forEach(({
        selector,
        options
      }) => {
        $(selector).DataTable({
          ...options,
          info: false,
          ordering: false,
          lengthChange: false,
          pagingType: "simple_numbers",
        });
      });
      $(".dt-input").attr("placeholder", "Search...");
    });
    // new Datepicker(".dateInput");
  </script>
</body>

</html>