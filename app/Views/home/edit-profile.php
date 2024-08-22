<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Edit profile - <?php echo APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nvest Clients - Where you can invest" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php echo view("/home/header-links"); ?>

</head>

<!-- body start -->

<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}}'>
    <!-- Begin page -->
    <div id="wrapper">

        <!-- include Top-bar -->
        <?php echo view("/home/top-bar") ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
        <div class="content-page">
            <div class="content">
                <div class="row">
                    <div class="col-lg-12 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Edit your Profile here</h4>

                                <form class="needs-validation" novalidate>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">First name</label>
                                                <input type="text" class="form-control" id="validationCustom01" placeholder="First name" value="Mark" required />
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="validationCustom02" class="form-label">Last name</label>
                                                <input type="text" class="form-control" id="validationCustom02" placeholder="Last name" value="Otto" required />
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <!-- <div class="mb-3"> -->
                                            <!-- <label for="validationCustomUsername" class="form-label">Username</label> -->
                                            <!-- <div class="input-group"> -->
                                            <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                                            <!-- <input type="text" class="form-control" id="validationCustomUsername" placeholder="Username" aria-describedby="inputGroupPrepend" required /> -->
                                            <!-- <div class="invalid-feedback"> -->
                                            <!-- Please choose a username. -->
                                            <!-- </div> -->
                                            <!-- </div> -->
                                            <!-- </div> -->
                                            <div class="row">
                                                <div class="mb-3 col-6">
                                                    <label for="emailaddress" class="form-label">Email address</label>
                                                    <input class="form-control" type="email" id="emailaddress" readonly value="Enter your email">
                                                    <div class="invalid-feedback">
                                                        Please provide a valid Email.
                                                    </div>

                                                </div>
                                                <div class="mb-3 col-6">
                                                    <label for="PhoneNumber" class="form-label">Phone Number</label>
                                                    <input class="form-control" type="tel" id="PhoneNumber" required value="Enter your Phone Number">
                                                    <div class="invalid-feedback">
                                                        Please provide a valid Phone number.
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="mb-3 col-6"> -->
                                            <!-- <label for="address1" class="form-label">Address </label> -->
                                            <!-- <input class="form-control" type="text" required id="address1" value="Hno#123 st 123..."> -->
                                            <!-- <div class="invalid-feedback"> -->
                                            <!-- Please provide a valid Address. -->
                                            <!-- </div> -->
                                            <!-- </div> -->
                                            <div class="row">
                                                <div class="mb-3 col-6">
                                                    <label for="validationCustom03" class="form-label">City</label>
                                                    <input type="text" class="form-control" id="validationCustom03" value="City" required />
                                                    <div class="invalid-feedback">
                                                        Please provide a valid city.
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-6">
                                                    <label for="validationCustom04" class="form-label">Country</label>
                                                    <input type="text" class="form-control" id="validationCustom04" value="Country" required />
                                                    <div class="invalid-feedback">
                                                        Please provide a valid country.
                                                    </div>
                                                </div>

                                                <!-- <div class="mb-3 col-6"> -->
                                                <!-- <label for="validationCustom05" class="form-label">Zip</label> -->
                                                <!-- <input type="text" class="form-control" id="validationCustom05" value="Zip" required /> -->
                                                <!-- <div class="invalid-feedback"> -->
                                                <!-- Please provide a valid zip. -->
                                                <!-- </div> -->
                                                <!-- </div> -->
                                            </div>
                                            <!-- <div class="mb-3"> -->
                                            <!-- <div class="form-check"> -->
                                            <!-- <input type="checkbox" class="form-check-input" id="invalidCheck" required /> -->
                                            <!-- <label class="form-check-label" for="invalidCheck">Agree to terms and conditions</label> -->
                                            <!-- <div class="invalid-feedback"> -->
                                            <!-- You must agree before submitting. -->
                                            <!-- </div> -->
                                            <!-- </div> -->
                                            <!-- </div> -->
                                            <button style="background-color: #45B8A5; border-color: #45B8A5;" class="btn btn-primary" type="submit">Update</button>
                                </form>

                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div> <!-- end row -->

                <!-- ============================================================== -->
                <!-- End Page content -->
                <!-- ============================================================== -->

            </div>
        </div>
    </div> <!-- END wrapper -->

    <?php echo view("/home/footer-scripts"); ?>

</body>

</html>