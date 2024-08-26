$("#formProfitLoss").submit(function (e) {


    e.preventDefault();
    let id = $('#id').val();
    let base_url = $('#baseurl').val();

    let $form = $(this),
        amount = $form.find("input[type = 'number'][name = 'amount']").val();
    action = $form.find("select[name='action']").find(":selected").text();
    date = $('#profit-loss').val();

    base_url = $('#baseurl').val();

    $.ajax({
        type: "POST",
        url: base_url + "/admin/addProfitLoss",
        data: {
            id: id,
            date: date,
            amount: amount,
            action: action,

        },
    }).done(function (url) {

        let response = JSON.parse(url);
        if (response['status'] == true) {
            jQuery("#profitMessage").text(response['message']);
        } else {
            window.location.replace(response);
        }


    });

});
$("#editModalForm").submit(function (e) {


    e.preventDefault();
    let userid = $('#user_id').val();
    let base_url = $('#baseurl').val();
    let profit_id = $('#profit_id').val();

    let $form = $(this),
        amount = $form.find("input[type = 'number'][name = 'amount']").val(),
        action = $form.find("select[name='action']").find(":selected").text(),
        date = $form.find("input[type='date'][name='date']").val();

    // console.log(action);

    $.ajax({
        type: "POST",
        url: base_url + "/admin/editProfitLoss",
        data: {
            userid: userid,
            date: date,
            amount: amount,
            action: action,
            profit_id: profit_id
        },
    }).done(function (url) {

        let response = JSON.parse(url);
        console.log(response);
        if (response['status'] == false) {
            jQuery("#Message").text(response['message']);
        } else {
            window.location.replace(response);
        }


    });

});



