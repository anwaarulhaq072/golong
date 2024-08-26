$(document).ready(function() {
    $('.edit_btn').click(function() {
        // Get the values from the table row
        let type = $(this).closest('tr').find('td:nth-child(1)').text().trim();
        let date = $(this).closest('tr').find('td:nth-child(2)').text().trim();
        let amount = $(this).closest('tr').find('td:nth-child(3)').text().trim().replace('Scheduled', '');
        let profit_id = $(this).val();
        console.log(profit_id, type, date, amount);

        // Format the date using moment.js
        var formattedDate = moment(date, 'MMM D, YYYY').format('YYYY-MM-DD');

        // Populate the modal with the selected transaction details
        $('#editModalForm').find('select[name=action]').val(type);
        $('#editModalForm').find('input[name=amount]').val(parseFloat(amount.replace('$', '').replace(',', '')));
        $('#editModalForm').find('input[name=date]').val(formattedDate);
        $('#editModalForm').find('input[name=profit_id]').val(profit_id);

        // Update the form action URL
        var action = $('#editModalForm').attr("action");
        $('#editModalForm').attr("action", action + profit_id);
    });
});
let icon = {
    success: '<span class="material-symbols-outlined">task_alt</span>',
    danger: '<span class="material-symbols-outlined">error</span>',
    warning: '<span class="material-symbols-outlined">warning</span>',
    info: '<span class="material-symbols-outlined">info</span>',
  };

  const showToast = (
    message = "Sample Message",
    toastType = "info",
    duration = 5000) => {

    if (
      !Object.keys(icon).includes(toastType))
      toastType = "info";

    let box = document.createElement("div");
    box.classList.add(
      "toast", `toast-${toastType}`);
    box.innerHTML = ` <div class="toast-content-wrapper">
                  <div class="toast-icon">
                  ${icon[toastType]}
                  </div>
                  <div class="toast-message">${message}</div>
                  <div class="toast-progress"></div>
                  </div>`;
    duration = duration || 5000;

    box.querySelector(".toast-progress").style.animationDuration =
      `${duration / 5000}s`;

    let toastAlready =
      document.body.querySelector(".toast");

    if (toastAlready) {
      toastAlready.remove();
    }
    console.log(toastAlready);
    document.body.appendChild(box)
    // $('toast').addClass('d-block');
  };

$("#editProfileModalform").submit(function (e) {


    e.preventDefault();
    let userid = $('#first').val();
    let base_url = $('#base_url').val();
    let firstName = $('#name').val();
    let initialInvestment = $('#initialInvestment').val();
    let phone = $('#phone').val();
    let email = $('#email').val();


    console.log(email);

    $.ajax({
        type: "POST",
        url: base_url + "/admin/editProfile",
        data: {
            userid: userid,
            firstName: firstName,
            initialInvestment: initialInvestment,
            phone: phone,
            email: email
        },
    }).done(function (url) {

        let response = JSON.parse(url);
        console.log(response);
        if (response['status'] == false) {
            showToast(response['message'], "danger", 5000);
            jQuery(".profile_edit__para_message").text(response['message']);
        } else {
            showToast("Profile Updated Successfully", "success", 5000);
            window.location.replace(response);
        }


    });

});



$('.edit_payout_button').click(function () {
    // Get the values from the table row
    let id = $(this).closest('tr').find('td:nth-child(1)').text().trim();
    let amount = $(this).closest('tr').find('td:nth-child(2)').text().trim();
    let payoutDate = $(this).closest('tr').find('td:nth-child(3)').text().trim();

    // Format the payout date using moment.js
    var formattedDate = moment(payoutDate).format('YYYY-MM-DD');

    // Populate the modal with the selected payout details
    $('#editPayoutmodal').find('input[name=amount]').val(parseFloat(amount.replace('$', '')));
    $('#editPayoutmodal').find('input[name=payoutdate]').val(formattedDate);

    // Update the form action URL
    var currentAction = $('#editModalpayout').attr("action");
    $('#editModalpayout').attr("action", currentAction + id);
});

$('.delete_btn_payout').click(function () {
    var _href = $('#delYesPayout').attr("href");
    $('#delYesPayout').attr("href", _href + $(this).val());
});
$('.delete_btn_notification').click(function () {
    // var _href = $(this).val();
    $('#delYesNotification').attr("href", $(this).val());
});
$('.delete_btn_profit').click(function () {
    var _href = $('#delYesProfit').attr("href");
    $('#delYesProfit').attr("href", _href + $(this).val());
});
$('.delete_btn_user').click(function () {
    var _href = $('#delYes_user').attr("href");
    $('#delYes_user').attr("href", _href + $(this).val());
});


$("#dropDown").on("change", function () {
    //Getting Value
    var Value = $("#dropDown").val();
    //Setting Value
    $("#fix_value").val(Value);
    if ($("#dropDown").val() == '0') {
        $('#fix_value').prop('readonly', true);
    } else {
        $('#fix_value').prop('readonly', false);
    }
});



$('#payout_per').keyup(function () {
    if ($(this).val() > 100) {
        jQuery("#payput_Percentage_Message").text(' *Please enter value between 0 - 100 ');
        $('#updateBtn').prop('disabled', true);
    } else if ($(this).val() < 0) {
        jQuery("#payput_Percentage_Message").text(' *Please enter value between 0 - 100 ');
        $('#updateBtn').prop('disabled', true);
    }
    else {
        jQuery("#payput_Percentage_Message").text('');
        $('#updateBtn').prop('disabled', false);
    }
});


