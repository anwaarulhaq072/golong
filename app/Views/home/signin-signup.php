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
          <img src="<?php echo base_url(); ?>/assets-new/images/logo-for-light.png" alt="" class="loginbox1__logo-img loginbox1__logo2">
        </a>
        <h4 class="loginbox1__hdng">Log in <span class="loginbox1__hdng-span">to Your Account</span></h4>
        <form action="#" class="from" id="loginForm1">
        <input type="hidden" id="base" value="<?php echo base_url(); ?>">
          <label class="inputFile__label-holder">
            <span class="inputFile__label"><span class="loginbox1__hdng-span"></span>Email</span>
            <input type="email" name="emailAddress" placeholder="Enter Your Email" class="form-control inputFile">
          </label>
          <label class="inputFile__label-holder">
            <span class="inputFile__label">Password</span>
            <input type="password" name="password" id="password" placeholder="Enter Your Password" class="form-control inputFile inputFile--password">
            <div class="passwordToggle">
              <img src="<?php echo base_url(); ?>/assets-new/images/icons/eye.svg" alt="" onclick="togglePassword()" class="eyes-with-line">
            </div>
          </label>
          <div class="flex-i justify-between checkboxRow">
            <label class="flex-i checkbox-label">
              <input type="checkbox" name="" id="" class="checkbox">
              <span class="checkbox-label__span">Keep me logged in</span>
            </label>
            <a href="<?php echo base_url(); ?>/home/forgetPassword" class="forgotpass__link">Forgot Password?</a>
          </div>
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
  <script src="<?php echo base_url(); ?>/assets-new/js/ajax_login.js"></script>
  <script>
    function togglePassword() {
    var inputField = document.getElementById("password");
    if (inputField.type === "password") {
        inputField.type = "text";
    } else {
        inputField.type = "password";
    }
}
  </script>
</body>

</html>