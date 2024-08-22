$(document).ready(function () {
    let base_url = $('#base').val();
    let uid = $('#us_id').val();

    /* Send the data using post */

    let posting = $.post(base_url + "/home/sendOtp", {
        userid: uid,
    });

    /* Put the results in a div */
    posting.done(function (data) {
        let response = JSON.parse(data);
        // console.log(response);
        // if (response['status'] == 'false') {
        //     jQuery("#loginMessage").text(response['message']);
        // } else {
        //     window.location.replace(response);
        // }
    });
});

var intervel_id;

function startTimer(duration, display) {
    var timer = duration, seconds;
    intervel_id = setInterval(function () {
        seconds = parseInt(timer % 60, 10);
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = seconds;

        if (--timer < 0) {
            // timer = duration;
            $("#time").hide();
            $('#resendDiv').show();
        }else{
            $("#time").show();
        }
    }, 1000); 

}

window.onload = function () {
    $('#resendDiv').hide();
    var seconds = 60,
        display = document.querySelector('#time');
    startTimer(seconds, display);
};
$("#resendCode").click(function (e) {

    // console.log("hgfth")
    $("#resendCode").css("color", "#7A8489");
    $('thelink').addClass('disabled');
    let base_url = $('#base').val();
    let uid = $('#us_id').val();

    /* stop form from submitting normally */
    e.preventDefault();
    // console.log('hello');
    /* get some values from elements on the page: */

    /* Send the data using post */

    let posting = $.post(base_url + "/home/sendOtp", {
        userid: uid,
    });
    clearInterval(intervel_id);
    $('#resendDiv').hide();
    var seconds = 60,
        display = document.querySelector('#time');
    startTimer(seconds, display);
    /* Put the results in a div */
    posting.done(function (data) {
        // $("#resendCode").css("color", "#476FC5");
        $('#clickElement').on('click');
        // let response = JSON.parse(data);
        // console.log(response);

    });
});

