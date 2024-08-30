<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <?php echo view("/home/new-header-links"); ?>
</head>

<body>
  <div class="app_wrapper app_wrapper-login">
    <img src="<?php echo base_url(); ?>/assets-new/images/login-bg.svg" alt="" class="logins__bg logins__bg-for-dark">
    <img src="<?php echo base_url(); ?>/assets-new/images/login-bg-for-white.svg" alt="" class="logins__bg logins__bg-for-light">
    <div class="loginsWrpper">
      <div class="loginbox1">
          <div class="logIn">
        <a href="<?php echo base_url(); ?>" class="loginbox1__logo flex-i">
          <img src="<?php echo base_url(); ?>/assets-new/images/logo.svg" alt="" class="loginbox1__logo-img loginbox1__logo1">
          <img src="<?php echo base_url(); ?>/assets-new/images/logo-for-light.svg" alt="" class="loginbox1__logo-img loginbox1__logo2">
        </a>
        <h4 class="loginbox1__hdng">Log in with Super Admin Account</h4>
        <form action="#" id="loginFormSuperAdmin" class="from">
          <label class="inputFile__label-holder">
             <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
            <span class="inputFile__label">User Email address</span>
            <input type="email" name="useremailAddress" placeholder="Enter Email" class="form-control inputFile" required>
          </label>
          <label class="inputFile__label-holder">
            <span class="inputFile__label">Super Admin Email address</span>
            <input type="email" name="emailAddress" placeholder="Enter Email" class="form-control inputFile" required>
          </label>
          <label class="inputFile__label-holder">
            <span class="inputFile__label">Password</span>
            <input type="password" name="password" placeholder="Enter Your Password" class="form-control inputFile inputFile--password" required>
            <div class="passwordToggle">
              <img src="<?php echo base_url(); ?>/assets-new/images/icons/eye.svg" alt="" class="eyes-with-line">
            </div>
          </label>
          <button id="loginBtn" type="submit" class="formBtn flex-a">Log In</button>
        </form>
        </div>
      </div>
      <!--<div class="loginbox2">-->
      <!--  <img src="<?php echo base_url(); ?>/assets-new/images/logins-img.png" alt="" class="loginbox2__img loginbox2__img-for-dark">-->
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
  <script src="<?php echo base_url(); ?>/assets/js/superlogin2.js"></script>
</body>

</html>