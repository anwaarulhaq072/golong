<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Success - <?php echo APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nvest Clients - Where you can invest" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php echo view("/home/header-links"); ?>
</head>

<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}}'>
    <!-- Begin page -->
    <div id="wrapper">
        <?php echo view("/home/left-sidebar"); ?>
        <?php echo view("/home/top-bar"); ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="content-page" style="background-color: #F5F5FC !important;">
            <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
            <div class="content">
                <!-- Start Content-->
                <div class="mt-5">
                    <div class="card ribbon-box">
                        <div class="card-body">
                            <div class="ribbon ribbon-success float-end"><i class="mdi mdi-access-point me-1"></i> Success</div>
                            <h5 class="text-success float-start mt-0"><?=$title?></h5>
                            <div class="ribbon-content">
                                <p class="mb-0"><?=$message?></p>
                                <div class="text-center mt-5 mb-3">
                                    <a href="<?php echo base_url(); ?>"><button class="btn btn-primary px-5" style=" background-color: #0073B6; ">Dashboard</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php echo view("/home/footer-scripts"); ?>
</body>

</html>