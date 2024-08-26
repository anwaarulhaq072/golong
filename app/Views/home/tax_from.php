<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tex Farm</title>
  <?php echo view("/home/new-header-links"); ?>
</head>

<body>
  <div class="app_wrapper">
    <main>
    <?php if (isset($callChartAdmin) && $callChartAdmin == true) : ?>
      <a href="<?php echo base_url()."/admin/userDashboardNew?userid=".$_GET['userid']; ?>" class="flex-a profile-edit-btn profile-edit-btn--fit">
        Back
      </a>
      <?php endif; ?>
      <div class="notiHeadingBox">
      <?php if (isset($callChartAdmin) && $callChartAdmin == false) : ?>
        <h2 class="notification-card__hdng">Tex Farm</h2>
        <p class="notification-card__para">Please fill in the 1099 Tax form to access the dashboard.</p>
        <?php endif; ?>
      </div>
      <div class="card addusercard">
        <form class="row profile-edit-row align-items-end row-gap--adduser" id="deposit_form" action="<?php echo base_url(); ?>/user/submit_tax_from" method="POST">
          <div class="col-lg-12">
            <p class="profile-edit__para">PAYER'S name, street address, city or town, state or province, country, ZIP or
              foreign postal code, and telephone no. </p>
            <textarea name="address" placeholder="First Name" id="address" class="form-control profile-edit__input profile-edit__input--textarea"
              important></textarea>
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">RECIPIENT'S TIN <span>*</span></p>
            <input type="text" placeholder="" value="" class="form-control profile-edit__input" important>
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">PAYER'S TIN <span>*</span></p>
            <input type="text" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">RECIPIENT'S name <span>*</span></p>
            <input type="text" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Street address (including apt. no.)<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">City or town, state or province, country, and ZIP or foreign postal
              code<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Account number (see instructions)<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Rents<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Royalties<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Other Income<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Federal Income Tax Withheld<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Fishing boat proceeds<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Medical and health care
              payments<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">
              Payer made direct sales totaling $5,000 or more of consumer products to recipient for resale
            </p>
            <input type="checkbox" name="" id="" class="checkbox">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Substitute payments in lieu
              of dividends or interest<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Crop insurance proceeds<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Gross proceeds paid to an
              attorney<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Fish purchased for resale<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Section 409A deferrals<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">FATCA filing
              requirement</p>
            <input type="checkbox" name="" id="" class="checkbox">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Excess golden parachute
              payments<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Nonqualified deferred
              compensation<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">State tax withheld<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">State/Payer's state no<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">State income<span>*</span></p>
            <input type="Email" placeholder="" value="" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">2nd TIN not<span>*</span></p>
            <input type="checkbox" name="" id="" class="checkbox">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <button class="flex-a w-fit from-btn from-btn--full">Submit</button>
          </div>
        </form>
      </div>
    </main>
  </div>
  <?php echo view("/home/new-footer-scripts"); ?>
</body>

</html>