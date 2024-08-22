$('.edit_btn').click(function () {
    jQuery("#Message").text('');
    let first = $(this).parent().parent().find('td:nth-child(1)').text();
    let second = $(this).parent().parent().find('td:nth-child(2)').text();
    let third = $(this).parent().parent().find('td:nth-child(3)').text();
    third = third.replace('Scheduled', '');
    let profit_id = $(this).val();
    var format_two = moment(third).format('YYYY-MM-DD');
    jQuery('#editModalForm').find('select[name=action] option[value=' + first + ']').attr('selected', true);
    jQuery('#editModalForm').find('input[name=amount]').attr("value", parseFloat(second.replace('$', '')));
    jQuery('#editModalForm').find('input[name=date]').val(format_two);
    jQuery('#editModalForm').find('input[name=profit_id]').val(profit_id);
    var action = $('#editModalForm').attr("action");
    $('#editModalForm').attr("action", action + $(this).val());
});

$("#editProfileModalform").submit(function (e) {


    e.preventDefault();
    let userid = $('#first').val();
    let base_url = $('#base_url').val();

    let firstName = $('#name').val();
    let lastName = $('#last').val();
    let phone = $('#phone').val();
    let email = $('#email').val();


    console.log(email);

    $.ajax({
        type: "POST",
        url: base_url + "/admin/editProfile",
        data: {
            userid: userid,
            firstName: firstName,
            lastName: lastName,
            phone: phone,
            email: email
        },
    }).done(function (url) {

        let response = JSON.parse(url);
        console.log(response);
        if (response['status'] == false) {
            jQuery("#showMessage").text(response['message']);
        } else {
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

$('.delete_btn').click(function () {
    var _href = $('#delYesProfit').attr("href");
    $('#delYesProfit').attr("href", _href + $(this).val());
    console.log($(this).val())
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


