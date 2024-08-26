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

</head>

<!-- body start -->

<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}}'>
    <!-- Begin page -->
    <div id="wrapper">
        <?php echo view("/home/left-sidebar"); ?>
        <!-- include Top-bar -->
        <?php echo view("/home/top-bar") ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="content-page pt-3 ">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <!-- <div> -->
                        <div class="mb-3 " style="margin-bottom: 0rem!important;">
                            <h3>Add New Notification</h3>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <?php if (isset($userData)) : ?>
                                    <form action="<?php echo base_url(); ?>/admin/submitnotification" method="POST">
                                    <?php endif; ?>
                                    <form action="<?php echo base_url(); ?>/admin/updatenotificationData?id=<?php if (isset($notificationInfo)) echo $notificationInfo['id'] ?>" method="POST">
                                        <dvi class="row">
                                            <div class="mb-3 col-md-4">
                                                <label for="title" class="form-label">Notification
                                                    Title<span style="color: red;">*</span></label>
                                                <input class="form-control" name="title" placeholder="Title" rows="3" value="<?php echo isset($notificationInfo) ? $notificationInfo['title'] : '' ?>" required></input>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="status" class="form-label">Status<span style="color: red;">*</span></label>
                                                <select name="status" class="form-control" required>
                                                    <option value="">Choose</option>
                                                    <option value="Enable" <?php if (isset($notificationInfo) && $notificationInfo['status'] == 'Enable') : ?>selected<?php endif; ?>>
                                                        Enable</option>
                                                    <option value="Disable" <?php if (isset($notificationInfo) && $notificationInfo['status'] == 'Disable') : ?>selected<?php endif; ?>>
                                                        Disable</option>
                                                </select>
                                            </div>
                                            <!-- <div class="mb-3 col-md-4">
                                                <?php if (isset($userData)) : ?>
                                                    <label for="date" class="form-label">Publish Date</label>
                                                    <input type="date" class="form-control" name="date" required>

                                                <?php endif; ?>
                                            </div> -->
                                            <div class="mb-3 col-md-4">
                                                <?php if (isset($userData)) : ?>
                                                    <label for="status" class="form-label">Select User</label>
                                                    <select name="forSingelNoti" class="form-control" required>
                                                        <option value="alluser">All User</option>
                                                        <?php

                                                        foreach ($userData as $row) {
                                                            echo '<option value="' . $row['id'] . '">' . $row['firstName'] . " " . $row['lastName'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                <?php endif; ?>
                                            </div>
                                        </dvi>
                                        <div class="row">
                                            <div class="mb-3 col-md-8">
                                                <label for="description" class="form-label">Description<span style="color: red;">*</span></label>
                                                <textarea class="form-control" name="description" placeholder="Message" rows="2" required><?php if (isset($notificationInfo)) echo $notificationInfo['description'] ?></textarea>
                                            </div>

                                        </div>
                                        <div class="text-center d-grid mt-4">
                                            <?php if (isset($userData)) : ?>
                                                <div>
                                                    <button class="btn btn-primary waves-effect waves-light" type="submit" style="padding: 7px 15px; background-color: #0073B6; margin-right:10px">
                                                        Add Now
                                                    </button>
                                                    <button class="primary_btn" type="reset" style="margin-right: 10px;">
                                                        Reset
                                                    </button>
                                                    <button class="btn btn-danger waves-effect waves-light" type="cancel" onclick="javascript:window.location='<?php echo base_url(); ?>/admin/notifications';">
                                                        Cancel </button>
                                                </div>
                                            <?php else : ?>
                                                <div>
                                                    <button style="border: 1px solid #000000; background-color: #000000;" class="btn btn-success waves-effect waves-light" type="submit">
                                                        Update </button>
                                                    <a href="<?php echo base_url(); ?>/admin/notifications"><button class="btn btn-danger waves-effect waves-light" type="button">
                                                            Cancel </button></a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </form>
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

</body>

</html>