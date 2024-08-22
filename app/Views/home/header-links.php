
 <!-- App favicon -->
 <link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/images/favicon.png">

<!-- App css -->
<link href="<?php echo base_url(); ?>/assets/css/config/default/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="<?php echo base_url(); ?>/assets/css/config/default/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />



<!-- plugin css -->
<link href="<?php echo base_url(); ?>/assets/css/config/default/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
<link href="<?php echo base_url(); ?>/assets/css/config/default/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />
<script src="https://www.gstatic.com/firebasejs/8.2.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.2.2/firebase-messaging.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<!-- icons -->
<link href="<?php echo base_url(); ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<script>
    const firebaseConfig = {
        apiKey: "AIzaSyCUm5YstkPOVFrTQc6o2hZapMoHIs1Xu8c",
        authDomain: "golong-a9f80.firebaseapp.com",
        projectId: "golong-a9f80",
        storageBucket: "golong-a9f80.appspot.com",
        messagingSenderId: "478342696383",
        appId: "1:478342696383:web:ecbd6ea04173185e0d250a",
        measurementId: "G-5Y2EDPRZ2M"
    };
    firebase.initializeApp(firebaseConfig);

    const fcm = firebase.messaging();
    fcm.getToken({
        vapidkey: 'BNCB1JiZQsmEfvRP9PJ0xyTMZ-pjkYK-X7apLpFOekF1iClIFQMTufbXy_YziRJ7AFkNNEqN8EgKLIETnbBvbF8' 
    }).then((token)=>{
        console.log('TOken: => ' , token)
         let posting = $.post('<?php echo base_url(); ?>' + "/home/update_device_token", {
              device_token: token,
            });
            /* Put the results in a div */
            posting.done(function (data) {
              let response = JSON.parse(data);
              console.log(response);
            });
    })
    let x = 0 ;
let y = 0 ; 
function notificationcount() {
    let baseUrl = $('.base_url').val();
    let userid = $('#userid').val();
    // console.log("URL "+baseUrl +" id"+userid) ;
    let posting = $.post(baseUrl + "/admin/notificationcount", {
        id: userid
    });
    posting.done(function (data) {
        let response = JSON.parse(data);
        x = response ;
        if(x==0){
            $('#notificationcount').hide();
        }
        console.log('x  = ' , x);
        console.log('response  = ' , response);
        fcm.onMessage((data)=>{
            console.log("Message " , data) ;
            var d = new Date();
            d = d.toString() ;
            d = d.split(" ") ;
            var e = "<a href='"+baseUrl+"/user/notifications' class='dropdown-item notify-item'>"
                +"<div class='notify-icon bg-dark'><i class='fe-bell noti-icon'></i></div>"
                +"<p class='notify-details'>"+data['data']['title']+
                "<small class='text-muted'>"+d[1]+' '+d[2]+', '+d[3]+"</small>"
                +"</p></a>"
            $(".noti-scroll .simplebar-content").prepend(e);
            x++ ;
            if(x!=0){
                $('#notificationcount').show();
                $('#notificationcount').text(x);
            }
        })
    });
}
function alertNotificationCount(){
    let baseUrl = $('.base_url').val();
    let userid = $('#adminid').val();
    // console.log("admin id " , userid) ;
    let posting = $.post(baseUrl + "/admin/alertnotificationcount", {
        id: userid
    });
    posting.done(function(data){
        let response = JSON.parse(data) ;
        y = response ;
        console.log("Admin Alert Response "  , response) ;
        console.log("Value of Y "  , y) ;
        if(response == 0){
            $('#alert_counter').hide();
        }
        fcm.onMessage((data)=>{
            console.log("Message " , data) ;
            var d = new Date();
            d = d.toString() ;
            d = d.split(" ") ;
            console.log("Request => ",data['data']['title'])
             if(data['data']['title'].includes("Withdrawal")){
                var e = "<a href='"+baseUrl+"/admin/withdrawal' class='dropdown-item notify-item'>"
                    +"<div class='notify-icon bg-dark'><i class='fe-bell noti-icon'></i></div>"
                    +"<p class='notify-details'>"+data['data']['title']+
                    "<small class='text-muted'>"+d[1]+' '+d[2]+', '+d[3]+"</small>"
                    +"</p></a>"
            }else{
                var e = "<a href='"+baseUrl+"/admin/deposit' class='dropdown-item notify-item'>"
                    +"<div class='notify-icon bg-dark'><i class='fe-bell noti-icon'></i></div>"
                    +"<p class='notify-details'>"+data['data']['title']+
                    "<small class='text-muted'>"+d[1]+' '+d[2]+', '+d[3]+"</small>"
                    +"</p></a>"
            }
            $(".admin_alert .simplebar-content").prepend(e);
            y++ ;
            if(y!=0){
                $('#alert_counter').show();
                $('#alert_counter').text(y);
            }
        })
    })
}
$(window).on('load', function () {
    // console.log("Hello world!");
    usertype = $('#usertype').val() ;
    console.log("user Type " , typeof(usertype)) 
    if(usertype == '2'){
        console.log("Customer") ;
        notificationcount();
    }else{
        console.log("Admin");
        alertNotificationCount() ;
    }
});
</script>
<style>
    .card {
        box-shadow: 0px 0px 20px rgb(0 0 0 / 20%);
        border-radius: 0.5rem;
    }
    .primary_btn{
        background-color: rgba(0, 115, 182, 0.15);
        padding: 7px 10px;
        border: 1px solid #0073B6;
        border-radius: 5px;
        color: #000000;
    }
    .footable-pagination li.active a {
            color: #000;
            background-color: rgba(0, 115, 182, 0.15);
            border-color: #0073B6;
        }
</style>