$("#forgetForm").submit(function(event) {

    event.preventDefault();
    let baseURL = $("#base").val();
    let email = $("#emailaddress").val();
    // console.log(baseURL, email)

    let posting = $.post(baseURL+"/home/submitForgetPassword", {
        email: email
    });

    posting.done(function(data) {
      jQuery("#forgetMessage").text("");
        let response = JSON.parse(data);
        if(response['status'] == 'false'){
            jQuery("#forgetMessage").text(response['message']);
        }else{
            jQuery("#forgetSuccessMessage").text(response['message']);
        }
    });

});

$("#newPasswordForm").submit(function(event) {

    event.preventDefault();
    jQuery("#passmatch").text("");
    let baseURL = $("#base").val();
    let password_verify = true;
    let string1 = $("#password").val();
    let string2 = $("#confirmPassword").val();
    if(string1.length == string2.length){
        for( i=0; i<string1.length; i++) {
        if( string1.charAt(i) != string2.charAt(i)){
            password_verify=false;
        }
        }
    }else{
        password_verify=false;
    }
    if(password_verify){
        let id = $("#userid").val();
        let posting = $.post(baseURL+"/home/updatePassword", {
            id:id,
            password: string1
          });
      
          posting.done(function(data) {
            jQuery("#passwordNotMatch").text("");
              let response = JSON.parse(data);
                window.location.replace(response);
          });
    }else{
        jQuery("#passwordNotMatch").text("Those passwords didn’t match... Try again.");
      }

});