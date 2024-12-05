<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Deposit Request - <?php echo APP_NAME ?></title>
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

<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}}'>
    <!-- Begin page -->
    <div id="wrapper">
        <?php echo view("/home/left-sidebar"); ?>
        <?php echo view("/home/top-bar" , $notification); ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="content-page" style="background-color: #F5F5FC !important;">
            <div class="content">
                <!-- Start Content-->
                <div id="full-screen-loader">
                    <div class="spinner-grow avatar-lg text-secondary m-2" role="status"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-4">
                        <h3 class="header-title mt-4 mb-2">Deposit</h3>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="sub-header">Following are the customer deposits.</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="mb-2">
                                            <div class="row row-cols-sm-auto" style="float: right;">
                                                <div class="col-6">
                                                    <input id="demo-foo-search" type="text" placeholder="Search" class="form-control form-control-sm" autocomplete="on">
                                                </div>
                                                <div class="col-6 text-sm-end">
                                                    <select id="demo-foo-filter-status" class="form-select form-select-sm">
                                                        <option value="">Show all</option>
                                                        <option value="Pending">Pending</option>
                                                        <option value="Accepted">Accepted</option>
                                                         <option value="Completed">Completed</option> 
                                                         <option value="Rejected">Rejected</option> 
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="demo-foo-filtering" class="table toggle-circle mb-0" data-page-size="15">
                                        <thead style="background-color: #F2F2F2;">
                                        <?php if (isset($allDeposits)) : ?>
                                            <tr>
                                                <th data-toggle="true">Deposit Date</th>
                                                <th data-hide="">User Name</th>
                                                <th data-hide="">Actions</th>
                                                <th data-hide="">Status</th>
                                                <th data-hide="all">Method</th>
                                                <th data-hide="all">Method Details</th>
                                                <th data-hide="all">Amount</th>
                                                <th data-hide="all">Accepted Date</th>
                                                <th data-hide="all">Message</th>
                                                <th data-hide="all">Reject Reason (If rejected)</th>
                                            </tr>
                                        <?php endif; ?>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($allDeposits)) : ?>
                                                <?php foreach ($allDeposits as $singleDeposit) : ?>                                                    
                                                    <tr>
                                                        <td><?php echo date('M d, Y', strtotime($singleDeposit['deposite_date'])); ?></td>
                                                        <td>
                                                            <div class="row align-items-center">
                                                                <div class="col-auto">
                                                                    <img src="<?= $singleDeposit['profile_img'] ? base_url().$singleDeposit['profile_img'] : base_url().'/assets/images/users/user-1.jpg' ?>" alt="profile-image" class="rounded-circle" width="40" height="40">                                                                
                                                                </div>
                                                                <div class="col">
                                                                    <p><?= $singleDeposit['firstName'].' '.$singleDeposit['lastName']; ?></p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php if ($singleDeposit['status'] == 'Pending'):?>
                                                            <a href="<?= base_url(); ?>/admin/accept_deposit_requests/<?= $singleDeposit['id']; ?>"><button class="btn btn-success accept_btn"> Accept </button></a>
                                                            <button class="btn btn-danger reject_deposit" data-bs-toggle="modal" data-bs-target="#rejectModal" value="<?= $singleDeposit['id']; ?>"> Reject </button>
                                                            <?php elseif ($singleDeposit['status'] == 'Accepted'):?>
                                                            <a href="<?= base_url(); ?>/admin/complete_deposit_requests/<?= $singleDeposit['id']; ?>"><button class="btn btn-success"> Complete </button></a>
                                                            <?php elseif ($singleDeposit['status'] == 'Completed'):?>
                                                            <p style=" width: 145px; color: cadetblue;">Amount added in user’s account successfully</p>
                                                            <?php elseif ($singleDeposit['status'] == 'Rejected'):?>
                                                            <p style=" width: 145px; color: red;">User’s deposit request rejected</p>
                                                            <?php endif; ?>
                                                            
                                                            <!-- <?php if ($singleDeposit['status'] == 'Pending') : ?>
                                                                <a href="<?= base_url(); ?>/admin/accept_deposit_requests/<?= $singleDeposit['id']; ?>"><button class="btn btn-success accept_withdrawal">Accept</button></a>
                                                                <a href="<?= base_url(); ?>/admin/reject_deposit_requests/<?= $singleDeposit['id']; ?>"><button class="btn btn-danger reject_withdrawal">Reject</button></a>
                                                            <?php elseif ($singleDeposit['status'] == 'Accepted') : ?>
                                                                <a href="<?= base_url(); ?>/admin/reject_deposit_requests/<?= $singleDeposit['id']; ?>"><button class="btn btn-danger reject_withdrawal">Reject</button></a>
                                                            <?php elseif ($singleDeposit['status'] == 'Rejected') : ?>
                                                                <a href="<?= base_url(); ?>/admin/accept_deposit_requests/<?= $singleDeposit['id']; ?>"><button class="btn btn-success accept_withdrawal">Accept</button></a>
                                                            <?php endif; ?> -->
                                                        </td>
                                                        <td style="padding-top: 25px;">
                                                            <?php if ($singleDeposit['status'] == 'Pending') : ?>
                                                                <span class="badge badge-warning" style="color: black; background-color:#ffc107;font-size: 13px;"><?= $singleDeposit['status']; ?></span>
                                                            <?php elseif($singleDeposit['status'] == 'Accepted') : ?>
                                                                <span class="badge badge-success" style="color: white; background-color:#28a745;font-size: 13px;"><?= $singleDeposit['status']; ?></span>
                                                            <?php elseif($singleDeposit['status'] == 'Completed') : ?>
                                                                <span class="badge badge-danger" style="color: white; background-color:#28a745;font-size: 13px;"><?= $singleDeposit['status']; ?></span>
                                                            <?php elseif($singleDeposit['status'] == 'Rejected') : ?>
                                                                <span class="badge badge-danger" style="color: white; background-color:#FF4542;font-size: 13px;"><?= $singleDeposit['status']; ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?= $singleDeposit['currency'] ?></td>
                                                        <td><?= $singleDeposit['currency_option'] ?></td>
                                                        <td>$<?= $singleDeposit['amount'] ?></td>
                                                        <td><?php echo $singleDeposit['accepted_date'] ? date('M d, Y', strtotime($singleDeposit['accepted_date'])) : 'Not Added'; ?></td>
                                                        <td><?= $singleDeposit['message'] ?></td>
                                                        <td> <?php echo $singleDeposit['status'] !== 'Rejected' ? "" : $singleDeposit['reject_reason']; ?> </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <h3 style="text-align: center;">No Record Found</h3>
                                            <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="active">
                                                <td colspan="5" style="border-bottom: none;">
                                                    <div class="text-end mt-3">
                                                        <ul class="pagination pagination-rounded justify-content-center footable-pagination mb-0"></ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div> <!-- end .table-responsive-->
                                
                                <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-hidden="true">
                                    <!-- Modal for delete -->
                                    <div class="modal-dialog">
                                        <div class="modal-content mt-5">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myCenterModalLabel">Please give a reason to Reject</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="<?php echo base_url(); ?>/admin/reject_deposit_requests" id="rejectReasonModal" method="POST">
                                                <div class="modal-body" >
                                                    <input type="hidden" name="deposit_id" id="deposit_id" value="">
                                                    <p>The reason will be shared to the customer</p>
                                                    
                                                    <label for="reason" class="form-label">Reason:</label></br>
                                                    <textarea class="form-label" id="reason" name="reason" rows="6" style="min-width: 100%" required></textarea>
                                                </div>
                                                <div class="modal-body mt-4">
                                                    <a href="#" class="btn btn-primary" data-bs-dismiss="modal" style="padding: 7px 45px; border: 1px solid #000000; background-color: #000000; float:right">Cancel</a>
                                                    <button id="reject_btn" type="submit" class="btn btn-danger" style="padding: 7px 45px;">Reject</button>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                                
                            </div>
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div>
        </div>
    </div>

    <?php echo view("/home/footer-scripts"); ?>
    <script>
        $('#full-screen-loader').hide();
        $('.reject_deposit').click(function(){
            $('#deposit_id').val($(this).val());
        });
        $('#reject_btn').click(function(){
            if($('#reason').val() !== ''){
                $('#full-screen-loader').show();
            }
        });
        $('.accept_btn').click(function(){
            $('#full-screen-loader').show();
        });
    </script>
</body>

</html>