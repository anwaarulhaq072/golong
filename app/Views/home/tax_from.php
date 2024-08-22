<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Deposits - <?php echo APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nvest Clients - Where you can invest" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php echo view("/home/header-links"); ?>
    <style>
    @media (min-width: 768px) { /* Target desktop screens */
        .desktop-width {
            width: 80%;
        }
    }
</style>

</head>

<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}}'>
    <!-- Begin page -->
    <div id="wrapper">
        <?php //echo view("/home/left-sidebar"); ?>
        <?php echo view("/home/top-bar", $notification); ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="content-page" style="background-color: #F5F5FC !important;">
            <div class="content desktop-width">
                <!-- Start Content-->
                <h3 class=" my-4">Tax Form</h3>
                <?php if (isset($callChartAdmin) && $callChartAdmin == true) : ?>
                    <a href="<?php echo base_url()."/admin/userDashboard?userid=".$_GET['userid']; ?>"><button style="margin-bottom: 10px;" class="btn btn-primary">Back</button></a>              
                    <?php endif; ?>
                <div class="card">
                    <div class="card-body">
                    <?php if (isset($callChartAdmin) && $callChartAdmin == false) : ?>
                    <p style="color: red">Please fill in the 1099 Tax form to access the dashboard.</p>
                    <?php endif; ?>
                    <form id="deposit_form" action="<?php echo base_url(); ?>/user/submit_tax_from" method="POST">
                    <div class="row">
                    <div class="mb-3 mt-2 col-lg-12 col-md-12 col-12">
                        <label for="address"><h5>PAYER'S name, street address, city or town, state or province, country, ZIP
or foreign postal code, and telephone no.<span style="color: red;"></span></h5></label>
                        <textarea name="address" class="form-control" id="address" rows="4"> <?php if(isset($tax_form_data[0]['address'])) echo $tax_form_data[0]['address']; ?> </textarea>
                    </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="recipients_tin" class="form-label">RECIPIENT'S TIN<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="recipients_tin" value=" <?php if(isset($tax_form_data[0]['recipients_tin'])) echo $tax_form_data[0]['recipients_tin']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="payers_tin" class="form-label">PAYER'S TIN<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="payers_tin" value=" <?php if(isset($tax_form_data[0]['payers_tin'])) echo $tax_form_data[0]['payers_tin']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="recipients_name" class="form-label">RECIPIENT'S name<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="recipients_name" value =" <?php if(isset($tax_form_data[0]['recipients_name'])) echo $tax_form_data[0]['recipients_name']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="street_address" class="form-label">Street address (including apt. no.)<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="street_address" value =" <?php if(isset($tax_form_data[0]['street_address'])) echo $tax_form_data[0]['street_address']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="city_or_town_state_or_province_country" class="form-label">City or town, state or province, country, and ZIP or foreign postal code<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="city_or_town_state_or_province_country" value =" <?php if(isset($tax_form_data[0]['city_or_town_state_or_province_country'])) echo $tax_form_data[0]['city_or_town_state_or_province_country']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="account_number" class="form-label">Account number (see instructions)<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="account_number" value =" <?php if(isset($tax_form_data[0]['account_number'])) echo $tax_form_data[0]['account_number']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="rents" class="form-label">Rents<span style="color: red;" >*</span></label>
                                                    <input class="form-control" type="text" name="rents" value =" <?php if(isset($tax_form_data[0]['rents'])) echo $tax_form_data[0]['rents']; ?>" required>
                                                </div>
                                                <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="royalties" class="form-label">Royalties<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="royalties" value =" <?php if(isset($tax_form_data[0]['royalties'])) echo $tax_form_data[0]['royalties']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="other_income" class="form-label">Other Income<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="other_income" value =" <?php if(isset($tax_form_data[0]['other_income'])) echo $tax_form_data[0]['other_income']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="federal_income_tax_withheld" class="form-label">Federal Income Tax Withheld<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="federal_income_tax_withheld" value =" <?php if(isset($tax_form_data[0]['federal_income_tax_withheld'])) echo $tax_form_data[0]['federal_income_tax_withheld']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="fishing_boat_proceeds" class="form-label"> Fishing boat proceeds<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="fishing_boat_proceeds" value =" <?php if(isset($tax_form_data[0]['fishing_boat_proceeds'])) echo $tax_form_data[0]['fishing_boat_proceeds']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="medical_and_health_care_payments" class="form-label">Medical and health care
