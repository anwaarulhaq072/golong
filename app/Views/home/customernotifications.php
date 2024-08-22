<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Notifications - <?php echo APP_NAME ?></title>
  <?php echo view("/home/new-header-links"); ?>
</head>

<body>
  <div class="app_wrapper">
    <?php echo view("/home/left-sidebar-new"); ?>
    <main class="main">
      <div class="row row-gap">
        <div class="col-12">
          <div class="card notification-card">
            <div class="notiHeadingBox">
              <h2 class="notification-card__hdng">All Notifications</h2>
              <p class="notification-card__para"><?php echo count($notification); ?> notifications</p>
            </div>


            <?php foreach ($notification as $singleNotification) : ?>
              <?php if (!empty($singleNotification['title']) && $singleNotification['title'] != NULL): ?>
                <div class="notification-row <?php if (strpos($singleNotification['title'], 'Withdrawal') !== false) {
                                                echo 'withdrawal-request';
                                              } elseif (strpos($singleNotification['title'], 'Deposit') !== false) {
                                                echo 'deposit-request';
                                              } else {
                                                echo 'admin-request';
                                              } ?>">
                  <div class="notificationtab flex-a"><?php if (strpos($singleNotification['title'], 'Withdrawal') !== false) {
                                                        echo 'Withdrawal Request';
                                                      } elseif (strpos($singleNotification['title'], 'Deposit') !== false) {
                                                        echo 'Deposit';
                                                      } else {
                                                        echo 'Admin';
                                                      } ?></div>
                  <div class="flex-i justify-between notificationtab__para-wrpr">
                    <p class="notificationtab__para">
                      <?php
                      $title = $singleNotification['title'];
                      if (strpos($title, 'from') !== false) {
                        // Split the title into two parts based on the word "from"
                        $parts = explode('from', $title, 2);

                        // Trim the parts to remove extra whitespace
                        $firstPart = trim($parts[0]) . ' from '; // "Withdrawal Request Received from"
                        $secondPart = trim($parts[1]); // "Test Admin"

                        // Output the results
                        echo $firstPart . '<span class="notificationtab__para-span">' . $secondPart . '</span>';
                      } else {
                        echo $singleNotification['title'];
                      }
                      ?>
                    </p>
                    <!-- <p class="notificationtab__para">
                      Deposit request received form <span class="notificationtab__para-span"> Muhammad Adnan Akhtar</span>
                    </p> -->
                    <p class="notificationtab__para notificationtab__para2">
                      <i class="fa-regular fa-clock"></i>
                      <?php echo date('M d, Y \a\t g:i A', strtotime($singleNotification['publishDate'])); ?>
                    </p>
                  </div>
                  <p class="notification-row__para"><?php echo $singleNotification['description']; ?></p>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
            <!-- <div class="notification-row withdrawal-request">
              <div class="notificationtab flex-a">Withdrawal</div>
              <div class="flex-i justify-between notificationtab__para-wrpr">
                <p class="notificationtab__para">
                  Deposit request received form <span class="notificationtab__para-span"> Muhammad Adnan Akhtar</span>
                </p>
                <p class="notificationtab__para notificationtab__para2">
                  <i class="fa-regular fa-clock"></i>
                  Dec 11, 2023 at 9:30 Am
                </p>
              </div>
              <p class="notification-row__para">You have received a new deposit request from Muhammad Adnan Akhtar</p>
            </div>
            <div class="notification-row admin-request">
              <div class="notificationtab flex-a">Admin</div>
              <div class="flex-i justify-between notificationtab__para-wrpr">
                <p class="notificationtab__para">
                  Deposit request received form <span class="notificationtab__para-span"> Muhammad Adnan Akhtar</span>
                </p>
                <p class="notificationtab__para notificationtab__para2">
                  <i class="fa-regular fa-clock"></i>
                  Dec 11, 2023 at 9:30 Am
                </p>
              </div>
              <p class="notification-row__para">You have received a new deposit request from Muhammad Adnan Akhtar</p>
            </div> -->
          </div>
        </div>
      </div>
    </main>
  </div>
  <?php echo view("/home/new-footer-scripts"); ?>
</body>

</html>