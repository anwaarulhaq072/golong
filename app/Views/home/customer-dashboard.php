<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Client Dashboard - <?php echo APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nvest Clients - Where you can invest" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <?php echo view("/home/header-links"); ?>
    <style>
        .graph_style{
            height: 600px;
        }
    </style>
</head>

<!-- body start -->

<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}}'>
    <!-- Begin page -->
    <div id="wrapper">

        <?php echo view("/home/left-sidebar"); ?>
        <!-- include Top-bar -->
        <?php if (isset($callChartAdmin) && $callChartAdmin == true) : ?>
            <?php
            $data = [];
            $data['notification'] =  $notification;
            $data['admin'] = 'Y';
            echo view("/home/top-bar", $data); ?>
        <?php else : ?>
            <?php echo view("/home/top-bar", $notification) ?>
        <?php endif; ?>


        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->


        
        <div class="content-page" style=" background-color: #F5F5FC !important;">
            <div class="content" style="margin-top: 50px;">
                <?php if (isset($callChartAdmin) && $callChartAdmin == true) : ?>
                    <a href="<?php echo base_url(); ?>"><button style="margin-bottom: 10px;" class="btn btn-primary">Back</button></a>
                    <a href="<?php echo base_url()."/admin/report_genrate?userid=".$_GET['userid']; ?>"><button style="margin-bottom: 10px;" class="btn btn-primary">Client Statement</button></a>
                    <?php if (array_key_exists(0,$tax_form_data)) : ?>
                    <a href="<?php echo base_url()."/admin/admin_tax_form?userid=".$_GET['userid']; ?>"><button style="margin-bottom: 10px;" class="btn btn-primary">Tax Form</button></a>
                    <?php endif; ?>
                    <input type="hidden" id="forChartUserId" value="<?php echo $userInfo['id']; ?>">               
                <?php endif; ?>
                <!-- Start Content-->
                <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
                <input type="hidden" id="user_id" value="<?php if(isset($_GET['userid'] )) echo $_GET['userid'] ? $_GET['userid'] : $_SESSION['user_data']['id']; else $_SESSION['user_data']['id'];?>">
                <!-- <input type="hidden" id="user_id" value="<?php //echo $_SESSION['user_data']['id']; ?>"> -->

                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <i class="fa fa-ellipsis-v text-muted float-end" style="font-size: 16px; padding-top: 5px; color: #333333 !important;" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Investment Amount"></i>
                                <img src="<?= base_url(); ?>/assets/images/pie_chart_icon.png" alt="">
                                <p class="mt-2 mb-1 font-14">Total Balance </p>
                                <h5 class="my-0 text-left">$<span data-plugin="counterup"><?php echo number_format((int)$totalBalance); ?></span></h5>
                            </div>
                        </div>
                    </div>

                    <?php $totalProfit = round((float)($userInfo['initialInvestment'] - ((float)$userInfo['initialInvestment'] - (float)$profitLoss)),2); 
                    $totalProfit = number_format($totalProfit);
                    ?>
                    <div class="col-sm-6 col-md-3">
                        <div class="card" id="tooltip-container">
                            <div class="card-body">
                                <i class="fa fa-ellipsis-v text-muted float-end" style="font-size: 16px; padding-top: 5px; color: #333333 !important;" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Total Profit"></i>
                                <img src="<?= base_url(); ?>/assets/images/pie_chart_icon.png" alt="">
                                <p class="mt-2 mb-1 font-14">Total Profit</p>
                                <?php if($totalProfit < 0): ?>
                                <h5 class="text-success my-0 text-left"><span style="color: #D06162">$</span><span style="color: #D06162" data-plugin="counterup"><?= $totalProfit  ?></span></h5>
                                <?php elseif($totalProfit > 0): ?>
                                <h5 class="text-success my-0 text-left"><span style="color: #1ABFBC">$</span><span style="color: #1ABFBC" data-plugin="counterup"><?= $totalProfit  ?></span></h5>
                                <?php else: ?>
                                <h5 class="text-success my-0 text-left">$<span data-plugin="counterup">0</span></h5>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="card" id="tooltip-container">
                            <div class="card-body">
                                <i class="fa fa-ellipsis-v text-muted float-end" style="font-size: 16px; padding-top: 5px; color: #333333 !important;" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Pending Payout"></i>
                                <img src="<?= base_url(); ?>/assets/images/pie_chart_icon.png" alt="">
                                <p class="mt-2 mb-1 font-14">Pending Payout</p>
                                <h5 class="my-0 text-left">$<span data-plugin="counterup"><?= number_format(round(((float)$pendingWithdraw), 2));  ?></span></h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="card" id="tooltip-container">
                            <div class="card-body">
                                <i class="fa fa-ellipsis-v text-muted float-end" style="font-size: 16px; padding-top: 5px; color: #333333 !important;" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Total Payout"></i>
                                <img src="<?= base_url(); ?>/assets/images/pie_chart_icon.png" alt="">
                                <p class="mt-2 mb-1 font-14">Total payout (till date)</p>
                                <h5 class="my-0 text-left">$<span data-plugin="counterup"><?php echo number_format((int)$payoutAll); ?></span></h5>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-8" id="profitLossChart" >
                        <div class="col-xl-12 col-md-12">
                            <!-- Portlet card -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-widgets">
                                        <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                        <a data-bs-toggle="collapse" href="#cardCollpase3" role="button" aria-expanded="false" aria-controls="cardCollpase3"><i class="mdi mdi-minus"></i></a>
                                        <!-- <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a> -->
                                    </div>
                                    <h4 class="header-title mb-0">Profit & Loss Chart</h4>
                                    <div id="cardCollpase3" class="collapse pt-3 show" dir="ltr">
                                        <div id="apex-line-2" class="apex-charts" data-colors="#f672a7"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="col-xl-12 col-md-12">
                            <!-- Portlet card -->
                            <div class="card" id="transactionChart" >
                                <div class="card-body" style="height: 540px;">
                                    <div class="card-widgets">
                                        <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                        <a data-bs-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false" aria-controls="cardCollpase1"><i class="mdi mdi-minus"></i></a>
                                    </div>
                                    <h4 class="header-title mb-0">Transactions</h4>

                                    <div id="cardCollpase1" class="collapse pt-3 show">
                                        <div class="text-center">
                                            <div class="row mt-2">
                                                <div class="col-4">
                                                    <h3 data-plugin="counterup"><?php echo sizeof($profitLossDetails); ?></h3>
                                                    <p class="text-dark font-13 mb-0 text-truncate">Positions</p>
                                                </div>
                                                <div class="col-4">
                                                    <?php
                                                        $profitable = 0;
                                                        if($totalProfitNum){
                                                            $profitable = number_format((float)(($totalProfitNum / (float)sizeof($profitLossDetails) ) * 100), 1, '.', '');
                                                        }
                                                    ?>
                                                    <h3> <span data-plugin="counterup"><?php echo $profitable; ?></span>%</h3>
                                                    <p class="text-success font-13 mb-0 text-truncate">Profitable %</p>
                                                </div>
                                                <div class="col-4">
                                                    <?php
                                                        $losing = 0;
                                                        if($totalLossNum){
                                                            $losing = number_format((float)(($totalLossNum / (float)sizeof($profitLossDetails) ) * 100), 1, '.', '');
                                                        }
                                                    ?>
                                                    <h3> <span data-plugin="counterup"><?php echo $losing; ?></span>%</h3>
                                                    <p class="text-danger font-13 mb-0 text-truncate">Losing %</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="apex-pie-2" class="apex-charts mt-4" data-colors="#6658dd,#4fc6e1,#4a81d4,#00b19d,#f1556c"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row d-none d-md-block">
                    <div class="col-sm-12">
                        <h4 class="header-title mt-4 mb-2">Monthly Return(%)</h4>
                        <div class="card">
                            <div class="card-body">
                                <div class="col-2">
                                  <select class="form-control" name="year" id="monthlyReturnYear" style="text-align: center; margin-bottom: 30px; cursor:pointer;">
                                      <?php 
                                            $currentYear = date("Y");
                                            $minYear = 2023;
                                            $noOfYears = $currentYear - $minYear +1;
                                      ?>
                                      <?php for($i=0; $i < $noOfYears; $i++): ?>
                                        <option value="<?php echo $currentYear - $i; ?> "><?php echo $currentYear - $i; ?></option>
                                      <?php endfor; ?>
                                  </select>
                                </div>
                                <table class="tablesaw table mb-0" data-tablesaw-mode="stack">
                                    <thead>
                                        <tr>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"></th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Jan</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Feb</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Mar</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Apr</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">May</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Jun</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Jul</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Aug</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Sep</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Oct</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Nov</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Dec</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td id="t_year"><?php echo $currentYear; ?></td>
                                            <td id="t_jan">
                                                <?php if ($profitLossMonthly[1] == 0) : ?>
                                                    <?php echo $profitLossMonthly[1]; ?>
                                                <?php elseif ($profitLossMonthly[1] > 0) : ?>
                                                    <i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 16px; color: #1ABC9C;"></i>&nbsp; <?php echo $profitLossMonthly[1]; ?>
                                                <?php else : ?>
                                                    <i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 16px; color: #D06162;"></i>&nbsp;<?php echo $profitLossMonthly[1] * -1; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td id="t_feb">
                                                <?php if ($profitLossMonthly[2] == 0) : ?>
                                                    <?php echo $profitLossMonthly[2]; ?>
                                                <?php elseif ($profitLossMonthly[2] > 0) : ?>
                                                    <i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 16px; color: #1ABC9C;"></i>&nbsp; <?php echo $profitLossMonthly[2]; ?>
                                                <?php else : ?>
                                                    <i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 16px; color: #D06162;"></i>&nbsp;<?php echo $profitLossMonthly[2] * -1; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td id="t_mar">
                                                <?php if ($profitLossMonthly[3] == 0) : ?>
                                                    <?php echo $profitLossMonthly[3]; ?>
                                                <?php elseif ($profitLossMonthly[3] > 0) : ?>
                                                    <i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 16px; color: #1ABC9C;"></i>&nbsp; <?php echo $profitLossMonthly[3]; ?>
                                                <?php else : ?>
                                                    <i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 16px; color: #D06162;"></i>&nbsp;<?php echo $profitLossMonthly[3] * -1; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td id="t_apr">
                                                <?php if ($profitLossMonthly[4] == 0) : ?>
                                                    <?php echo $profitLossMonthly[4]; ?>
                                                <?php elseif ($profitLossMonthly[4] > 0) : ?>
                                                    <i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 16px; color: #1ABC9C;"></i>&nbsp; <?php echo $profitLossMonthly[4]; ?>
                                                <?php else : ?>
                                                    <i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 16px; color: #D06162;"></i>&nbsp;<?php echo $profitLossMonthly[4] * -1; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td id="t_may">
                                                <?php if ($profitLossMonthly[5] == 0) : ?>
                                                    <?php echo $profitLossMonthly[5]; ?>
                                                <?php elseif ($profitLossMonthly[5] > 0) : ?>
                                                    <i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 16px; color: #1ABC9C;"></i>&nbsp; <?php echo $profitLossMonthly[5]; ?>
                                                <?php else : ?>
                                                    <i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 16px; color: #D06162;"></i>&nbsp;<?php echo $profitLossMonthly[5] * -1; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td id="t_jun">
                                                <?php if ($profitLossMonthly[6] == 0) : ?>
                                                    <?php echo $profitLossMonthly[6]; ?>
                                                <?php elseif ($profitLossMonthly[6] > 0) : ?>
                                                    <i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 16px; color: #1ABC9C;"></i>&nbsp; <?php echo $profitLossMonthly[6]; ?>
                                                <?php else : ?>
                                                    <i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 16px; color: #D06162;"></i>&nbsp;<?php echo $profitLossMonthly[6] * -1; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td id="t_jul">
                                                <?php if ($profitLossMonthly[7] == 0) : ?>
                                                    <?php echo $profitLossMonthly[7]; ?>
                                                <?php elseif ($profitLossMonthly[7] > 0) : ?>
                                                    <i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 16px; color: #1ABC9C;"></i>&nbsp; <?php echo $profitLossMonthly[7]; ?>
                                                <?php else : ?>
                                                    <i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 16px; color: #D06162;"></i>&nbsp;<?php echo $profitLossMonthly[7] * -1; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td id="t_aug">
                                                <?php if ($profitLossMonthly[8] == 0) : ?>
                                                    <?php echo $profitLossMonthly[8]; ?>
                                                <?php elseif ($profitLossMonthly[8] > 0) : ?>
                                                    <i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 16px; color: #1ABC9C;"></i>&nbsp; <?php echo $profitLossMonthly[8]; ?>
                                                <?php else : ?>
                                                    <i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 16px; color: #D06162;"></i>&nbsp;<?php echo $profitLossMonthly[8] * -1; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td id="t_sep">
                                                <?php if ($profitLossMonthly[9] == 0) : ?>
                                                    <?php echo $profitLossMonthly[9]; ?>
                                                <?php elseif ($profitLossMonthly[9] > 0) : ?>
                                                    <i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 16px; color: #1ABC9C;"></i>&nbsp; <?php echo $profitLossMonthly[9]; ?>
                                                <?php else : ?>
                                                    <i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 16px; color: #D06162;"></i>&nbsp;<?php echo $profitLossMonthly[9] * -1; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td id="t_oct">
                                                <?php if ($profitLossMonthly[10] == 0) : ?>
                                                    <?php echo $profitLossMonthly[10]; ?>
                                                <?php elseif ($profitLossMonthly[10] > 0) : ?>
                                                    <i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 16px; color: #1ABC9C;"></i>&nbsp; <?php echo $profitLossMonthly[10]; ?>
                                                <?php else : ?>
                                                    <i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 16px; color: #D06162;"></i>&nbsp;<?php echo $profitLossMonthly[10] * -1; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td id="t_nov">
                                                <?php if ($profitLossMonthly[11] == 0) : ?>
                                                    <?php echo $profitLossMonthly[11]; ?>
                                                <?php elseif ($profitLossMonthly[11] > 0) : ?>
                                                    <i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 16px; color: #1ABC9C;"></i>&nbsp; <?php echo $profitLossMonthly[11]; ?>
                                                <?php else : ?>
                                                    <i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 16px; color: #D06162;"></i>&nbsp;<?php echo $profitLossMonthly[11] * -1; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td id="t_dec">
                                                <?php if ($profitLossMonthly[12] == 0) : ?>
                                                    <?php echo $profitLossMonthly[12]; ?>
                                                <?php elseif ($profitLossMonthly[12] > 0) : ?>
                                                    <i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 16px; color: #1ABC9C;"></i>&nbsp; <?php echo $profitLossMonthly[12]; ?>
                                                <?php else : ?>
                                                    <i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 16px; color: #D06162;"></i>&nbsp;<?php echo $profitLossMonthly[12] * -1; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td id="t_total">
                                                <?php if ($profitLossMonthly['total'] == 0) : ?>
                                                    <?php echo $profitLossMonthly['total']; ?>
                                                <?php elseif ($profitLossMonthly['total'] > 0) : ?>
                                                    <i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 16px; color: #1ABC9C;"></i>&nbsp; <?php echo $profitLossMonthly['total']; ?>
                                                <?php else : ?>
                                                    <i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 16px; color: #D06162;"></i>&nbsp;<?php echo $profitLossMonthly['total'] * -1; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="header-title mt-4 mb-2">Profit/Loss Transactions List</h4>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="sub-header">Following are the detail records of your transactions</p>
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
                                                        <option value="Profit">Profit</option>
                                                        <option value="Loss">Loss</option>
                                                        <option value="Swing">Swing</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="demo-foo-filtering" class="table toggle-circle mb-0" data-page-size="15">
                                        <thead style="background-color: #F2F2F2;">
                                            <tr>
                                                <th data-hide="">Profit/Loss</th>
                                                <th data-hide="">Date</th>
                                                <th data-hide="">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($profitLossDetails)) : ?>
                                                <?php foreach ($profitLossDetails as $singleDetail) : ?>
                                                    <tr>
                                                        <td><?php echo $singleDetail['type']; ?></td>
                                                        <td><?php echo date('M d, Y', strtotime($singleDetail['publishDate'])); ?></td>
                                                        <td>
                                                            <?php if ($singleDetail['type'] == 'Profit') : ?>
                                                                <i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 23px; color: #1ABC9C;"></i> &nbsp; $<?php echo $singleDetail['amount']; ?>
                                                            <?php else : ?>
                                                                <i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 23px; color: #D06162;"></i> &nbsp; $<?php echo $singleDetail['amount']; ?>
                                                            <?php endif; ?>
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
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    </div> <!-- END wrapper -->


    <?php echo view("/home/footer-scripts"); ?>
    <!-- init js -->
    <?php if (isset($callChartAdmin) && $callChartAdmin == true) : ?>
        <script src="<?php echo base_url(); ?>/assets/js/pages/admincharts.init.js"></script>
    <?php else : ?>
        <script src="<?php echo base_url(); ?>/assets/js/pages/apexcharts.init.js"></script>
    <?php endif; ?>

    <!-- <script src="<?php echo base_url(); ?>/assets/js/notificationModal.js"></script> -->

    <script>
        $("#monthlyReturnYear").change(function(){
            let year = $(this).val();
            let base_url = $("#base_url").val();
            let user_id = $("#user_id").val();
            $.get(base_url + "/user/get_monthly_return?user_id=" + user_id + "&year=" + year, function( data ) {
                let response = JSON.parse(data);
                $("#t_year").text(year);
                profitLossWithIcon('t_jan',response['profitLossMonthly'][1]);
                profitLossWithIcon('t_feb',response['profitLossMonthly'][2]);
                profitLossWithIcon('t_mar',response['profitLossMonthly'][3]);
                profitLossWithIcon('t_apr',response['profitLossMonthly'][4]);
                profitLossWithIcon('t_may',response['profitLossMonthly'][5]);
                profitLossWithIcon('t_jun',response['profitLossMonthly'][6]);
                profitLossWithIcon('t_jul',response['profitLossMonthly'][7]);
                profitLossWithIcon('t_aug',response['profitLossMonthly'][8]);
                profitLossWithIcon('t_sep',response['profitLossMonthly'][9]);
                profitLossWithIcon('t_oct',response['profitLossMonthly'][10]);
                profitLossWithIcon('t_nov',response['profitLossMonthly'][11]);
                profitLossWithIcon('t_dec',response['profitLossMonthly'][12]);
                profitLossWithIcon('t_total',response['profitLossMonthly']['total']);
            });
        });
        
        function profitLossWithIcon(id, value){
            if(value == 0){
                $("#"+id).text(value);
            }else if(value > 0){
                $("#"+id).html('<i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 16px; color: #1ABC9C;"></i>&nbsp;' + value);
            }else{
                $("#"+id).html('<i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 16px; color: #D06162;"></i>&nbsp;' + (value * -1));
            }
        }
        // let height = $("#profitLossChart").height();
        // $("#transactionChart").height(height);
        // console.log(height);
        // $(".message_box").animate({
        //     scrollTop: $('.message_box').prop("scrollHeight")
        // }, 4000);
    </script>
    
</body>

</html>