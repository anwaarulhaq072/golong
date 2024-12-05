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
        <img src="<?php echo base_url(); ?>/assets-new/images/logo.svg" alt="" class="loginbox1__logo-img loginbox1__logo1">
        <img src="<?php echo base_url(); ?>/assets-new/images/logo-for-light.png" alt="" class="loginbox1__logo-img loginbox1__logo2">
        </a>
        <div>
          <svg version="1.1" class="successPageCard__img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
            <circle class="path circle" fill="none" stroke="#0073B6" stroke-width="6" stroke-miterlimit="10" cx="65.1"
              cy="65.1" r="62.1" />
            <polyline class="path check" fill="none" stroke="#0073B6" stroke-width="6" stroke-linecap="round"
              stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " />
          </svg>
          <h2 class="successPageCard__hdng">See you again !</h2>
          <p class="successPageCard__para">You have successfully signed out. <a href="<?php echo base_url(); ?>">Sign in here</a> </p>
        </div>
      </div>
    </div>
  </div>
  <?php echo view("/home/new-footer-script"); ?>
</body>

</html>