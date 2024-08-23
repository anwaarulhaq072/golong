<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add User</title>
  <?php echo view("/home/new-header-links"); ?>
</head>

<body>
  <div class="app_wrapper">
  <?php echo view("/home/left-sidebar-new"); ?>
    <main class="main">
      <div class="card addusercard">
        <h2 class="notification-card__hdng notification-card__hdng--adduser">Create a new user</h2>
        <form class="row profile-edit-row align-items-end row-gap--adduser" id="signupForm">
        <input type="hidden" id="base" value="<?php echo base_url(); ?>">
          <div class="col-lg-4">
            <p class="profile-edit__para">First Name <span>*</span></p>
            <input type="text" placeholder="First Name"  name="firstName" class="form-control profile-edit__input" important required>
          </div>
          <div class="col-lg-4">
            <p class="profile-edit__para">Last Name <span>*</span></p>
            <input type="text" placeholder="Last Name" name="lastName" class="form-control profile-edit__input" required>
          </div>
          <div class="col-lg-4">
            <p class="profile-edit__para">Phone Number <span>*</span></p>
            <input type="tel" placeholder="Phone Number" name="phoneNumber" class="form-control profile-edit__input">
          </div>
          <div class="col-lg-4">
            <p class="profile-edit__para">Email Address<span>*</span></p>
            <input type="email" placeholder="Email" name="emailAddress" class="form-control profile-edit__input">
          </div>
          <div class="col-lg-4">
            <p class="profile-edit__para">Role<span></span></p>
            <select id="role" class="form-control profile-edit__input form-select">
              <option value="" disabled selected>Select a role</option>
              <option value="2">User</option>
              <option value="1">Admin</option>
            </select>
          </div>
          <div class="col-lg-4">
            <button type="submit" class="flex-a w-fit from-btn from-btn--full">Submit</button>
          </div>
        </form>
      </div>
    </main>
  </div>
  <?php echo view("/home/new-footer-scripts"); ?>
  <script src="<?php echo base_url(); ?>/assets/js/ajax_login.js"></script>
  <script>
    $(document).ready(function () {
      $('#roleSelect').on('change', function () {
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