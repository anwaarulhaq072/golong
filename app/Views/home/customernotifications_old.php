<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Customer Dashboard - <?php echo APP_NAME ?></title>
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
        <?php echo view("/home/top-bar", $notification) ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page pt-3">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">

                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="mb-3" >All Notifications</h3>
                                <?php foreach ($notification as $singleNotification) : ?>
                                <?php if(!empty($singleNotification['title']) && $singleNotification['title'] != NULL): ?>
                                    <div class="row mb-4" style="border: 1px solid;border-radius: 15px;">
                                        <div style="box-shadow: 1px 1px 15px -5px #ffff; border-radius:5px 30px; padding:10px;">
                                            <div style="text-align: right;">
                                                <span class="me-4" style="text-align: right;"><?php echo date('M d, Y', strtotime($singleNotification['publishDate'])); ?></span>
                                            </div>
                                            <h4><?php echo $singleNotification['title']; ?></h4>
                                            <p><?php echo $singleNotification['description']; ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
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