<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Enter Code</title>
  <?php echo view("/home/new-header-links"); ?>
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
          <img src="<?php echo base_url(); ?>/assets-new/images/logo-for-light.png" alt="" class="loginbox1__logo-img loginbox1__logo2">
        </a>
        <div class="loginbox-hdng-holder">
          <h4 class="loginbox1__hdng">2FA Code</h4>
          <p class="loginbox1__para" style="margin-bottom: -30px;">
            Please enter code that was sent to your email
          </p>
        </div>
        <form class="from" id="otpForm">
          <input type="hidden" id="base" value="<?php echo base_url(); ?>">
          <input type="hidden" id="us_id" value="<?php echo $_GET['uid']; ?>">
          <label class="inputFile__label-holder inputFile__label-holder--mb-60">
            <span class="inputFile__label">Enter Code</span>
            <input type="password" name="code" placeholder="123456" class="form-control inputFile">
          </label>
          <button type="submit" class="formBtn flex-a">Log In</button>
        </form>
        </div>
      </div>
      <!--<div class="loginbox2">-->
      <!--<img src="<?php echo base_url(); ?>/assets-new/images/logins-img.png" alt="" class="loginbox2__img loginbox2__img-for-dark">-->
      <!--  <img src="<?php echo base_url(); ?>/assets-new/images/logins-img-for-white.png" alt="" class="loginbox2__img loginbox2__img-for-light">-->
      <!--  <div class="swiper loginboxSlider">-->
      <!--    <div class="swiper-wrapper">-->
      <!--      <div class="swiper-slide">-->
      <!--        <h3 class="logins-sl__hdng">Unlocking Your Financial Potential</h3>-->
      <!--        <p class="logins-sl__para">-->
      <!--          Unlocking Your Financial Potential with tailored insights and tools to maximize your investment returns.-->
      <!--        </p>-->
      <!--      </div>-->
      <!--      <div class="swiper-slide">-->
      <!--        <h3 class="logins-sl__hdng">Unlocking Your Financial Potential</h3>-->
      <!--        <p class="logins-sl__para">-->
      <!--          Unlocking Your Financial Potential with tailored insights and tools to maximize your investment returns.-->
      <!--        </p>-->
      <!--      </div>-->
      <!--      <div class="swiper-slide">-->
      <!--        <h3 class="logins-sl__hdng">Unlocking Your Financial Potential</h3>-->
      <!--        <p class="logins-sl__para">-->
      <!--          Unlocking Your Financial Potential with tailored insights and tools to maximize your investment returns.-->
      <!--        </p>-->
      <!--      </div>-->
      <!--    </div>-->
      <!--    <div class="loginboxSlider-pagination"></div>-->
      <!--  </div>-->
      <!--</div>-->
    </div>
  </div>
  <?php echo view("/home/new-footer-script"); ?>
  <script src="<?php echo base_url(); ?>/assets-new/js/ajax_login.js"></script>
  <script src="<?php echo base_url(); ?>/assets/js/sendOtp.js"></script>
</body>

</html>