<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>New Withdrawal Request</title>
  <?php echo view("/home/new-header-links"); ?>
</head>

<body>
  <div class="app_wrapper">
    <?php echo view("/home/left-sidebar-new"); ?>
    <main class="main">
      <div class="flex-i wdthtopBox-wrpr">
        <div class="notiHeadingBox notiHeadingBox--wdthtop">
          <h2 class="notification-card__hdng mb-0">Withdrawal Request</h2>
        </div>
        <a href="<?= base_url(); ?>/user/withdrawal" class="flex-a wthdrwlBtn">Withdrawal History</a>
      </div>
      <div class="error flex-i d-none">
        First you need to select “Currency” & “Payment Option”
      </div>
      <div class="row row-gap">
        <div class="col-lg-8">
          <div class="card withdrawal-req-card">
            <form id="withdrawal_form" action="<?php echo base_url(); ?>/user/submit_withdrawal" method="post">
              <div class="row row-gap mb-row-gap">
                <div class="col-12">
                  <label for="currency" class="wrc__label">Select Currency <span>*</span></label>
                  <select id="currency" class="form-control form-select wrc__select selectCurrency" required>
                    <option value="select">Select</option>
                    <?php foreach ($currency as $single) : ?>
                      <option value="<?= $single['id']; ?>"><?= $single['name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-12">
                  <label for="usdOption" class="wrc__label">Select Payment Option <span>*</span></label>
                  <select id="usdOption" class="form-control form-select wrc__select selectPayment" required>
                    <option value="">Select</option>
                    <optgroup class="forCryptoSelect d-none" label="Crypto Options">
                      <?php foreach ($currency_options['crypto'] as $single) : ?>
                        <option value="<?= $single['id']; ?>"><?= $single['name']; ?></option>
                      <?php endforeach; ?>
                    </optgroup>
                    <optgroup class="forUSDTselect d-none" label="USD Options">
                      <?php foreach ($currency_options['usd'] as $single) : ?>
                        <option value="<?= $single['id']; ?>"><?= $single['name']; ?></option>
                      <?php endforeach; ?>
                    </optgroup>
                  </select>
                </div>
              </div>
              <div class="row row-gap afterSelect">
                <div class="col-md-6">
                  <label for="" class="wrc__label">Amount <span>*</span></label>
                  <input type="text" class="wrc__input form-control" placeholder="Amount" required>
                </div>
                <div class="col-md-6">
                  <label for="" class="wrc__label">Wallet address/Bank detail <span>*</span></label>
                  <input type="text" class="wrc__input form-control" placeholder="Enter Details" required>
                </div>
                <!-- <div class="usd_inputs d-none row-gap row"> -->
                  <div class="col-md-6 usd_inputs d-none">
                    <label for="" class="wrc__label">Account Name <span>*</span></label>
                    <input type="text" id="account_name" name="account_name" class="wrc__input form-control" placeholder="Enter Details" required>
                  </div>
                  <div class="col-md-6 usd_inputs d-none">
                    <label for="" class="wrc__label">Account Number <span>*</span></label>
                    <input type="text" id="account_no" name="account_no" class="wrc__input form-control" placeholder="Enter Details" required>
                  </div>
                  <div class="col-md-12 usd_inputs d-none">
                    <label for="" class="wrc__label">Routing Number <span>*</span></label>
                    <input type="text" id="routing_no" name="routing_no" class="wrc__input form-control" placeholder="Enter Details" required>
                  </div>
                <!-- </div> -->
                <div class="col-12">
                  <label for="" class="wrc__label">Message</label>
                  <textarea type="text" class="wrc__input form-control wrc__select--textarea" placeholder="Message"
                    required></textarea>
                </div>
                <button class="flex-a wrc__btn">Submit</button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card withdrawal-req-card">
            <p class="withdrawal-req-card__para">
              <span> Note! </span>
              Crypto deposit/withdrawals are charged a 2.5% fee this is the cost of conversion when moving funds from
              your trading account. DO NOT DEPOSIT LESS THAN $25.00 USD to any crypto otherwise your funds will be lost.
            </p>
            <div class="withdrawal-req-card__row">
              <span>Info: </span> Withdrawal
            </div>
            <div class="withdrawal-req-card__row">
              <span>Method: </span> <span id="method"></span>
            </div>
            <div class="withdrawal-req-card__row">
              <span>Method Details: </span> <span id="methodDetails"></span>
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>
  <?php echo view("/home/new-footer-scripts"); ?>
  <script>
    $(document).ready(function() {
      const selectCurrency = $(".selectCurrency");
      const selectPayment = $(".selectPayment");
      const formControls = $(".afterSelect .form-control");
      const submitBtn = $(".wrc__btn");
      const error = $(".error");

      function checkSelections() {
        if (selectCurrency.val() && selectPayment.val()) {
          formControls.prop("disabled", false);
          submitBtn.prop("disabled", false);
        } else {
          formControls.prop("disabled", true);
          submitBtn.prop("disabled", true);
          formControls.click(function() {
            if (selectCurrency.val() === "" || selectPayment.val() === "") {
              error.removeClass("d-none");
              setTimeout(function() {
                error.addClass("d-none");
              }, 2000);
            }
          })
        }
      }

      selectCurrency.change(function() {
        const currencyValue = $(this).val();
        const $cryptoOptions = $(".forCryptoSelect");
        const $usdOptions = $(".forUSDTselect");
        const $usd_inputs = $(".usd_inputs");

        $("#method").text($(this).find('option:selected').text());
        $("#methodDetails").html("");
        
        if (currencyValue === "1") {
          $cryptoOptions.addClass("d-none").removeClass("d-block");
          $usdOptions.removeClass("d-none").addClass("d-block");
          $usd_inputs.removeClass("d-none");
          
        } else if (currencyValue === "2") {
          $usdOptions.addClass("d-none").removeClass("d-block");
          $usd_inputs.addClass("d-none");
          $cryptoOptions.removeClass("d-none").addClass("d-block");
        } else {
          $cryptoOptions.addClass("d-none").removeClass("d-block");
          $usdOptions.addClass("d-none").removeClass("d-block");
          $usd_inputs.addClass("d-none");
        }

        checkSelections();
      });

      selectPayment.change(function() {
        $("#methodDetails").text($(this).find('option:selected').text());
        checkSelections();
      });

      formControls.add(submitBtn).on("focus click", function() {
        if (selectCurrency.val() === "" || selectPayment.val() === "") {
          error.removeClass("d-none");
          setTimeout(function() {
            error.addClass("d-none");
          }, 2000);
        }
      });
    });
  </script>
</body>

</html>