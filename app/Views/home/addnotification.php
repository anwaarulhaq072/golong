<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Notification</title>
  <?php echo view("/home/new-header-links"); ?>
</head>

<body>
  <div class="app_wrapper">
    <?php echo view("/home/left-sidebar-new"); ?>
    <main class="main">
      <div class="card addusercard">
        <h2 class="notification-card__hdng notification-card__hdng--adduser">Create a new notification</h2>
        <?php if (isset($userData)) : ?>
          <form action="<?php echo base_url(); ?>/admin/submitnotification" method="POST" class="row profile-edit-row align-items-end row-gap--adduser" id="signupForm">
          <?php endif; ?>
          <form action="<?php echo base_url(); ?>/admin/updatenotificationData?id=<?php if (isset($notificationInfo)) echo $notificationInfo['id'] ?>" method="POST" class="row profile-edit-row align-items-end row-gap--adduser" id="signupForm">
            <input type="hidden" id="base" value="<?php echo base_url(); ?>">
            <div class="col-lg-4">
              <p class="profile-edit__para">Notification Title<span>*</span></p>
              <input type="text" class="form-control profile-edit__input" name="title" placeholder="Title" rows="3" value="<?php echo isset($notificationInfo) ? $notificationInfo['title'] : '' ?>" required>
            </div>

            <div class="col-lg-4">
              <p class="profile-edit__para">Status <span>*</span></p>
              <select name="status" class="form-control profile-edit__input form-select" required>
                <option value="">Choose</option>
                <option value="Enable" <?php if (isset($notificationInfo) && $notificationInfo['status'] == 'Enable') : ?>selected<?php endif; ?>>
                  Enable</option>
                <option value="Disable" <?php if (isset($notificationInfo) && $notificationInfo['status'] == 'Disable') : ?>selected<?php endif; ?>>
                  Disable</option>
              </select>
            </div>
            <div class="col-lg-4">
              <?php if (isset($userData)) : ?>
                <label for="status" class="form-label">Select User</label>
                <select name="forSingelNoti" class="form-control profile-edit__input form-select" required>
                  <option value="alluser">All User</option>
                  <?php

                  foreach ($userData as $row) {
                    echo '<option value="' . $row['id'] . '">' . $row['firstName'] . " " . $row['lastName'] . '</option>';
                  }
                  ?>
                </select>
              <?php endif; ?>
            </div>
            <div class="col-lg-4">
              <p class="profile-edit__para">Description<span>*</span></p>
              <textarea class="form-control profile-edit__input" name="description" placeholder="Message" rows="2" required><?php if (isset($notificationInfo)) echo $notificationInfo['description'] ?></textarea>
            </div>
            <div class="col-lg-4">
              <?php if (isset($userData)) : ?>
                <div>
                  <button class="flex-a w-fit from-btn from-btn--full" type="submit" >
                    Add Now
                  </button>
                </div>
              <?php else : ?>
                <div>
                  <button style="border: 1px solid #000000; background-color: #000000;" class="flex-a w-fit from-btn from-btn--full" type="submit">
                    Update </button>
                </div>
              <?php endif; ?>
            </div>
          </form>
      </div>
    </main>
  </div>
  <?php echo view("/home/new-footer-scripts"); ?>
  <script>
    $(document).ready(function() {
      $('#roleSelect').on('change', function() {
        if ($(this).val()) {
          $(this).addClass('value');
        } else {
          $(this).removeClass('value');
        }
      });
    });
  </script>
</body>

</html>