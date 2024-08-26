<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Update Bulk Records - <?php echo APP_NAME ?></title>
  <link
    href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
    rel="stylesheet">
    <?php echo view("/home/new-header-links"); ?>
</head>

<body>
  <div class="app_wrapper">

  <?php echo view("/home/left-sidebar-new"); ?>

    <main class="main">
      <h2 class="notification-card__hdng notification-card__hdng--adduser">Update Bulk Records</h2>
      <div class="card updateBulkCard">
        <form class="bulkrecordFrom" id="submitBulkUpdate" method="POST">
        <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
          <div class="row bulkrow">
          <div class="alert alert-primary" role="alert" id="message" style="padding: 5px;">
                Some Records already exist for this date. Instead of creating new records, they will be updated in the database.
            </div>
            <div class="alert alert-success text-center" id="success_bar">
                <strong>All records updated successfully</strong>
            </div>                 
            <div class="col-3">
              <input type="date" placeholder="DD/MM/YY" value="" class="form-control profile-edit__input" id="dateRangeSelector" name="date">
            </div>
            <div class="col-3">
              <select name="action1" id="dropDownforall" onchange="dropdownvalue()" class="form-control profile-edit__input form-select amt_option_for_all">
                <option value="" selected disabled>Add profit or loss</option>
                <option value="Profit">Profit</option>
                <option value="Loss">Loss</option>
                <option value="Swing">swing</option>
              </select>
            </div>
            <div class="col-6">
              <input type="number" placeholder="Enter Percentage for all fields" value="" class="form-control profile-edit__input allpercentage" name="allpercentage" step="any" id="allpercentage" onkeyup="Change_all_percentage()">
            </div>
          </div>
          <?php
            for ($j = 0; $j < sizeof($bulkData); $j++) :
         ?>
          <div class="row bulkrow cover">
          <input type="hidden" id="id<?php echo $j ?>" name="id" value="<?php echo $bulkData[$j]['id']; ?>">
                <div class="col-3">
                <input type="text" placeholder="User Name" name="name" value="<?php echo $bulkData[$j]['firstName'] . " " . $bulkData[$j]['lastName']; ?>" class="form-control profile-edit__input name" readonly>
                </div>
                <div class="col-3">
                <select name="action" id="dropDown" class="form-control profile-edit__input form-select plselect amt_option" required>
                    <option value="" selected disabled>Add profit or loss</option>
                    <option value="Profit"
                    <?= $bulkData[$j]['TYPE'] == 'Profit' ? ' selected="selected"' : ''; ?>>Profit</option>
                    <option value="Loss"
                    <?= $bulkData[$j]['TYPE'] == 'Loss' ? ' selected="selected"' : ''; ?>>Loss</option>
                    <option value="Swing"
                    <?= $bulkData[$j]['TYPE'] == 'Swing' ? ' selected="selected"' : ''; ?>>swing</option>
                </select>
                </div>
                <div class="col-3">
                <input type="number" placeholder="Amount" step="any" class="form-control profile-edit__input percentage fix_value" name="amount" id="amountfield<?php echo $j ?>" value="<?php echo $bulkData[$j]['amount']; ?>"<?php if ($bulkData[$j]['TYPE'] == 'Swing') :?>readonly<?php endif ?>>
                </div>
                <div class="col-3">
                <input type="number" placeholder="Percentage" step="any" class="form-control profile-edit__input number percentage" min="0" name="percentage" value="<?php echo $bulkData[$j]['percentage']; ?>"<?php if ($bulkData[$j]['TYPE'] == 'Swing') :?>readonly<?php endif ?>>
                </div>
            </div>
          <?php endfor; ?>
          </div>
          <div class="col-md-12 mt-4" style="text-align: center;">
                <button type="submit" id="submit" class="flex-a w-fit from-btn from-btn--full" style="padding: 7px 57px; background-color: #0073B6;">Update Now</button>
          </div>
        </form>
      </div>
    </main>
  </div>
  <?php echo view("/home/new-footer-scripts"); ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/bulkUpdate.js"></script>
    <script>
        $('#message').hide();
        $('#success_bar').hide();
        $('#full-screen-loader').hide();
        function Change_all_percentage() {
           var r = $('#allpercentage').val();
           $('.percentage').val(r);
        }
        function dropdownvalue() {
           var value = $('#dropDownforall').val();
           $('.amt_option').val(value);
        }
    </script>
  <script>
    // $(document).ready(function () {
    //   const selectBulkPL = $("#plSelect");
    //   const singleUserPL = $(".plselect");
    //   const numberForAll = $("#numberFolAll");
    //   const numberForSingle = $(".number");
    //   const percentage = $(".percentage");

    //   function selectProfitLossForAll() {
    //     const selectedValue = selectBulkPL.val();
    //     if (selectedValue === 'profit' || selectedValue === 'loss') {
    //       $(singleUserPL).val(selectedValue);
    //     } else if (selectedValue === 'swing') {
    //       numberForAll.val("0");
    //       numberForSingle.each(function () {
    //         $(this).val("0");
    //       });
    //       percentage.each(function () {
    //         $(this).val("0");
    //       });
    //     }
    //   }

    //   function addProfitLossForAll() {
    //     const getValueForAll = parseFloat(numberForAll.val());
    //     numberForSingle.each(function () {
    //       $(this).val(getValueForAll);
    //       const calculatedPercentage = 200 * getValueForAll;
    //       $(this).closest('.bulkrow').find('.percentage').val(calculatedPercentage);
    //     });
    //   }

    //   function updateSingleInput(singleElement) {
    //     const singleValue = parseFloat(singleElement.val());
    //     const calculatedPercentage = 200 * singleValue;
    //     singleElement.closest('.bulkrow').find('.percentage').val(calculatedPercentage);
    //   }

    //   function handleSingleRowSwing(singleElement) {
    //     const parentRow = singleElement.closest('.bulkrow');
    //     parentRow.find('.number').val("0");
    //     parentRow.find('.percentage').val("0");
    //   }

    //   $(selectBulkPL).on('change', function () {
    //     if ($(this).val()) {
    //       $(this).addClass('value');
    //       selectProfitLossForAll();
    //     } else {
    //       $(this).removeClass('value');
    //     }
    //   });

    //   $(singleUserPL).on('change', function () {
    //     if ($(this).val() === 'swing') {
    //       handleSingleRowSwing($(this));
    //     } else if ($(this).val()) {
    //       $(this).addClass('value');
    //     } else {
    //       $(this).removeClass('value');
    //     }
    //   });

    //   $(numberForAll).on("change", function () {
    //     addProfitLossForAll();
    //   });

    //   $(numberForSingle).on("change", function () {
    //     updateSingleInput($(this));
    //   });

    //   new Datepicker("#bulkDate");
    // });


  </script>
</body>

</html>