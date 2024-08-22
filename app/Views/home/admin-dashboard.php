<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin's Home</title>
  <?php echo view("/home/new-header-links"); ?>
</head>

<body>
  <div class="app_wrapper">
    <?php echo view("/home/left-sidebar-new"); ?>
    <main class="main">
      <div class="row row-gap">
        <div class="col-12">
          <div class="card all-cutomers-card">
            <div class="flex-i justify-between all-cutomers__table-header">
              <div>
                <h2 class="all-cutomers__table-hdng">All Customers</h2>
                <p class="all-cutomers__table-para">Detail of all customers</p>
              </div>
              <!-- <div class="inputBox inputBox--all-customers flex-i">
                <input type="text" class="inputBox__feild" placeholder="Search...">
                <img src="assets/images/icons/search.svg" alt="">
              </div> -->
            </div>
            <table class="table all-cutomers__table" id="all-cutomers">
              <thead>
                <tr class="all-cutomers-t__row">
                  <th class="all-cutomers-t__col all-cutomers-t__col1 all-cutomers-t__col--head">Name</th>
                  <th class="all-cutomers-t__col all-cutomers-t__col2 all-cutomers-t__col--head">Email</th>
                  <th class="all-cutomers-t__col all-cutomers-t__col3 all-cutomers-t__col--head">Phone No.</th>
                  <th class="all-cutomers-t__col all-cutomers-t__col4 all-cutomers-t__col--head">Investment Amount</th>
                  <th class="all-cutomers-t__col all-cutomers-t__col5 all-cutomers-t__col--head"></th>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($allUsers)) : ?>
                  <?php $i = 0;
                  foreach ($allUsers as $singleUser) : ?>
                    <tr class="all-cutomers-t__row">
                      <td><?php echo $singleUser['firstName'] . " " . $singleUser['lastName']; ?></td>
                      <td>
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <img src="<?= $singleUser['profile_img'] ? base_url() . $singleUser['profile_img'] : base_url() . '/assets/images/users/user-1.jpg' ?>" alt="profile-image" class="rounded-circle" width="40" height="40">
                          </div>
                          <div class="col">
                            <p><?= $singleUser['email']; ?></p>
                          </div>
                        </div>
                      </td>
                      <td class="all-cutomers-t__col"><?php echo $singleUser['phone']; ?></td>
                      <td class="all-cutomers-t__col"><?php echo $singleUser['initialInvestment']; ?></td>
                      <td class="all-cutomers-t__col">
                        <div class="flex-i table-btns-wrpr">
                          <a href="<?php echo base_url() ?>/admin/customerdetails?userid=<?php echo $singleUser['id'] ?>" class="table-btn flex-a">Details</a>
                          <a href="<?php echo base_url() ?>/admin/userDashboardNew?userid=<?php echo $singleUser['id'] ?>" class="table-btn flex-a">Dashboard</a>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else : ?>
                  <h3 style="text-align: center;">No users found</h3>
                <?php endif; ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
  <?php echo view("/home/new-footer-scripts"); ?>
</body>

</html>