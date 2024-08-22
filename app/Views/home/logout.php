<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Logout - <?php echo APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Go Long Clients - Where you can invest" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php echo view("/home/header-links"); ?>

</head>

<body class="loading" style="background-color: #EEEEEE;">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

                            <div class="text-center  w-75 m-auto">
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

                            <div class="text-center">
                                <div class="mt-4">
                                    <div class="logout-checkmark">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                            <circle class="path circle" fill="none" stroke="#0073B6" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                                            <polyline class="path check" fill="none" stroke="#0073B6" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " />
                                        </svg>
                                    </div>
                                </div>

                                <h3>See you again !</h3>

                                <p class="text-muted"> You are now successfully sign out. </p>
                            </div>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Back to <a href="<?php echo base_url(); ?>" class="text-muted ms-1"><b>Sign In</b></a></p>
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

</body>

</html>