payments<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="medical_and_health_care_payments" value =" <?php if(isset($tax_form_data[0]['medical_and_health_care_payments'])) echo $tax_form_data[0]['medical_and_health_care_payments']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="payer_made_direct_sales_totaling_or_more_of_consumer_products_to_recipient_for_resale" class="form-label">Payer made direct sales
totaling $5,000 or more of
consumer products to
recipient for resale</label>
                            <input type="checkbox" name="payer_made_direct_sales_totaling_or_more_of_consumer_products_to_recipient_for_resale" value="Yes" <?php if(isset($tax_form_data[0]['payer_made_direct']) && $tax_form_data[0]['payer_made_direct'] == 'Yes'): ?> checked <?php endif; ?>>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="substitute_payments_in_lieu_of_dividends_or_interest" class="form-label">Substitute payments in lieu
of dividends or interest<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="substitute_payments_in_lieu_of_dividends_or_interest" value =" <?php if(isset($tax_form_data[0]['substitute_payments'])) echo $tax_form_data[0]['substitute_payments']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="crop_insurance_proceeds" class="form-label">Crop insurance proceeds<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="crop_insurance_proceeds" value =" <?php if(isset($tax_form_data[0]['crop_insurance_proceeds'])) echo $tax_form_data[0]['crop_insurance_proceeds']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="gross_proceeds_paid_to_anattorney" class="form-label">Gross proceeds paid to an
attorney<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="gross_proceeds_paid_to_anattorney" value =" <?php if(isset($tax_form_data[0]['gross_proceeds'])) echo $tax_form_data[0]['gross_proceeds']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="fish_purchased_for_resale" class="form-label">Fish purchased for resale<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="fish_purchased_for_resale" value =" <?php if(isset($tax_form_data[0]['fish_purchased_for_resale'])) echo $tax_form_data[0]['fish_purchased_for_resale']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="section_409A_deferrals" class="form-label">Section 409A deferrals<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="section_409A_deferrals" value =" <?php if(isset($tax_form_data[0]['section_409A_deferrals'])) echo $tax_form_data[0]['section_409A_deferrals']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="fatca_filing_requirement" class="form-label">FATCA filing
requirement</label>
                            <input type="checkbox" name="fatca_filing_requirement" value="Yes" <?php if(isset($tax_form_data[0]['fatca_filing_requirement']) && $tax_form_data[0]['fatca_filing_requirement'] == 'Yes'): ?> checked <?php endif; ?>>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="excess_golden_parachute_payments" class="form-label">Excess golden parachute
payments<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="excess_golden_parachute_payments" value =" <?php if(isset($tax_form_data[0]['excess_golden'])) echo $tax_form_data[0]['excess_golden']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="nonqualified_deferred_compensation" class="form-label">Nonqualified deferred
compensation<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="nonqualified_deferred_compensation" value  =" <?php if(isset($tax_form_data[0]['nonqualified_deferred_compensation'])) echo $tax_form_data[0]['nonqualified_deferred_compensation']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="state_tax_withheld" class="form-label">State tax withheld<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="state_tax_withheld" value  =" <?php if(isset($tax_form_data[0]['state_tax_withheld'])) echo $tax_form_data[0]['state_tax_withheld']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for=" State_or_Payers_state_no" class="form-label"> State/Payer's state no<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name=" State_or_Payers_state_no" value  =" <?php if(isset($tax_form_data[0]['State_or_Payers_state_no'])) echo $tax_form_data[0]['State_or_Payers_state_no']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="state_income" class="form-label">State income<span style="color: red;" >*</span></label>
                            <input class="form-control" type="text" name="state_income" value  =" <?php if(isset($tax_form_data[0]['state_income'])) echo $tax_form_data[0]['state_income']; ?>" required>
                        </div>
                        <div class="mb-3 mt-2 col-lg-4 col-md-6 col-12">
                                                    <label for="2nd_tin_not" class="form-label">2nd TIN not</label>
                            <input type="checkbox" name="2nd_tin_not" value="Yes" <?php if(isset($tax_form_data[0]['2nd_tin_not']) && $tax_form_data[0]['2nd_tin_not'] == 'Yes'): ?> checked <?php endif; ?>>
                        </div>
                    </div>
                    <?php if (isset($callChartAdmin) && $callChartAdmin == false) : ?>
                    <button type="submit" class="btn btn-primary submit_deposit" style=" background-color: #0073B6;float: inline-end;">Submit</button>
                    <?php endif; ?>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo view("/home/footer-scripts"); ?>
    <script>
    </script>
    
</body>

</html>