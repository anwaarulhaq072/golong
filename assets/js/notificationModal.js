
// $(window).on('scroll', function () {
//     //  console.log("Hello world!");
//     //  $('#centermodal').modal('show');
//     notificationcount();

// });

$('#notificationIcon').click(function () {
    $('#notificationcount').hide();
    x = 0 ;
    let baseUrl = $('#base_url').val();
    let userid = $('#userid').val();
    console.log("Hello world! x = ",baseUrl);
    let posting = $.post(baseUrl + "/admin/updateNotificationStatus", {
        id: userid
    });
});

$("#adminNotificationIcon").click(function () {
    $('#alert_counter').hide();
    // console.log("Hello world! x = ",x);
    y = 0 ;
    let baseUrl = $('.base_url').val();
    let userid = $('#adminid').val();
    let posting = $.post(baseUrl + "/admin/updateAlertStatus", {
        id: userid
    });
});