<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Success</title>
  <?php echo view("/home/new-header-links"); ?>
</head>

<body>
  <div class="app_wrapper">
    <div class="successPage">
      <div class="card successPageCard">
        <a href="/" class="loginbox1__logo loginbox1__logo--successPageCard flex-i">
          <img src="assets/images/logo.svg" alt="" class="loginbox1__logo-img loginbox1__logo1">
          <img src="assets/images/logo-for-light.png" alt="" class="loginbox1__logo-img loginbox1__logo2">
        </a>
        <div class="loginbox1" style="margin-top: -70px;padding: 0px">
         <div class="logIn">
        <a href="<?php echo base_url(); ?>" class="loginbox1__logo flex-i">
          <img src="<?php echo base_url(); ?>/assets-new/images/logo.svg" alt="" class="loginbox1__logo-img loginbox1__logo1">
          <img src="<?php echo base_url(); ?>/assets-new/images/logo-for-light.png" alt="" class="loginbox1__logo-img loginbox1__logo2">
        </a>
        </div>
        </div>
        <div>
          <h2 class="successPageCard__hdng">Your request is under review.</h2>
          <p class="successPageCard__para">You will get an email once your account is approved.</p>
        </div>
      </div>
    </div>
  </div>
  <?php echo view("/home/new-footer-script"); ?>
</body>

</html>