<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Forgot Password - <?php echo APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nvest Clients - Where you can invest" name="description" />
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

                            <!-- Logo -->
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
                            <div class="pb-2">
                                <p id="forgetSuccessMessage" class="text-success"></p>
                            </div>
                            <p id="forgetMessage" style="color: red; text-align:center;"></p>
                            <!-- title-->
                            <h4 class="mt-0" style="text-align: center;">Recover Password</h4>
                            <p class="text-muted mb-2" style="text-align: center;">Enter your email address and we'll send you an email with instructions to reset your password.</p>

                            <form id="forgetForm">

                                <input type="hidden" id="base" value="<?php echo base_url(); ?>" >
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email address</label>
                                    <input class="form-control" style="border-radius:10px;" type="email" id="emailaddress" required="" placeholder="Enter your email">
                                </div>

                                <div class="text-center d-grid">
                                    <button style="background-color:#0073B6; border-color: #0073B6; width:100% ; border-radius:10px;" class="btn btn-primary waves-effect waves-light" type="submit"> Reset Password </button>
                                </div>

                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Back to <a href="<?php echo base_url(); ?>" class="text-muted ms-1"><b>Log in</b></a></p>
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
    <script src="<?php echo base_url(); ?>/assets/js/forgetPassword.js"></script>

</body>

</html>