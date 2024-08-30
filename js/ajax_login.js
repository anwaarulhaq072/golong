/* attach a submit handler to the form */
$("#loginForm").submit(function (event) {
  let base_url = $("#base").val();
  /* stop form from submitting normally */
  event.preventDefault();

  /* get some values from elements on the page: */
  let $form = $(this),
    email = $form.find('input[name="emailAddress"]').val(),
    password = $form.find('input[name="password"]').val();

  /* Send the data using post */
  let posting = $.post(base_url + "/home/verify", {
    emailaddress: email,
    password: password,
  });
  /* Put the results in a div */
  posting.done(function (data) {
    let response = JSON.parse(data);
    if (response["status"] == "false") {
      jQuery("#loginMessage").text(response["message"]);
    } else {
      window.location.replace(response);
    }
  });
});

$("#otpForm").submit(function (event) {
  let base_url = $("#base").val();
  let uid = $("#us_id").val();

  /* stop form from submitting normally */
  event.preventDefault();
  // console.log('hello');
  /* get some values from elements on the page: */
  let $form = $(this),
    password = $form.find('input[name="code"]').val();

  /* Send the data using post */

  let posting = $.post(base_url + "/home/otpVerify", {
    code: password,
    userid: uid,
  });

  /* Put the results in a div */
  posting.done(function (data) {
    let response = JSON.parse(data);
    // console.log(response);
    if (response["status"] == "false") {
      jQuery("#loginMessage").text(response["message"]);
    } else {
      window.location.replace(response);
    }
  });
});

/* SignUp Form Email Check and if ok then save in database */
/* attach a submit handler to the form */
$("#signupForm").submit(function (event) {
  /* stop form from submitting normally */
  $("#submit_create_user_btn").prop("disabled", true);
  let base_url = $("#base").val();
  let role = $("#role :selected").val();
  event.preventDefault();
  let $form = $(this),
    firstName = $form.find('input[name="firstName"]').val(),
    lastName = $form.find('input[name="lastName"]').val(),
    email = $form.find('input[name="emailAddress"]').val(),
    phone = $form.find('input[name="phoneNumber"]').val();
  let posting = $.post(base_url + "/home/saveSignupData", {
    firstname: firstName,
    lastname: lastName,
    inputEmail4: email,
    phone: phone,
    userTypeId: role,
  });

  posting.done(function (data) {
    jQuery("#passwordNotMatch").text("");
    let response = JSON.parse(data);
    if (response["status"] == "false") {
      jQuery("#signupMessage").text(response["message"]);
      $("#warning_box").show();
      $("#warning_box").fadeOut(8000);
      $("#submit_create_user_btn").prop("disabled", false);
    } else {
      window.location.replace(response);
    }
  });
});


$("#changepassword").submit(function (event) {
  event.preventDefault();
  jQuery("#passmatch").text("");
  let password_verify = true;
  var string1 = $("#newpassword").val();
  var string2 = $("#confirmpassword").val();
  console.log(string1, string2);
  
  if (string1 != string2) {
        password_verify = false;
  }
  if (password_verify) {
    let base_url = $("#base").val();
    event.preventDefault();
    let $form = $(this),
      id = $form.find('input[name="id"]').val(),
      oldpassword = $form.find('input[name="oldpassword"]').val(),
      password = $form.find('input[name="newpassword"]').val();
      console.log($form);
    let posting = $.post(base_url + "/home/changePassword", {
      id: id,
      oldpassword: oldpassword,
      password: password,
    });

    posting.done(function (data) {
      jQuery("#passwordNotMatch").text("");
      let response = JSON.parse(data);
      console.log(response);
      if (response["status"] == "false") {
        jQuery("#oldnotmatch").text(response["message"]);
      } else {
        window.location.replace(response);
      }
    });
  } else {
    jQuery("#passmatch").text("Those passwords didn’t match... Try again.");
  }
});

$("#full-screen-loader").hide();
/* attach a submit handler to the form */
$("#loginForm").submit(function (event) {
  let base_url = $("#base").val();
  let $form = $(this),
    email = $form.find('input[name="emailAddress"]').val(),
    password = $form.find('input[name="password"]').val();
  event.preventDefault();
  /* stop form from submitting normally */

  let posting = $.post(base_url + "/home/verify", {
    emailaddress: email,
    password: password,
  });
  posting.done(function (data) {
    let response = JSON.parse(data);
    if (response["status"] == "false") {
      jQuery("#loginMessage").text(response["message"]);
    } else {
      window.location.replace(response);
    }
  });
  /* get some values from elements on the page: */

  /* Send the data using post */
});

$("#profileSection").hide();
$("#passwordSection").hide();

$("#profileBtn").click(function (event) {
  $("#profileSection").toggle();
});

$("#passBtn").click(function (event) {
  $("#passwordSection").toggle();
});
