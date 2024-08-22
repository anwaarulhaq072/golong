<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Client Information - <?php echo APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nvest Clients - Where you can invest" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php echo view("/home/header-links"); ?>

    <style>
        .line{display:block; margin:25px}
        .line h2{font-size:15px; text-align:center; border-bottom:1px solid #3333331A; position:relative; }
        .line h2 span { background-color: white; position: relative; top: 10px; padding: 0 10px;}
    </style>

</head>

<!-- body start -->

<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}}'>
    <!-- Begin page -->
    <div id="wrapper">
        <?php echo view("/home/left-sidebar"); ?>
        <!-- include Top-bar -->
        <?php if (isset($superadminid) && $superadminid) : ?>
            <?php echo view("/home/top-bar", $superadminid) ?>
        <?php else : ?>
            <?php echo view("/home/top-bar") ?>
        <?php endif; ?>


        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page" style="background-color: #F5F5FC !important;">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid mt-4">
                    <div class="modal fade" id="centermodal3" tabindex="-1" role="dialog" aria-hidden="true">
                        <!-- Modal for delete -->
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myCenterModalLabel">Are you sure you want to delete this user?</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body mt-4">
                                    <a href="<?php echo base_url(); ?>/admin/deleteUser?userid=<?php echo $userDetails['id']; ?>&adminid=<?php echo $_SESSION['user_data']['id']; ?>" id="delYes"><button class="primary_btn" style="padding: 7px 60px;">Yes</button></a>
                                    <a href=""><button class="btn btn-primary" style="padding: 7px 60px; background-color: #0073B6; float:right">No</button></a>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <h3 class="header-title  mb-2">User Profile</h3>
                    <div class="card text-center">
                        <div class="card-body">
                            <!-- <img src="<?php // echo base_url(); 
                                            ?>/assets/images/users/user-1.jpg" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">

                                    <h4 class="mb-0"> <?php // echo $userDetails['firstName']; 
                                                        ?></h4>
                                    <p class="text-muted"><?php // echo $userDetails['email']; 
                                                            ?></p> -->

                            <!-- <button type="button" class="btn btn-success btn-xs waves-effect mb-2 waves-light">Follow</button> -->
                            <!-- <button type="button" class="btn btn-danger btn-xs waves-effect mb-2 waves-light">Message</button> -->
                            <div class="row">
                                <div class="text-start col-md-8">
                                    <p class="text-muted mb-2 font-13"><strong class="text-dark">Full Name :</strong> <span class="ms-2"><?php echo $userDetails['firstName'] . " " . $userDetails['lastName']; ?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong class="text-dark">Mobile :</strong><span class="ms-2"><?php echo $userDetails['phone']; ?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong class="text-dark">Email :</strong> <span class="ms-2"><?php echo $userDetails['email']; ?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong class="text-dark">Investment Amount: </strong> $<?php echo $userDetails['initialInvestment'] ?></p>
                                </div>
                                <div class="col-md-4">
                                    <div style="position: absolute; bottom: 30px; right: 20px;">
                                        <button type="button" id="editprofilebutton" class="primary_btn" data-bs-toggle="modal" data-bs-target="#editProfilemodal" value="<?php echo $userDetails['id'] ?>">Edit User Profile</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="header-title mt-4 mb-2">Update Total Investment</h4>
                    <div class="card">
                        <div class="card-body">
                            <!-- <p class="text-muted font-13">More complex layouts can also be created with the grid -->
                            <!-- system.</p> -->
                            <form action="<?php echo base_url(); ?>/admin/addInvestment" method="POST">
                                <div class="row mt-3">
                                    <input type="hidden" name="id" value="<?php echo $userDetails['id']; ?>">
                                    <div class="mb-3 col-md-3">
                                        <label for="Amount" class="form-label">Initial Investment</label>
                                        <input type="number" class="form-control" step="0.01" name="amount" value="<?php echo $userDetails['initialInvestment'] ?>" required>
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label for="date" class="form-label">Payout Date</label>
                                        <input type="date" class="form-control" name="payoutdate" value="<?php echo $userDetails['payoutDate'] ?>">
                                    </div>
                                    <!-- <div class="mb-3 mt-3 col-md-3">
                                        <input type="radio" id="paos" name="transaction" value="POAS" <?php echo ($userDetails['transactionType'] == 'POAS') ? 'checked' : '' ?> required>
                                        <label>Pay out split amount</label><br>
                                        <input type="radio" id="roi" name="transaction" value="ROI" <?php echo ($userDetails['transactionType'] == 'ROI') ? 'checked' : '' ?>>
                                        <label>Amount to ROI</label>
                                    </div>
                                    <div class="mb-3 mt-3 col-md-3">
                                        <input type="radio" id="paos" name="payout" value="1" <?php echo ($userDetails['returntype_id'] == '1') ? 'checked' : '' ?> required>
                                        <label>Return Full Investment</label><br>
                                        <input type="radio" id="roi" name="payout" value="2" <?php echo ($userDetails['returntype_id'] == '2') ? 'checked' : '' ?>>
                                        <label>No Return</label>
                                    </div> -->
                                    <div class="mb-3 col-md-3">
                                        <label for="payout_per" class="form-label">Payout Split Percentage</label>
                                        <input type="number" id="payout_per" class="form-control" name="payout_per" value="<?php echo $userDetails['payout_per'] ?>">
                                        <p class="mt-2" id="payput_Percentage_Message" style="font-size: 16px; color:white;"></p>
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label for="next_payout" class="form-label">Next Payout Date</label>
                                        <input type="date" class="form-control" name="nextpayoutdate" value="<?php echo $userDetails['nextpayoutDate'] ?>">
                                    </div>
                                    <div class="col-md-4 margin-top:10px;">
                                        <input type="hidden" name="showtoaccount" value="N">
                                        <input type="checkbox" name="showtoaccount" value="Y" <?php echo ($userDetails['flagfor_accountant'] == 'Y') ? 'checked' : '' ?>>
                                        <label for="showtoaccount" class="form-label">Show To Accountant</label>
                                    </div>
                                    <div class="col-md-2">
                                        <button style="width:100%; border: 1px solid #000000; background-color: #000000;" id="updateBtn" type="submit" class="btn btn-primary waves-effect waves-light">Update </button>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div> <!-- end card-->

                    <div class="card mt-4">
                        <div class="card-body">
                            <form action="<?php echo base_url(); ?>/admin/addPayouts" method="POST">
                                <div class="row mt-3">
                                    <input type="hidden" name="id" value="<?php echo $userDetails['id']; ?>">
                                    <div class="mb-3 col-md-5">
                                        <label for="Amount" class="form-label">Payout Amount</label>
                                        <input type="number" class="form-control" step="0.01" name="amount" value="" required>
                                    </div>
                                    <div class="mb-3 col-md-5">
                                        <label for="date" class="form-label">Payout Date</label>
                                        <input type="date" class="form-control" name="payoutdate" value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                    <div class="mt-3 col-md-2">
                                        <button style="width:100%;margin-top:4px;" id="submitBtn" type="submit" class="primary_btn">Submit </button>
                                    </div>
                                </div>
                            </form>
                            <h5 class="mt-0">Payouts:</h5>
                            <div class="table-responsive">

                                <table class="table table-centered mb-0" id="btn-editable" data-page-size="2">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Amount</th>
                                            <th>Payout Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <?php foreach ($payoutInfo as $singlepayout) : ?>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $singlepayout['id'] ?></td>
                                                <td><?php echo $singlepayout['amount'] ?></td>
                                                <td> <?php echo $singlepayout['payoutdate'] ?></td>
                                                <td>
                                                    <button type="button" id="editbutton" class="btn btn-sm btn-dark edit_payout_button" data-bs-toggle="modal" data-bs-target="#editPayoutmodal" value="<?php echo $singlepayout['id'] ?>"><span class="mdi mdi-pencil"></button>
                                                    <a href="<?php echo base_url(); ?>/admin/deletePayouts?id=<?php echo $singlepayout['id'] . "&" . "userid=" . $singlepayout['user_id']; ?>"><button type="button" class="btn btn-sm btn-dark delete_btn" value=""><span class="mdi mdi-delete"></button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                    <h4 class="header-title mt-4 mb-2">Enter profit/Loss</h4>
                    <div class="card">
                        <div class="card-body">

                            <!-- <p class="text-muted font-13">More complex layouts can also be created with the grid -->
                            <!-- system.</p> -->
                            <form id="formProfitLoss" method="POST">
                                <input type="hidden" id="id" name="id" value="<?php echo $userDetails['id']; ?>">
                                <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="Actions" class="form-label">Actions</label>
                                        <select name="action" id="dropDown" class="form-select" required>
                                            <option>Profit</option>
                                            <option>Loss</option>
                                            <option value="0">Swing</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Amount" class="form-label">Amount</label>
                                        <input type="number" id="fix_value" step="0.01" class="form-control" name="amount" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" value="<?= date("Y-m-d"); ?>" class="form-control" name="date" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="primary_btn" style="width:100%;margin-top:29px;">Submit </button>
                                    </div>
                                    <p id="profitMessage"></p>

                                </div>
                            </form>
                            <!-- <div class="pt-2 pb-2" style="text-align: center;">
                                <a href="<?php echo base_url(); ?>/admin/scheduleProfitLoss?userid=<?php echo $userDetails['id']; ?>">
                                    <button id="schedulaBtn" type="submit" class="btn btn-success waves-effect waves-light" style="background-color: #0073B6; padding: 7px 50px;">Schedule </button>
                                </a>
                            </div> -->

                        </div> <!-- end card-body -->
                    </div> <!-- end card-->

                    <!-- Modal for Edit -->
                    <div class="modal fade" id="centermodal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myCenterModalLabel">Edit Information</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-danger" id="Message"></p>
                                    <form action="" id="editModalForm" method="POST">

                                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $userDetails['id']; ?>">
                                        <input type="hidden" name="profit_id" id="profit_id" value="">
                                        <div class="mb-3">
                                            <label for="Actions" class="form-label">Actions</label>
                                            <select name="action" class="form-select" required>
                                                <option value="">Choose</option>
                                                <option value="Profit">Profit</option>
                                                <option value="Loss">Loss</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="Amount" class="form-label">Amount</label>
                                            <input type="number" step="0.01" class="form-control" name="amount" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="date" class="form-label">Date</label>
                                            <input type="date" class="form-control" name="date" required>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Update </button>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <!-- Modal for Edit Payout -->
                    <div class="modal fade" id="editPayoutmodal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myCenterModalLabel">Edit Information</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?php echo base_url(); ?>/admin/editPayout?id=" id="editModalpayout" method="POST">

                                        <input type="hidden" name="user_id" value="<?php echo $userDetails['id']; ?>">
                                        <div class="mb-3">
                                            <label for="Amount" class="form-label">Amount</label>
                                            <input type="number" step="0.01" class="form-control" name="amount" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="date" class="form-label">Date</label>
                                            <input type="date" class="form-control" name="payoutdate" required>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Update </button>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <div class="modal fade" id="editProfilemodal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myCenterModalLabel">Edit User Profile</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pt-0">
                                    <form id="editProfileModalform" method="POST">
                                        <P class="text-danger" id="showMessage"></P>
                                        <input type="hidden" id="first" value="<?php echo $userDetails['id']; ?>">
                                        <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
                                        <div class="mb-2">
                                            <label for="Amount" class="form-label">First Name</label>
                                            <input type="text" id="name" class="form-control" name="firstname" value="<?php echo $userDetails['firstName']; ?>" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="Amount" class="form-label">Last Name</label>
                                            <input type="text" id="last" class="form-control" name="lastname" value="<?php echo $userDetails['lastName']; ?>" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="Amount" class="form-label">Phone</label>
                                            <input type="phone" id="phone" class="form-control" name="phone" value="<?php echo $userDetails['phone']; ?>" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="Amount" class="form-label">Email</label>
                                            <input type="text" id="email" class="form-control" name="email" value="<?php echo $userDetails['email']; ?>" required>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light" style="background-color: #0073B6;">Update </button>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <!-- Modal for delete -->
                    <div class="modal fade" id="centermodal2" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myCenterModalLabel">Really want to delete</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <a href="<?php echo base_url(); ?>/admin/deleteProfit?userid=<?php echo $userDetails['id']; ?>&id=" id="delYesProfit"><button class="btn btn-danger">Yes</button></a>
                                    <a href=""><button class="btn btn-info">No</button></a>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <h4 class="header-title mt-4 mb-2"><?php echo $userDetails['firstName']; ?> Transaction records:</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="sub-header">
                                        Following are the detail records of <?= $userDetails['firstName'] . "'s"; ?> transactions
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <div class="row row-cols-sm-auto" style="float: right;">
                                            <div class="col-12">
                                                <input id="demo-foo-search" type="text" placeholder="Search" class="form-control form-control-sm" autocomplete="on">
                                            </div>
                                            <div class="col-12 text-sm-end">
                                                <select id="demo-foo-filter-status" class="form-select form-select-sm">
                                                    <option value="">Show all</option>
                                                    <option value="Profit">Profit</option>
                                                    <option value="Loss">Loss</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table id="demo-foo-filtering" class="table toggle-circle mb-0" data-page-size="10">
                                    <thead style="background-color: #F2F2F2;">
                                        <tr>
                                            <th>Profit/Loss</th>
                                            <th data-hide="phone">Date</th>
                                            <th>Amount</th>
                                            <th data-hide="phone">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($profitLossDetails)) : ?>
                                            <?php foreach ($profitLossDetails as $singleDetail) : ?>
                                                <tr>
                                                    <td name="type"><?php echo $singleDetail['type']; ?></td>
                                                    <td><?php echo date('M d, Y', strtotime($singleDetail['publishDate'])); ?>
                                                        <?php if ($singleDetail['schedule'] == 'Y') : ?>
                                                            <span class="badge label-table bg-warning" style="font-size: 12px; padding: 4px 8px; font-family: text;"> Scheduled</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($singleDetail['type'] == 'Profit') : ?>
                                                            <i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 23px; color: #1ABC9C;"></i> &nbsp; $<?php echo $singleDetail['amount']; ?>
                                                        <?php else : ?>
                                                            <i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 23px; color: #D06162;"></i> &nbsp; $<?php echo $singleDetail['amount']; ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm edit_btn" style="box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15); border-radius:5px; margin-right: 6px;" data-bs-toggle="modal" data-bs-target="#centermodal" value="<?php echo $singleDetail['id'] ?>"><b><span class="mdi mdi-pencil" style="color: black; font-size: 16px;"></b></button>
                                                        <button type="button" class="btn btn-sm delete_btn" style="box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15); border-radius:5px;" data-bs-toggle="modal" data-bs-target="#centermodal2" value="<?php echo $singleDetail['id'] ?>"><b><span class="mdi mdi-delete" style="color: black; font-size: 16px;"></b></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <h3 style="text-align: center;">No Profit/Loss found</h3>
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

                    <h4 class="header-title mt-4 mb-2">Conversation with <?php echo $userDetails['firstName'] . " " . $userDetails['lastName']; ?></h3>
                    <div class="card">
                        <div class="card-body">
                            <div class="col-lg-12" style="text-align: end;">
                                <?php $date; foreach ($allChat as $singleMessage) : ?>
                                    <?php if(!isset($date) || $date !== date('d M Y', strtotime($singleMessage['createdAt']))): ?>
                                        <div class="row text-center">
                                            <span class="line">
                                                <h2><span><?=date('l, d M Y', strtotime($singleMessage['createdAt'])); ?></span></h2>
                                            </span>
                                        </div>
                                    <?php $date=date('d M Y', strtotime($singleMessage['createdAt'])); endif; ?>
                                    <?php if ($singleMessage['msgFrom'] != 'Admin') : ?>
                                        <div class="mb-1">
                                            <div style="width:100%; float:left;">
                                                <div style="float: left;">
                                                    <img src="<?php echo base_url(); ?>/assets/images/users/user-1.jpg" alt="Avatar" style="width: 40px; border-radius:40px;">
                                                </div>
                                                <span class="time-left" style="display: block; padding-left:60px; text-align:left; font-size: 11px;">
                                                <?php echo '<b>'.$userDetails['firstName'].' </b>&nbsp'; echo date('g:i A', strtotime($singleMessage['createdAt'])); ?></span>
                                                <div style="margin-left: 10px; float:left; max-width:70%;">
                                                    <p style=" padding:5px 10px; text-align: start; color:#333333e0; margin-bottom:5px; border-radius:20px;">
                                                        <?php echo $singleMessage['message']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php elseif ($singleMessage['msgFrom'] == 'Admin') : ?>
                                        <div class="mb-1">
                                            <div style="width:100%; float:right;">
                                                <div style="float: right; margin-left:10px;">
                                                    <img src="<?php echo base_url(); ?>/assets/images/users/user-1.jpg" alt="Avatar" style="width: 40px; border-radius:40px;">
                                                </div>
                                                <span class="time-right" style="display: block; padding-right:60px; font-size: 11px;"><?php echo date('g:i A', strtotime($singleMessage['createdAt'])); ?></span>
                                                <div style="float:right; max-width:70%;">
                                                    <p style="text-align: left; padding:5px 10px; color:#333333e0; margin-bottom:5px; border-radius:20px;">
                                                        <?php echo $singleMessage['message']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <div class="mb-3 mt-5" style="display: inline-block; width: 90%; margin:auto; text-align:start;">
                                    <form action="<?php echo base_url(); ?>/admin/submitMessage" method="POST">
                                        <input type="hidden" name="userid" value="<?php echo $userDetails['id']; ?>" />
                                        <textarea class="form-control" name="sendingMesage" placeholder="Message" rows="1" style="width:85%; float:left; margin:auto; border-radius:20px; background-color: #F2F2F2; color:black;" required></textarea>
                                        <button class="save btn btn-primary waves-effect waves-light" type="submit" style="border-radius:30px; padding: 6px 10px; margin-left:8px; background-color:#008DFF;">
                                            <i class="fa fa-paper-plane" style="color:white; font-size:14px;"></i></button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div> <!-- end card -->
                    <div style="text-align: right;">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#centermodal3" class="btn btn-danger delete_btn">Delete User</button>
                    </div>
                </div> <!-- container -->
            </div> <!-- content -->
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <?php echo view("/home/footer-scripts"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/modalWorking.js"></script>
    <script src="<?= base_url(); ?>/assets/js/addProfitLoss.js"></script>

</body>

</html>