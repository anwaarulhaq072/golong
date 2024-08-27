<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>New Password</title>
  < <?php echo view("/home/new-header-links"); ?>
    </head>

<body>
  <div class="app_wrapper app_wrapper-login">
    <img src="<?php echo base_url(); ?>/assets-new/images/login-bg.svg" alt="" class="logins__bg logins__bg-for-dark">
    <img src="<?php echo base_url(); ?>/assets-new/images/login-bg-for-white.svg" alt="" class="logins__bg logins__bg-for-light">
    <div class="loginsWrpper">
      <div class="loginbox1">
        <div class="logIn">
          <a href="/" class="loginbox1__logo flex-i">
            <img src="<?php echo base_url(); ?>/assets-new/images/logo.svg" alt="" class="loginbox1__logo-img loginbox1__logo1">
            <img src="<?php echo base_url(); ?>/assets-new/images/logo-for-light.svg" alt="" class="loginbox1__logo-img loginbox1__logo2">
          </a>
          <div class="loginbox-hdng-holder">
            <h4 class="loginbox1__hdng">Create new password</h4>
            <p class="loginbox1__para">
              Now you can create your new password
            </p>
          </div>
          <form class="from" id="newPasswordForm">
            <input type="hidden" id="base" value="<?php echo base_url(); ?>">
            <input type="hidden" id="userid" value="<?php echo $user['id'] ?>">
            <label class="inputFile__label-holder inputFile__label-holder--mb-60">
              <span class="inputFile__label">New password</span>
              <input type="password" id="password" name="password" placeholder="Enter New Password" class="form-control inputFile inputFile--password">
              <div class="passwordToggle">
                <img src="<?php echo base_url(); ?>/assets-new/images/icons/eye.svg" alt="" class="eyes-with-line">
              </div>
            </label>
            <label class="inputFile__label-holder inputFile__label-holder--mb-60">
              <span class="inputFile__label">Confirm password</span>
              <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control inputFile inputFile--password">
              <div class="passwordToggle">
                <img src="<?php echo base_url(); ?>/assets-new/images/icons/eye.svg" alt="" class="eyes-with-line">
              </div>
            </label>
            <button type="submit" class="formBtn flex-a">Log In</button>
          </form>
        </div>
      </div>
      <!-- <div class="loginbox2">
        <img src="<?php echo base_url(); ?>/assets-new/images/logins-img.png" alt="" class="loginbox2__img loginbox2__img-for-dark">
        <img src="<?php echo base_url(); ?>/assets-new/images/logins-img-for-white.png" alt="" class="loginbox2__img loginbox2__img-for-light">
        <div class="swiper loginboxSlider">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <h3 class="logins-sl__hdng">Unlocking Your Financial Potential</h3>
              <p class="logins-sl__para">
                Unlocking Your Financial Potential with tailored insights and tools to maximize your investment returns.
              </p>
            </div>
            <div class="swiper-slide">
              <h3 class="logins-sl__hdng">Unlocking Your Financial Potential</h3>
              <p class="logins-sl__para">
                Unlocking Your Financial Potential with tailored insights and tools to maximize your investment returns.
              </p>
            </div>
            <div class="swiper-slide">
              <h3 class="logins-sl__hdng">Unlocking Your Financial Potential</h3>
              <p class="logins-sl__para">
                Unlocking Your Financial Potential with tailored insights and tools to maximize your investment returns.
              </p>
            </div>
          </div>
          <div class="loginboxSlider-pagination"></div>
        </div>
      </div> -->
    </div>
  </div>
  <?php echo view("/home/header-links"); ?>
  <script src="<?php echo base_url(); ?>/assets/js/forgetPassword.js"></script>
</body>

</html>