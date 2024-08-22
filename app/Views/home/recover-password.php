<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password</title>
  <?php echo view("/home/new-header-links"); ?>
</head>

<body>
  <div class="app_wrapper app_wrapper-login">
    <img src="<?php echo base_url(); ?>/assets-new/images/login-bg.svg" alt="" class="logins__bg">
    <div class="loginsWrpper">
      <div class="loginbox1">
        <a href="<?php echo base_url(); ?>" class="loginbox1__logo flex-i">
          <img src="<?php echo base_url(); ?>/assets-new/images/logo.svg" alt="" class="loginbox1__logo-img">
        </a>
        <div class="loginbox-hdng-holder">
          <h4 class="loginbox1__hdng">Forgot your password</h4>
          <p class="loginbox1__para">
            If you want to forgot your password you need to enter your email and we will send you a code on you email.
          </p>
        </div>
        <form class="from" id="forgetForm">
        <input type="hidden" id="base" value="<?php echo base_url(); ?>" >
          <label class="inputFile__label-holder inputFile__label-holder--mb-60">
            <span class="inputFile__label">Enter Email</span>
            <input type="email" id="emailaddress" placeholder="Enter Email" class="form-control inputFile">
          </label>

          <button class="formBtn flex-a">Reset Password</button>
        </form>
      </div>
      <div class="loginbox2">
        <img src="<?php echo base_url(); ?>/assets-new/images/logins-img.png" alt="" class="loginbox2__img">
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
      </div>
    </div>
  </div>
  <?php echo view("/home/new-footer-script"); ?>
  <script src="<?php echo base_url(); ?>/assets/js/forgetPassword.js"></script>
</body>

</html>