<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Reset Password - <?php echo APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nvest Clients - Where you can invest" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php echo view("/home/header-links"); ?>

</head>

<body class="loading auth-fluid-pages pb-0">

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="align-items-center d-flex h-100">
                <div class="card-body">

                    <!-- Logo -->
                    <div class="auth-brand text-center text-lg-start">
                        <div class="auth-logo">
                            <a href="<?php echo base_url(); ?>" class="logo logo-dark text-center">
                                <span class="logo-lg">
                                    <img src="<?php echo base_url(); ?>/assets/images/logo-dark.png" alt="" height="50">
                                </span>
                            </a>

                            <a href="<?php echo base_url(); ?>" class="logo logo-light text-center">
                                <span class="logo-lg">
                                    <img src="<?php echo base_url(); ?>/assets/images/logo-light.png" alt="" height="50">
                                </span>
                            </a>
                        </div>
                    </div>

                    <!-- title-->
                    <h4 class="mt-0">Hi, <?php echo $user['firstName'] . " " . $user['lastName']; ?> </br></br>Enter your new Password</h4>
                    <p class="text-muted mb-4">Enter your new password.</p>

                    <!-- form -->
                    <form id="newPasswordForm">

                        <input type="hidden" id="base" value="<?php echo base_url(); ?>">
                        <input type="hidden" id="userid" value="<?php echo $user['id'] ?>">
                        <div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmpassword" class="form-label">Confirm Password</label>
                                <input class="form-control" type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm password" required>
                            </div>
                            <p id="passwordNotMatch" style="color: red; text-align:center;"></p>
                        </div>

                        <div class="text-center d-grid">
                            <button style="background-color: #45B8A5; border-color: #45B8A5; width:100%" class="btn btn-primary waves-effect waves-light" type="submit"> Update Password </button>
                        </div>

                    </form> <!-- end form-->

                    <!-- Footer-->
                    <footer class="footer footer-alt">
                        <p class="text-muted">Back to <a href="<?php echo base_url(); ?>" class="text-muted ms-1"><b>Log in</b></a></p>
                    </footer>

                </div> <!-- end .card-body -->
            </div> <!-- end .align-items-center.d-flex.h-100-->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                <h2 class="mb-3 text-white">Unique By Belief</h2>
                <p class="lead"><i class="mdi mdi-format-quote-open"></i> Beyond all, we believe what we do not only create positive values for our investors or portfolio companies, but also impact the lives of other stakeholders around them. <i class="mdi mdi-format-quote-close"></i>
                </p>
                <h5 class="text-white">
                    - Nvest Venture
                </h5>
            </div> <!-- end auth-user-testimonial-->
        </div> <!-- end Auth fluid right content -->
    </div> <!-- end auth-fluid-->

    <?php echo view("/home/footer-scripts"); ?>
    <script src="<?php echo base_url(); ?>/assets/js/forgetPassword.js"></script>

</body>

</html>