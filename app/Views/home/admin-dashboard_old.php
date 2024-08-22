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
        <?php echo view("/home/top-bar" , $notification) ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page" style=" background-color: #F5F5FC !important;">
            <div class="content" style="margin-top: 50px;">
                <!-- Start Content-->
                        <?php if(isset($_GET['success']) && $_GET['success'] == true): ?>
                        <div class="alert alert-success" role="alert">
                        New user created. Email with password successfully sent to the user.
                        </div>
                        <?php endif; ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="header-title mb-2">All Clients</h4>
                            <div class="card">
                                <div class="card-body">
                                    <!-- <p class="sub-header"> -->
                                    <!-- include filtering in your FooTable. -->
                                    <!-- </p> -->

                                    <div class="mb-2">
                                        <div class="row row-cols-sm-auto g-2 align-items-center">
                                            <div class="col-12 text-sm-center" style="display: none;">
                                                <select id="demo-foo-filter-status" class="form-select form-select-sm">
                                                    <option value="">Show all</option>
                                                    <option value="Profit">Profit</option>
                                                    <option value="Loss">Loss</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <input id="demo-foo-search" type="text" placeholder="Search" class="form-control form-control-sm" autocomplete="on">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="25">
                                            <thead>
                                                <tr>
                                                    <th data-toggle="true">Name</th>
                                                    <th data-hide="phone">Email</th>
                                                    <!-- <th data-hide="phone">Total Investment ($)</th>
                                                        <th data-hide="phone, tablet">Profit / Loss ($)</th>
                                                        <th data-hide="phone, tablet">Amount</th>
                                                        <th data-hide="phone, tablet">Creation Date</th> -->
                                                    <th data-hide="phone">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (isset($allUsers)) : ?>
                                                    <?php $i = 0;
                                                    foreach ($allUsers as $singleUser) : ?>
                                                        <tr>
                                                            <td><?php echo $singleUser['firstName'] . " " . $singleUser['lastName']; ?></td>
                                                            <td>
                                                                <div class="row align-items-center">
                                                                    <div class="col-auto">
                                                                        <img src="<?= $singleUser['profile_img'] ? base_url().$singleUser['profile_img'] : base_url().'/assets/images/users/user-1.jpg' ?>" alt="profile-image" class="rounded-circle" width="40" height="40">                                                                
                                                                    </div>
                                                                    <div class="col">
                                                                        <p><?= $singleUser['email']; ?></p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <!-- <td>$<?php //echo $singleUser['initialInvestment'] 
                                                                        ?></td>
                                                                <?php //if ($profitLoss[$i] > 0) : 
                                                                ?>
                                                                    <td>Profit</td>
                                                                    <td><span class="badge label-table bg-success" style="font-size: 16px;">$<?php //echo $profitLoss[$i];
                                                                                                                                                //$i++ 
                                                                                                                                                ?></span></td>
                                                                <?php //else : 
                                                                ?>
                                                                    <td>Loss</td>
                                                                    <td><span class="badge label-table bg-danger" style="font-size: 16px;">$<?php //echo $profitLoss[$i];
                                                                                                                                            //$i++ 
                                                                                                                                            ?></span></td>
                                                                <?php //endif; 
                                                                ?>
                                                                <td><?php //echo date('M d, Y', strtotime($singleUser['createdAt'])); 
                                                                    ?></td> -->
                                                            <td>
                                                                <a href="<?php echo base_url() ?>/admin/customerdetails?userid=<?php echo $singleUser['id'] ?>"><button class="primary_btn" style="margin-right: 8px;">Details</button></a>
                                                                <a href="<?php echo base_url() ?>/admin/userDashboardNew?userid=<?php echo $singleUser['id'] ?>"><button class="primary_btn" >User Dashboard</button></a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <h3 style="text-align: center;">No users found</h3>
                                                <?php endif; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr class="active">
                                                    <td colspan="7">
                                                        <div class="text-end">
                                                            <ul class="pagination pagination-rounded justify-content-center footable-pagination mb-0"></ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div> <!-- end .table-responsive-->
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div> <!-- container -->
            </div> <!-- content -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <?php echo view("/home/footer-scripts"); ?>
    <script src="<?php echo base_url(); ?>/assets/js/modalWorking.js"></script>
    <script>
    history.pushState(null, "", location.href.split("?")[0]);
    $('.alert-success').fadeOut(6000);
    </script>

</body>

</html>