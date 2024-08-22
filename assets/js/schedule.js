$(document).ready(function () {
    let addButton = $('#addMoreBtn'); //Add button selector
    // let d = new Date();
    // let dateformate =  (d.getMonth()+1) + '/' + d.getDate()+ '/'+d.getFullYear();

    // var fieldHTML = '<div><input type="text" name="input" value=""/></div>'; //New input field html 

    //Once add button is clicked
    $(addButton).click(function () {
        //Check maximum number of input fields
        //Increment field counter
        // $(wrapper).append(HTMLBody); //Add field html
        let oldDate = $('.cover').last().find("input[type='date'][name='date']").val();
        for (let i = 1; i < 11; i++) {
            let HTMLBody = '<div class="row cover">' +
                '<div class="mb-3 col-md-4">' +
                '<select name="action" id="dropDown" class="form-select amt_option" required>' +
                '<option value="profit">Profit</option>' +
                '<option value="loss">Loss</option>' +
                '<option value="0">Swing</option>' +
                '</select>' +
                '</div>' +
                '<div class="mb-3 col-md-3">' +
                '<input type="number" placeholder="Amount" step="0.01" class="form-control fix_value" name="amount" value="">' +
                '</div>' +
                '<div class="mb-3 col-md-3">' +
                '<input type="date" value="' + moment(oldDate).add(i, 'days').format('YYYY-MM-DD') + '" class="form-control" name="date" readonly>' +
                '</div>' +
                '</div>';
            $('.cover').last().append().after(HTMLBody);
        }
        $(".amt_option").on("change", function () {
            //Getting Value
            var Value = $(this).val();

            //Setting Value
            if (Value == '0') {
                $(this).parent().parent().find("input[type = 'number'][name = 'amount']").val(Value);
                $(this).parent().parent().find("input[type = 'number'][name = 'amount']").prop('readonly', true);
            } else {
                $(this).parent().parent().find("input[type = 'number'][name = 'amount']").val('');
                $(this).parent().parent().find("input[type = 'number'][name = 'amount']").prop('readonly', false);
            }
        });

    });
});

$(".amt_option").on("change", function () {
    //Getting Value
    var Value = $(this).val();

    //Setting Value
    if (Value == '0') {
        $(this).parent().parent().find("input[type = 'number'][name = 'amount']").val(Value);
        $(this).parent().parent().find("input[type = 'number'][name = 'amount']").prop('readonly', true);
    } else {
        $(this).parent().parent().find("input[type = 'number'][name = 'amount']").val('');
        $(this).parent().parent().find("input[type = 'number'][name = 'amount']").prop('readonly', false);
    }
});


$("#submitSchedule").submit(function (event) {

    event.preventDefault();
    let itemArray = {}; // Array to contain array of fruits
    // will get all children
    var totalRows = $(".cover").length;
    // console.log(totalRows);
    // console.log($(".cover:eq(9)").find("input[type='date'][name='date']").val());
    // console.log($(".cover:eq(9)").find("select[name='action']").val());
    // console.log($(".cover:eq(0)").find("input[type = 'number'][name = 'amount']").val());
    let id = $('#id').val();
    itemArray.id = id;
    itemArray.item = [];
    let base_url = $('#baseurl').val();
    // loop over them
    for (let index = 0; index < totalRows; index++) {
        if ($(".cover:eq(" + index + ")").find("input[type='number'][name='amount']").val() !== '') {
            let date = $(".cover:eq(" + index + ")").find("input[type='date'][name='date']").val();
            let amount = $(".cover:eq(" + index + ")").find("input[type='number'][name='amount']").val();
            let action = $(".cover:eq(" + index + ")").find("select[name='action']").find(":selected").text();
            let inputValues = {
                date: date,
                amount: amount,
                action: action
            };
            itemArray.item.push(inputValues);
        }
    }
    console.log(itemArray);
    // console.log(JSON.stringify(itemArray));
    let posting = $.post(base_url + "/admin/addScheduleProfitLoss", {
        data: {
            json: JSON.stringify(itemArray)
        },
        dataType: "json",
        contentType: "application/json"
    });

    posting.done(function (data) {
        let response = JSON.parse(data);
        window.location.replace(response);

    });


});
