<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Verify OTP - <?php echo APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nvest Clients - Where you can invest" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php echo view("/home/header-links"); ?>

</head>

<body class="loading " style="background-color: #EEEEEE;">

    <div class=" account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <div class="auth-logo">
                                    <a href="<?php echo base_url(); ?>" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="<?php echo base_url(); ?>/assets/images/G_logo.png" alt="" height="150">
                                        </span>
                                    </a>

                                    <a href="<?php echo base_url(); ?>" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="<?php echo base_url(); ?>/assets/images/G_logo.png" alt="" height="150">
                                        </span>
                                    </a>
                                </div>

                            </div>
                            <div class="text-center w-75 m-auto">
                                <!-- <img src="../assets/images/users/user-1.jpg" height="88" alt="user-image" class="rounded-circle shadow"> -->
                                <!-- <h4 class="text-dark-50 text-center mt-3">Hi ! Geneva </h4> -->
                                <p class="text-muted mb-4 mt-2">Enter your OTP to access the dashboard.</p>
                                <p id="loginMessage" style="color: red; text-align:center;"></p>
                            </div>
                            <div class="mb-2 row justify-content-start">
                                <div style="margin-top: 2px;">Please enter the verification code received on your registered phone and email. If you do not receive a code within 60 seconds, you can resend the verification code. <span id="time"></span> </div>
                                <div id="resendDiv" style="text-align: left"><a href="" id="resendCode" style="font-size:15px; float:right">Resend Code</a></div>
                            </div>

                            <form action="#" id="otpForm">
                                <input type="hidden" id="base" value="<?php echo base_url(); ?>">
                                <input type="hidden" id="us_id" value="<?php echo $_GET['uid']; ?>">

                                <div class="mb-3">
                                    <!-- <label for="password" class="form-label mt-2">OTP</label> -->
                                    <input class="form-control" type="password" name="code" placeholder="Enter your code" required>
                                </div>

                                <div class="text-center d-grid">
                                    <button class="btn btn-primary" type="submit"> Verify </button>
                                </div>

                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <!-- <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-white-50">Not you? return <a href="auth-login.html" class="text-white ms-1"><b>Sign In</b></a></p>
                        </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
    </div>
    <!-- end page -->


    <!-- <footer class="footer footer-alt">
        2015 - <script>
            document.write(new Date().getFullYear())
        </script> &copy; UBold theme by <a href="" class="text-white-50">Coderthemes</a>
    </footer> -->

    <?php echo view("/home/footer-scripts"); ?>
    <script src="<?php echo base_url(); ?>/assets/js/ajax_login.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/sendOtp.js"></script>

</body>

</html>