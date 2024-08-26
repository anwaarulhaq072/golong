$(document).ready(function () {
  var totalRows = $(".cover").length;
  var count = 0;
  for (let index = 0; index < totalRows; index++) {
    if (
      $(".cover:eq(" + index + ")")
        .find("input[type='number'][name='amount']")
        .val() !== ""
    ) {
      let amount = $(".cover:eq(" + index + ")")
        .find("input[type='number'][name='amount']")
        .val();
      count++;
      if (amount.length > 0) {
        $("#message").show();
      }
    }
    if (count == 0) {
      $("#message").hide();
    }
  }
});

$(".amt_option").on("change", function () {
  //Getting Value
  var Value = $(this).val();

  //Setting Value
  if (Value == "Swing") {
    $(this)
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'amount']")
      .val("0");
    $(this)
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'percentage']")
      .val("0");
    $(this)
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'percentage']")
      .prop("readonly", true);
    $(this)
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'amount']")
      .prop("readonly", true);
  } else {
    $(this)
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'amount']")
      .val("");
    $(this)
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'percentage']")
      .val("");
    $(this)
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'percentage']")
      .prop("readonly", false);
    $(this)
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'amount']")
      .prop("readonly", false);
  }
});
$(".amt_option_for_all").on("change", function () {
  //Getting Value
  var Value = $(this).val();
  //Setting Value
  if (Value == "Swing") {
    $(".amt_option")
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'amount']")
      .val("0");
    $(".amt_option")
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'percentage']")
      .val("0");
    $(".amt_option")
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'percentage']")
      .prop("readonly", true);
    $(".amt_option_for_all")
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'allpercentage']")
      .val("0");
    $(".amt_option_for_all")
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'allpercentage']")
      .prop("readonly", true);
    $(".amt_option")
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'amount']")
      .prop("readonly", true);
  } else {
    $(".amt_option")
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'amount']")
      .val("");
    $(".amt_option")
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'percentage']")
      .val("");
    $(".amt_option")
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'percentage']")
      .prop("readonly", false);
    $(".amt_option_for_all")
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'allpercentage']")
      .prop("readonly", false);
    $(".amt_option")
      .parent()
      .parent()
      .find("input[type = 'number'][name = 'amount']")
      .prop("readonly", false);
  }
});

$(".percentage").on("keyup change", function () {
  //Getting Value
  let percentage = $(this).val();
  let amountField = $(this)
    .parent()
    .parent()
    .find("input[type = 'number'][name = 'amount']");
  let id = $(this)
    .parent()
    .parent()
    .find("input[type = 'hidden'][name = 'id']")
    .val();
  // console.log(percentage,id);
  let base_url = $("#baseurl").val();
  let posting = $.post(base_url + "/admin/getUserAmount", {
    data: {
      json: {
        percentage: percentage,
        userId: id,
      },
    },
    dataType: "json",
    contentType: "application/json",
  });

  posting.done(function (res) {
    let response = JSON.parse(res);
    console.log(response);
    amountField.val(
      parseFloat((parseFloat(percentage) * parseFloat(response)) / 100).toFixed(
        2
      )
    );
  });
});
$(".allpercentage").on("keyup change", function () {
  // $('#full-screen-loader').show();
  for (let i = 0; i < $(".percentage").length; i++) {
    cal_percentage($("#id" + i).val(), i);
  }
  // $('#full-screen-loader').fadeOut(2000);
});

function cal_percentage(id, field_id) {
  console.log(id, field_id);
  let percentage = $(".allpercentage").val();
  let base_url = $("#baseurl").val();
  let amountField = $("#amountfield" + field_id);
  let posting = $.post(base_url + "/admin/getUserAmount", {
    data: {
      json: {
        percentage: percentage,
        userId: id,
      },
    },
    dataType: "json",
    contentType: "application/json",
  });

  posting.done(function (res) {
    let response = JSON.parse(res);
    amountField.val(
      parseFloat((parseFloat(percentage) * parseFloat(response)) / 100).toFixed(
        2
      )
    );
  });
}
// $(".fix_value").on("click", function () {
//     //Getting Value
//     var totalRows = $(".cover").length;
//     for (let index = 0; index < totalRows; index++) {
//         if ($(".cover:eq(" + index + ")").find("input[type='number'][name='amount']").val() !== '') {
//             let amount = $(".cover:eq(" + index + ")").find("input[type='number'][name='amount']").val();
//             let action = $(".cover:eq(" + index + ")").find("select[name='action']").find(":selected").text();
//             if (amount == '0' && action == 'Swing') {
//                 $(".cover:eq(" + index + ")").find("input[type = 'number'][name = 'amount']").prop('readonly', true);
//             } else {
//                 $(".cover:eq(" + index + ")").find("input[type = 'number'][name = 'amount']").prop('readonly', false);
//             }
//         }
//     }

