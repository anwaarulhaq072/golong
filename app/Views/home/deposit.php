<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Deposits - <?php echo APP_NAME ?></title>
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
        <?php echo view("/home/top-bar", $notification); ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="content-page" style="background-color: #F5F5FC !important;">
            <div class="content">
                <!-- Start Content-->
                 <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
                <div class="row mt-4">
                    <div class="col-12" style="text-align: right;">
                        <a href="<?= base_url(); ?>/user/add_deposit"><button class="btn btn-primary" style=" border: 1px solid #000000; background-color: #000000;"> New Deposit Request</button></a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="header-title mt-4 mb-2">Deposit History</h4>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="sub-header">Following are the records of your deposit history.</p>
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
                                                <th data-hide="">Status</th>
                                                <th data-hide="">Method</th>
                                                <th data-hide="phone">Method Details</th>
                                                <th data-hide="phone">Amount</th>
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
                                                            <?php if ($singleDeposit['status'] == 'Pending') : ?>
                                                                <span class="badge badge-warning" style="color: black; background-color:#ffc107;font-size: 13px;"><?= $singleDeposit['status']; ?></span>
                                                            <?php elseif($singleDeposit['status'] == 'Accepted') : ?>
                                                                <span class="badge badge-info" style="color: white; background-color:#17A2B8;font-size: 13px;"><?= $singleDeposit['status']; ?></span>
                                                            <?php elseif($singleDeposit['status'] == 'Completed') : ?>
                                                                 <span class="badge badge-success" style="color: white; background-color:#28a745;font-size: 13px;"><?= $singleDeposit['status']; ?></span> 
                                                            <?php elseif($singleDeposit['status'] == 'Rejected') : ?>
                                                                 <span class="badge badge-danger" style="color: white; background-color:#f1556c;font-size: 13px;"><?= $singleDeposit['status']; ?></span> 
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
                            </div>
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div>
        </div>
    </div>

    <?php echo view("/home/footer-scripts"); ?>
    <script>
    </script>
    
</body>

</html>