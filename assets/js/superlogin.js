$("#loginFormSuperAdmin").submit(function (event) {

    let base_url = $('#baseu').val();
    /* stop form from submitting normally */
    event.preventDefault();

    /* get some values from elements on the page: */
    let $form = $(this),

        useremail = $form.find('input[name="useremailAddress"]').val(),
        email = $form.find('input[name="emailAddress"]').val(),
        password = $form.find('input[name="password"]').val();

    console.log(password);

    /* Send the data using post */
    let posting = $.post(base_url + "/home/superAdminverify", {
        useremailAddress: useremail,
        emailaddress: email,
        password: password
    });
    /* Put the results in a div */
    posting.done(function (data) {
        let response = JSON.parse(data);
        if (response['status'] == 'false') {
            jQuery("#loginMessage").text(response['message']);
        } else {
            window.location.replace(response);
        }
    });
});