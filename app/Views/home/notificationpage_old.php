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
        <div class="content-page pt-4 col-lg-10 col-md-10" style=" background-color: #F5F5FC !important;">
            <div class="content" style="margin-top: 50px;">
                <!-- Start Content-->
                        <?php if(isset($_GET['success']) && $_GET['success'] == true): ?>
                        <div class="alert alert-success" role="alert">
                        Notification sent successfully
                        </div>
                        <?php endif; ?>
                <div class="container-fluid">
                    <h3 class="header-title mt-4 mb-3">All Notifications</h3>
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3" style="display:flex; justify-content: space-between;">
                                    <p></p>
                                    <a href="<?php echo base_url(); ?>/admin/addnotification">
                                        <button class="primary_btn">Add New Notification
                                            <span class="fa fa-bell ms-2 me-1" style="font-size: 17px;"></span></button>
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table id="demo-foo-filtering" class="table toggle-circle mb-0" data-page-size="10">
                                        <thead style="background-color: #F2F2F2;">
                                            <tr>
                                                <th>Title</th>
                                                <th data-hide="">Status</th>
                                                <th data-hide="phone, tablet">Date</th>
                                                <th data-hide="phone, tablet">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($allNotifications as $singleNotification) :  ?>
                                            <?php if(strpos($singleNotification['title'],"Request") == ''): ?>
                                                <tr>
                                                    <td><?php echo $singleNotification['title'] ?></td>
                                                    <td><?php echo $singleNotification['status'] ?></td>
                                                    <td><?php echo  date('M d, Y', strtotime($singleNotification['publishDate'])); ?>
                                                    </td>
                                                    <td> 
                                                        <a href="<?php echo base_url(); ?>/admin/updatenotification?id=<?php echo $singleNotification['id']; ?>" style="width:50px; height:50px"><button class="btn btn-sm" style="box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15); border-radius:5px; margin-right: 6px;"><b><span class="mdi mdi-pencil" style="color: black; font-size: 16px;"></b></button>
                                                        <a href="<?php echo base_url(); ?>/admin/deleteNotification?id=<?php echo $singleNotification['id']; ?>" style="width:50px; height:50px"><button class="btn btn-sm" style="box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15); border-radius:5px; margin-right: 6px;"><b><span class="mdi mdi-delete" style="color: black; font-size: 16px;"></b></button>
                                                    </td>

                                                </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="active">
                                                <td colspan="7" style="border-bottom: none;">
                                                    <div class="text-end mt-3">
                                                        <ul class="pagination pagination-rounded justify-content-center footable-pagination mb-0">
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div> <!-- end .table-responsive-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="delete_notification_Modal" tabindex="-1" role="dialog" aria-hidden="true">
                                    <!-- Modal for delete -->
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="margin-top: 200px">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myCenterModalLabel">Are you sure you want to delete this notification?</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="<?php echo base_url(); ?>/admin/deleteNotification" id="rejectReasonModal" method="POST">
                                                <div class="modal-body" >
                                                    <input type="hidden" name="notification_id" id="notification_id" value="">
                                                </div>
                                                <div class="modal-body">
                                                <button id="reject_btn" type="submit" class="btn btn-danger">Yes</button>
                                                    <a href="#" class="btn btn-primary" data-bs-dismiss="modal" style=" border: 1px solid #000000; background-color: #000000;">No</a>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->
    <?php echo view("/home/footer-scripts"); ?>
    <<script>
        $('.alert-success').fadeOut(5000);
    </script>

</body>

</html>