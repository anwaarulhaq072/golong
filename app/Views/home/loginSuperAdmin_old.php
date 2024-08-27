<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Go Long Clients</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Go long Clients - Where you can invest" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />


    <?php echo view("/home/header-links"); ?>

</head>

<body class="loading" id="body" style="background-color: #EEEEEE;">

    <div class="account-pages mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <div class="auth-logo">
                                    <a href="<?php echo base_url(); ?>" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="<?php echo base_url(); ?>/assets/images/G_logo.png" alt="" height="100">
                                        </span>
                                    </a>

                                    <a href="<?php echo base_url(); ?>" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="<?php echo base_url(); ?>/assets/images/G_logo.png" alt="" height="100">
                                        </span>
                                    </a>
                                </div>

                            </div>
                            <p class="text-center mb-3 mt-4" style="font-size: 20px; font-weight:600">Log in with Super Admin Account</p>
                            <p id="loginMessage" style="color: red; text-align:center;"></p>

                            <form action="#" id="loginFormSuperAdmin">
                                <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">

                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">User Email address</label>
                                    <input class="form-control" type="email" name="useremailAddress" placeholder="Enter user email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Super Admin Email address</label>
                                    <input class="form-control" type="email" name="emailAddress" placeholder="Enter your email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input class="form-control" type="password" name="password" placeholder="Enter your password" required>
                                </div>

                                <div class="text-center d-grid">
                                    <button id="loginBtn" style="background-color: #45B8A5; border-color: #45B8A5;" class="btn btn-primary" type="submit">Log In </button>
                                </div>


                            </form>

                            <!-- <div class="text-center">
                                <h5 class="mt-3 text-muted">Sign in with</h5>
                                <ul class="social-list list-inline mt-3 mb-0">
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github"></i></a>
                                    </li>
                                </ul>
                            </div> -->

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <!-- <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p> <a href="auth-recoverpw.html" class="text-white-50 ms-1">Forgot your password?</a></p>
                            <p class="text-white-50">Don't have an account? <a href="auth-register.html" class="text-white ms-1"><b>Sign Up</b></a></p>
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
        <!-- 2015 - <script>
            document.write(new Date().getFullYear())
        </script> &copy; UBold theme by <a href="" class="text-white-50">Coderthemes</a> -->
    </footer>

    <!-- Vendor js -->
    <script src="<?php echo base_url(); ?>/assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="<?php echo base_url(); ?>/assets/js/app.min.js"></script>

    <?php echo view("/home/footer-scripts"); ?>
    <script src="<?php echo base_url(); ?>/assets/js/superlogin.js"></script>

</body>

</html>