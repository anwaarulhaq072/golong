function notificationcount() {
    let baseUrl = $('#base_url').val();
    let userid = $('#userid').val();
    let posting = $.post(baseUrl + "/admin/notificationcount", {
        id: userid
    });
    posting.done(function (data) {
        let response = JSON.parse(data);
        if (response > 0) {
            $('#notificationcount').show();
        } else {
            $('#notificationcount').hide();
        }
        //console.log(response);

        $('#notificationcount').text(response);


    });
}
$(window).on('load', function () {
    // console.log("Hello world!");
    notificationcount();

});
// $(window).on('scroll', function () {
//     //  console.log("Hello world!");
//     //  $('#centermodal').modal('show');
//     notificationcount();

// });

$('#notificationIcon').click(function () {
    $('#notificationcount').hide();
    // console.log("Hello world!");
    let baseUrl = $('#base_url').val();
    let userid = $('#userid').val();
    let posting = $.post(baseUrl + "/admin/updateNotificationStatus", {
        id: userid
    });
});