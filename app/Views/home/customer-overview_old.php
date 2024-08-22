<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>User Dashboard - <?php echo APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nvest Clients - Where you can invest" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php echo view("/home/header-links"); ?>

    <style>
    
        .year{
            font-size: 55px;
            color: black;
            font-weight: bold;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }
        .info{
            border-right: 2px solid #ECF0F1;
        }
        .label{
            letter-spacing: 1px;
            font-weight: 600;
        }
        @media screen and (max-width: 800px) {
            .year {
                font-size: 35px;
            }
        }
        @media screen and (max-width: 767px) {
            .year {
                font-size: 45px;
            }
            .info1{
                border-bottom: 2px solid #ECF0F1;
            }
            .info{
                border-right: 0px;
            }
        }
        @media screen and (max-width: 660px) {
            .year {
                font-size: 45px;
            }
        }
        @media screen and (max-width: 460px) {
            .year {
                font-size: 35px;
            }
        }
        </style>
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
        <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
        <div class="content-page" style=" background-color: #F5F5FC !important;">
            <div class="content" style="margin-top: 50px;">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- <h4 class="header-title mb-2"> Overview of 2022</h4> -->
                            <div class="card">
                                <div class="card-body" style="padding:0px;">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-12 info">
                                            <div class="info1">
                                                <div class="mx-4 mt-4">
                                                    <!--<h4 class="label text-uppercase">Archive History</h4>-->
                                                    <h1 class="year">Archive History<br>2022</h1>
                                                </div>
                                                <div class="mx-4">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <h5 class="label">Total Payouts</h5>
                                                            <h2 class="col-lg-10 col-sm-12 my-1 amount" style="border-bottom: 2px solid #0073B6 ;">$<?php echo $payoutAll?></h2>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <h5 class="label">Total Profit</h5>
                                                            
                                                            <h2 class="col-lg-10 col-sm-12 my-1 amount" style="border-bottom: 2px solid #1ABC9C;">$<?php if($profitLoss > 0) : echo $profitLoss ; else : echo 0; endif;?> </h2>
                                                        </div>
                                                    </div>
                                                    <div class="row my-3">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <h5 class="label">Total Positions</h5>
                                                            <h2 class="col-lg-10 col-sm-12 my-1 amount" style="border-bottom: 2px solid #BC1D1E ;"><?php echo sizeof($profitLossDetails); ?></h2>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <h5 class="label">Percentage Profit</h5>
                                                            <h2 class="col-lg-10 col-sm-12 my-1 amount" style="border-bottom: 2px solid #ED6B23;"><?php if($profitLoss > 0) : echo (($profitLoss)/$initial)*100 ; else: echo 0; endif ;?>%</h2>
                                                            <!-- <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div id="cardCollpase1" class="mx-2 mt-3 show">
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
                                                            <p class="text-success font-13 mb-0 text-truncate">Profit</p>
                                                        </div>
                                                        <div class="col-4">
                                                            <?php
                                                                $losing = 0;
                                                                if($totalLossNum){
                                                                    $losing = number_format((float)(($totalLossNum / (float)sizeof($profitLossDetails) ) * 100), 1, '.', '');
                                                                }
                                                            ?>
                                                            <h3> <span data-plugin="counterup"><?php echo $losing; ?></span>%</h3>
                                                            <p class="text-danger font-13 mb-0 text-truncate">Losing</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="apex-pie-2" class="apex-charts mb-3" data-colors="#6658dd,#4fc6e1,#4a81d4,#00b19d,#f1556c"></div>
                                        </div>
                                    </div>
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

    <script src="<?php echo base_url(); ?>/assets/js/pages/apexcharts1.init.js"></script>
</body>


</html>