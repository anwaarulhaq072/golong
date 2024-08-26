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
            <p class="profile-edit__para" >PAYER'S name, street address, city or town, state or province, country, ZIP or
              foreign postal code, and telephone no. </p>
            <textarea name="address" placeholder="First Name" id="address" class="form-control profile-edit__input profile-edit__input--textarea"
              important><?php if(isset($tax_form_data[0]['address'])) echo $tax_form_data[0]['address']; ?></textarea>
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">RECIPIENT'S TIN <span>*</span></p>
            <input type="text" name="recipients_tin" placeholder="" value="<?php if(isset($tax_form_data[0]['recipients_tin'])) echo $tax_form_data[0]['recipients_tin']; ?>" class="form-control profile-edit__input" important>
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">PAYER'S TIN <span>*</span></p>
            <input type="text" name="payers_tin" placeholder="" value="<?php if(isset($tax_form_data[0]['payers_tin'])) echo $tax_form_data[0]['payers_tin']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">RECIPIENT'S name <span>*</span></p>
            <input type="text" name="recipients_name" placeholder="" value="<?php if(isset($tax_form_data[0]['recipients_name'])) echo $tax_form_data[0]['recipients_name']; ?>" class="form-control profile-edit__input">
          </div> 
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Street address (including apt. no.)<span>*</span></p>
            <input type="text" name="street_address" placeholder="" value="<?php if(isset($tax_form_data[0]['street_address'])) echo $tax_form_data[0]['street_address']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">City or town, state or province, country, and ZIP or foreign postal
              code<span>*</span></p>
            <input type="text" name="city_or_town_state_or_province_country" placeholder="" value="<?php if(isset($tax_form_data[0]['city_or_town_state_or_province_country'])) echo $tax_form_data[0]['city_or_town_state_or_province_country']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Account number (see instructions)<span>*</span></p>
            <input type="text" name="account_number" placeholder="" value="<?php if(isset($tax_form_data[0]['account_number'])) echo $tax_form_data[0]['account_number']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Rents<span>*</span></p>
            <input type="text" name="rents" placeholder="" value="<?php if(isset($tax_form_data[0]['rents'])) echo $tax_form_data[0]['rents']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Royalties<span>*</span></p>
            <input type="text" name="royalties" placeholder="" value="<?php if(isset($tax_form_data[0]['royalties'])) echo $tax_form_data[0]['royalties']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Other Income<span>*</span></p>
            <input type="text" name="other_income" placeholder="" value="<?php if(isset($tax_form_data[0]['other_income'])) echo $tax_form_data[0]['other_income']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Federal Income Tax Withheld<span>*</span></p>
            <input type="text" name="federal_income_tax_withheld" placeholder="" value="<?php if(isset($tax_form_data[0]['federal_income_tax_withheld'])) echo $tax_form_data[0]['federal_income_tax_withheld']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Fishing boat proceeds<span>*</span></p>
            <input type="text" name="fishing_boat_proceeds" placeholder="" value="<?php if(isset($tax_form_data[0]['fishing_boat_proceeds'])) echo $tax_form_data[0]['fishing_boat_proceeds']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Medical and health care
              payments<span>*</span></p>
            <input type="text" name="medical_and_health_care_payments" placeholder="" value="<?php if(isset($tax_form_data[0]['medical_and_health_care_payments'])) echo $tax_form_data[0]['medical_and_health_care_payments']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">
              Payer made direct sales totaling $5,000 or more of consumer products to recipient for resale
            </p>
            <input type="checkbox" name="payer_made_direct_sales_totaling_or_more_of_consumer_products_to_recipient_for_resale" id="" class="checkbox" <?php if(isset($tax_form_data[0]['payer_made_direct']) && $tax_form_data[0]['payer_made_direct'] == 'Yes'): ?> checked <?php endif; ?>>
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Substitute payments in lieu
              of dividends or interest<span>*</span></p>
            <input type="text" name="substitute_payments_in_lieu_of_dividends_or_interest" placeholder="" value="<?php if(isset($tax_form_data[0]['substitute_payments'])) echo $tax_form_data[0]['substitute_payments']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Crop insurance proceeds<span>*</span></p>
            <input type="text" name="crop_insurance_proceeds" placeholder="" value="<?php if(isset($tax_form_data[0]['crop_insurance_proceeds'])) echo $tax_form_data[0]['crop_insurance_proceeds']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Gross proceeds paid to an
              attorney<span>*</span></p>
            <input type="text" name="gross_proceeds_paid_to_anattorney" placeholder="" value="<?php if(isset($tax_form_data[0]['gross_proceeds'])) echo $tax_form_data[0]['gross_proceeds']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Fish purchased for resale<span>*</span></p>
            <input type="text" name="fish_purchased_for_resale" placeholder="" value="<?php if(isset($tax_form_data[0]['fish_purchased_for_resale'])) echo $tax_form_data[0]['fish_purchased_for_resale']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Section 409A deferrals<span>*</span></p>
            <input type="text" name="section_409A_deferrals" placeholder="" value="<?php if(isset($tax_form_data[0]['section_409A_deferrals'])) echo $tax_form_data[0]['section_409A_deferrals']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">FATCA filing
              requirement</p>
            <input type="checkbox" name="fatca_filing_requirement" id="" class="checkbox" <?php if(isset($tax_form_data[0]['fatca_filing_requirement']) && $tax_form_data[0]['fatca_filing_requirement'] == 'Yes'): ?> checked <?php endif; ?>>
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Excess golden parachute
              payments<span>*</span></p>
            <input type="text" name="excess_golden_parachute_payments" placeholder="" value="<?php if(isset($tax_form_data[0]['excess_golden'])) echo $tax_form_data[0]['excess_golden']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">Nonqualified deferred
              compensation<span>*</span></p>
            <input type="text" name="nonqualified_deferred_compensation" placeholder="" value="<?php if(isset($tax_form_data[0]['nonqualified_deferred_compensation'])) echo $tax_form_data[0]['nonqualified_deferred_compensation']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">State tax withheld<span>*</span></p>
            <input type="text" name="state_tax_withheld" placeholder="" value="<?php if(isset($tax_form_data[0]['state_tax_withheld'])) echo $tax_form_data[0]['state_tax_withheld']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">State/Payer's state no<span>*</span></p>
            <input type="text" name="State_or_Payers_state_no" placeholder="" value="<?php if(isset($tax_form_data[0]['State_or_Payers_state_no'])) echo $tax_form_data[0]['State_or_Payers_state_no']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">State income<span>*</span></p>
            <input type="text" name="state_income" placeholder="" value="<?php if(isset($tax_form_data[0]['state_income'])) echo $tax_form_data[0]['state_income']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <p class="profile-edit__para">2nd TIN not<span>*</span></p>
            <input type="checkbox" name="2nd_tin_not" id="" class="checkbox" value="Yes" <?php if(isset($tax_form_data[0]['2nd_tin_not']) && $tax_form_data[0]['2nd_tin_not'] == 'Yes'): ?> checked <?php endif; ?>>
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