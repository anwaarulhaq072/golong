<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ID Submission</title>
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
          <h4 class="loginbox1__hdng">Upload Your ID</h4> 
          <form action="<?php echo base_url(); ?>/user/submit_kyc_document" method="POST" enctype="multipart/form-data" class="from">
                <div class="d-flex justify-content-end align-items-center">
                  <p class="label-text" style="margin-right: 15px;">Type</p>
                  <div class="form-check" style="margin-right: 15px;">
                    <input type="radio" id="approved" name="approval_status" value="KYC" class="form-check-input approved" checked>
                    <label for="approved" class="form-check-label" style="color:var(--card-sub-heading-color);">KYC</label>
                  </div>
                  <div class="form-check">
                    <input type="radio" id="not-approved" name="approval_status" value="KYB" class="form-check-input approved">
                    <label for="not_approved" class="form-check-label" style="color:var(--card-sub-heading-color);">KYB</label>
                  </div>
                </div>
            <label class="inputFile__label-holder">
              <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
              <span class="inputFile__label">ID Front Side</span>
              <input type="file" name="idFrontSide" class="form-control inputFile" style="padding: 13px 25px;" required>
            </label>
            <label class="inputFile__label-holder">
              <span class="inputFile__label">ID Back Side</span>
              <input type="file" name="idBackSide" class="form-control inputFile" style="padding: 13px 25px;" required>
            </label>
            <div id="kycForm">
            <label class="inputFile__label-holder">
              <span class="inputFile__label">Proof Of Address</span>
              <input type="file" name="proof_of_address" class="form-control inputFile" style="padding: 13px 25px;">
            </label>
            </div>
            <div id="kybForm">
            <label class="inputFile__label-holder">
              <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
              <span class="inputFile__label">Origination Docs</span>
              <input type="file" name="origination_docs[]" class="form-control inputFile" style="padding: 13px 25px;" multiple>
            </label>
            <label class="inputFile__label-holder">
              <span class="inputFile__label">Proof Of Address</span>
              <input type="file" name="proof_of_address2" class="form-control inputFile" style="padding: 13px 25px;">
            </label>
            <label class="inputFile__label-holder">
              <span class="inputFile__label">Shareholder Agreement</span>
              <input type="file" name="shareholder_agreement" class="form-control inputFile" style="padding: 13px 25px;">
            </label>
            <label class="inputFile__label-holder">
              <span class="inputFile__label">Proof of Good Standing</span>
              <input type="file" name="proof_of_good_standing" class="form-control inputFile" style="padding: 13px 25px;">
            </label>
            </div>
            <button id="loginBtn" type="submit" class="formBtn flex-a">Upload</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php echo view("/home/new-footer-script"); ?>
  <script>
    $(document).ready(function() {
    $('#kycForm').show();
    $('#kybForm').hide();
    $('.approved').on('change', function() {
      if ($(this).val() == 'KYB') {
        $('#kycForm').hide();
        $('#kybForm').show();
      } else {
        $('#kycForm').show();
        $('#kybForm').hide();
      }
    });
  });
  </script>
</body>

</html>
