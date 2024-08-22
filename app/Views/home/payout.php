<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Payouts Records - <?php echo APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nvest Clients - Where you can invest" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link href="<?php echo base_url(); ?>/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <!-- <link href="<?php echo base_url(); ?>/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- <link href="<?php echo base_url(); ?>/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- <link href="<?php echo base_url(); ?>/assets/libs/datatables.net-select-bs5/css//select.bootstrap5.min.css" rel="stylesheet" type="text/css" /> -->

    <?php echo view("/home/header-links"); ?>

</head>

<body class="loading" data-layout='{"mode": "dark", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}}'>
    <div id="wrapper">

        <!-- include Top-bar -->

        <?php echo view("/home/top-bar", $notification) ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page" style="margin-left: unset;">
            <div class="content-page" style="margin-left: unset;">
                <div class="content">
                    <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
                    <!-- Start Content-->
                    <div class="container-fluid">
                        <div class="center">

                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">

                                            <h4 class="header-title mb-3">Payouts Records</h4>
                                            <!-- <p class="text-muted font-13 mb-4">
                                                This example shows the multi option. Note how a click on a row will toggle its selected state without effecting other rows,
                                                unlike the os and single options shown in other examples.
                                            </p> -->

                                            <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Amount</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($payoutInfo as $single) : ?>
                                                        <tr>
                                                            <th>$<?php echo $single['amount'] ?></th>
                                                            <th><?php echo $single['payoutdate'] ?></th>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>

                                        </div> <!-- end card body-->
                                    </div> <!-- end card -->
                                </div><!-- end col-->
                            </div>
                            <!-- end row-->



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo view("/home/footer-scripts"); ?>

    <script src="<?php echo base_url(); ?>/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script> -->
    <!-- <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script> -->
    <!-- <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script> -->
    <!-- <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script> -->
    <!-- <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script> -->
    <!-- <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script> -->
    <!-- <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script> -->
    <!-- <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script> -->
    <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>

    <script src="<?php echo base_url(); ?>/assets/js/pages/datatables.init.js"></script>

    <script src="<?php echo base_url(); ?>/assets/js/notificationModal.js"></script>

</body>

</html>