// });
// $("#submitBulkUpdate").submit(function (event) {
    let icon = {
        success: '<span class="material-symbols-outlined">Success</span>',
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
document
  .getElementById("submitBulkUpdate")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way

    let itemArray = { item: [] }; // Initialize an object to store the collected data
    let base_url = $("#baseurl").val(); // Get the base URL
    let date = $("#dateRangeSelector").val(); // Get the selected date
    let totalRows = $(".cover").length; // Get the number of rows

    // Loop over each row
    for (let index = 0; index < totalRows; index++) {
      // Check if the amount field is not empty
      if (
        $(".cover:eq(" + index + ")")
          .find("input[type='number'][name='amount']")
          .val() !== ""
      ) {
        // Collect the necessary values from the current row
        let amount = $(".cover:eq(" + index + ")")
          .find("input[type='number'][name='amount']")
          .val();
        let percentage = $(".cover:eq(" + index + ")")
          .find("input[type='number'][name='percentage']")
          .val();
        let id = $(".cover:eq(" + index + ")")
          .find("input[type='hidden'][name='id']")
          .val();
        let action = $(".cover:eq(" + index + ")")
          .find("select[name='action']")
          .find(":selected")
          .val();

        // Create an object for the current row and push it to the item array
        let inputValues = {
          id: id,
          date: date,
          amount: amount,
          percentage: percentage,
          action: action,
        };
        itemArray.item.push(inputValues);
      }
    }

    // Output the collected data as a JSON string to the console
    console.log("Collected Data: ", JSON.stringify(itemArray));

    // You can also make an AJAX call here to send the itemArray data to the server if needed
    let posting = $.post(base_url + "/admin/addBulkUpdate", {
      data: {
        json: JSON.stringify(itemArray),
      },
      dataType: "json",
      contentType: "application/json",
    });

    posting.done(function (data) {
    //   showToast("Records are updated successfully", "success");
      showToast("Profile Updated Successfully", "success", 5000);
      $("#success_bar").show();
      $("#success_bar").fadeOut(5000);
      // $("#message").show();
      // $("#message").html('Records are updated successfully');
      //alert('Records are upated successfully');
      // let response = JSON.parse(data);
      // window.location.replace(response);
    });
  });

$("#dateRangeSelector").on("change", function () {
  $("#message").hide();
  $("#allpercentage").val("");
  let date = $("#dateRangeSelector").val();
  // console.log(date);
  let base_url = $("#baseurl").val();
  var totalRows = $(".cover").length;
  //loop over them

  let posting = $.post(base_url + "/admin/bulkUpdaterecord", {
    data: {
      date: date,
    },
    dataType: "json",
    contentType: "application/json",
  });

  posting.done(function (data) {
    var count = 0;
    let response = JSON.parse(data);
    for (let index = 0; index < totalRows; index++) {
      if (response["bulkData"][index]["amount"]) {
        count++;
      }
      $(".cover:eq(" + index + ")")
        .find("input[type='text'][name='name']")
        .val(
          response["bulkData"][index]["firstName"] +
            " " +
            response["bulkData"][index]["lastName"]
        );
      $(".cover:eq(" + index + ")")
        .find("input[type='number'][name='amount']")
        .val(response["bulkData"][index]["amount"]);
      $(".cover:eq(" + index + ")")
        .find("input[type='number'][name='percentage']")
        .val(response["bulkData"][index]["percentage"]);
      $(".cover:eq(" + index + ")")
        .find("input[type='hidden'][name='id']")
        .val(response["bulkData"][index]["id"]);
      if (response["bulkData"][index]["TYPE"] != null) {
        $(".cover:eq(" + index + ")")
          .find("#dropDown")
          .val(response["bulkData"][index]["TYPE"])
          .attr("selected", "selected");
        if (response["bulkData"][index]["TYPE"] == "Swing") {
          $(".cover:eq(" + index + ")")
            .find("input[type='number'][name='amount']")
            .prop("readonly", true);
          $(".cover:eq(" + index + ")")
            .find("input[type='number'][name='percentage']")
            .prop("readonly", true);
        }
      } else {
        $(".cover:eq(" + index + ")")
          .find("#dropDown")
          .val("Profit")
          .attr("selected", "selected");
      }
    }
    if (count > 0) {
      $("#message").show();
      // $("#message").html('Some Records already exist for this date, they will be updated in the database.');
    }
    // let HTMLBody = '<div class="row cover">' +
    //     '<div class="mb-3 col-md-3">' +
    //     '<input type="text" value="' + response['bulkData'][index]['firstName'] + " " + response['bulkData'][index]['lastName'] + '" class="form-control" name="name">' +
    //     '</div>' +
    //     '<div class="mb-3 col-md-4">' +
    //     '<select name="action" id="dropDown" class="form-select amt_option" required>' +
    //     '<option value="profit">Profit</option>' +
    //     '<option value="loss">Loss</option>' +
    //     '<option value="0">Swing</option>' +
    //     '</select>' +
    //     '</div>' +
    //     '<div class="mb-3 col-md-3">' +
    //     '<input type="number" placeholder="Amount" step="0.01" class="form-control fix_value" name="amount" value="' + response['bulkData'][index]['amount'] + '.">' +
    //     '</div>' +

    //     '</div>';
    // $('.bulkDataContainer').html(HTMLBody);
    console.log(response);
    // console.log(response['bulkData']['0']['TYPE']);
    //window.location.reload();
  });
});
