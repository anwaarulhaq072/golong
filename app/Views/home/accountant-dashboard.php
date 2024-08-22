<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Accountant Dashboard - <?php echo APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nvest Clients - Where you can invest" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php echo view("/home/header-links"); ?>


</head>

<!-- body start -->

<body class="loading" data-layout='{"mode": "dark", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}}'>
    <!-- Begin page -->
    <div id="wrapper">

        <!-- include Top-bar -->
        <?php echo view("/home/top-bar", $accountantData) ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page" style="margin-left: unset;">
            <div class="content-page" style="margin-left: unset;">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">

                                                        <h4 class="header-title">All Customers</h4>

                                                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                                            <thead>
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Pending Payout</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($userData as $index => $Singleuser) :   ?>
                                                                    <tr>
                                                                        <td><?php echo $Singleuser['firstName'] . " " . $Singleuser['lastName'] ?></td>
                                                                        <td><?php echo $pendingPayout[$index] ?></td>
                                                                    <?php endforeach ?>
                                                                    </tr>

                                                            </tbody>
                                                        </table>

                                                    </div> <!-- end card body-->
                                                </div> <!-- end card -->
                                            </div><!-- end col-->
                                        </div>
                                        <!-- end row-->

                                    </div>
                                </div> <!-- end card -->
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                    </div> <!-- container -->


                </div> <!-- content -->

            </div>
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <?php echo view("/home/footer-scripts"); ?>

    <!-- third party js -->
    <script src="<?php echo base_url(); ?>/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/pages/datatables.init.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/app.min.js"></script>

</body>

</html>