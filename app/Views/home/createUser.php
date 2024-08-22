<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Admin Dashboard - <?php echo APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nvest Clients - Where you can invest" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php echo view("/home/header-links"); ?>
    <style>
        #full-screen-loader{
            align-items: center;
            background: #FFF;
            display: flex;
            height: 100vh;
            justify-content: center;
            left: 1;
            position: fixed;
            top: 0;
            transition: opacity 0.5s linear;
            width: 85%;
            z-index: 9999;
            opacity: 0.5;
            transform: opacity 0.5s linear;
        }
    </style>

</head>

<body class="loading"
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}}'>
    <!-- Begin page -->

    <div id="wrapper">
    <?php echo view("/home/left-sidebar"); ?>
        <!-- include Top-bar -->
        <?php echo view("/home/top-bar" , $notification) ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
            <div class="content-page" style="background-color: #F5F5FC !important;">
                <div class="content">
                    <!-- Start Content-->
                    <!--<div id="full-screen-loader">-->
                    <!--    <div class="spinner-grow avatar-lg text-secondary m-2" role="status"></div>-->
                    <!--</div>-->
                    <div class="container-fluid">
                        <div class="row">

                            <div class="tab-pane" id="tab-signup">
                                <div class="mb-3 mt-4">
                                    <h3>Create New User</h3>
                                </div>
                                <div class="alert alert-danger" id="warning_box" style="padding: 5px !important;padding-bottom: 0px !important; ">
                                  <p id="signupMessage" style="margin-top: 0px !important; margin-bottom: 6px !important; "></p>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <form action="#" id="signupForm">
                                            <input type="hidden" id="base" value="<?php echo base_url(); ?>">
                                            <div class="row">

                                                <div class="mb-3 col-lg-4 col-md-6 col-12">
                                                    <label for="firstname" class="form-label">First Name<span style="color: red;" >*</span></label>
                                                    <input class="form-control" type="text" name="firstName"
                                                        placeholder="First Name" required>
                                                </div>
                                                <div class="mb-3 col-lg-4 col-md-6 col-12">
                                                    <label for="lastname" class="form-label">Last Name<span style="color: red;" >*</span></label>
                                                    <input class="form-control" type="text" name="lastName"
                                                        placeholder="Last Name" required>
                                                </div>
                                                <!-- </dvi> -->
                                                <!-- <div class="row"> -->
                                                <div class="mb-3 col-lg-4 col-md-6 col-12">
                                                    <label for="phone" class="form-label">Phone Number<span style="color: red;" >*</span></label>
                                                    <input class="form-control" type="tel" name="phoneNumber"
                                                        placeholder="Phone Number" required>
                                                </div>
                                                <div class="mb-3 col-lg-4 col-md-6 col-12">
                                                    <label for="emailaddress" class="form-label">Email address<span style="color: red;" >*</span></label>
                                                    <input class="form-control" type="email" name="emailAddress"
                                                        placeholder="Email" required>
                                                </div>
                                                <!-- </div> -->
                                                <!-- <div class="row"> -->
                                                <div class="mb-3 col-lg-4 col-md-6 col-12">
                                                    <label for="role" class="form-label">Role</label>
                                                    <select id="role" class="form-select"
                                                        aria-label="Default select example">
                                                        <option value="2" selected>User</option>
                                                        <option value="1">Admin</option>
                                                    </select>
                                                </div>
                                                <!-- </div> -->
                                                <div class="text-center d-grid mb-3 col-lg-4 col-md-6 col-12" style="margin-top: 29px;">
                                                    <div>
                                                        <button id="submit_create_user_btn" class="btn btn-success waves-effect waves-light" type="submit" style="width: 45%; border: 1px solid #000000; background-color: #000000;"> Create </button>
                                                        <!-- <button class="btn btn-info waves-effect waves-light" type="reset"> Reset form </button> -->
                                                        <button class="primary_btn" style="width: 45%;"
                                                            type="cancel" onclick="javascript:window.location='<?php echo base_url(); ?>';">
                                                            Cancel </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>

    <!-- END wrapper -->

    <?php echo view("/home/footer-scripts"); ?>
    <script src="<?php echo base_url(); ?>/assets/js/ajax_login.js"></script>
    <script>
        $("#warning_box").hide();
    </script>

</body>

</html>