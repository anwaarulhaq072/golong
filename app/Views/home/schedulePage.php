<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Schedule Page - <?php echo APP_NAME ?></title>
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

        <div class="content-page">
            <div class="content-page" style="margin-left: unset;">
                <div class="content">
                    <!-- Start Content-->
                    <div class="container-fluid">

                        <h4 class="header-title mb-3">Profit And Loss Scheduler</h4>
                        <div class="card">
                            <div class="card-body">

                                <!-- <p class="text-muted font-13">More complex layouts can also be created with the grid -->
                                <!-- system.</p> -->
                                <form id="submitSchedule" method="POST">
                                    <input type="hidden" id="id" name="id" value="<?php echo $userId; ?>">
                                    <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                                    <?php $j = 0; ?>

                                    <div class="row cover">
                                        <div class="mb-3 col-md-4">
                                            <select name="action" id="dropDown" class="form-select amt_option" required>
                                                <?php if (isset($profitLossData[$j]['publishDate']) && strtotime($profitLossData[$j]['publishDate']) >= strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "00:00:00") && strtotime($profitLossData[$j]['publishDate']) <= strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "23:59:59")) : ?>
                                                    <option selected disabled><?php echo $profitLossData[$j]['type']; ?></option>
                                                <?php endif; ?>
                                                <option value="profit">Profit</option>
                                                <option value="loss">Loss</option>
                                                <option value="0">Swing</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <input type="number" placeholder="Amount" step="0.01" class="form-control fix_value" name="amount" value="<?php if (isset($profitLossData[$j]['publishDate']) && strtotime($profitLossData[$j]['publishDate']) >= strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "00:00:00") && strtotime($profitLossData[$j]['publishDate']) <= strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "23:59:59")) {
                                                                                                                                                            echo $profitLossData[$j]['amount'];
                                                                                                                                                            $j++;
                                                                                                                                                        } ?>">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <input type="date" value="<?php echo date("Y-m-d", strtotime(date("Y-m-d"))); ?>" class="form-control" name="date" readonly>
                                        </div>
                                        <!-- <input type="text" name="input" value="" /> -->
                                    </div>

                                    <?php
                                    $datediff = 0;
                                    $currentDate = date("Y-m-d");
                                    $arylen = count($profitLossData);
                                    if (isset($profitLossData[$arylen - 1])) {
                                        $diffrence = strtotime($profitLossData[$arylen - 1]['publishDate']) - strtotime($currentDate);
                                        $datediff = ceil($diffrence / (60 * 60 * 24));
                                    } ?>

                                    <?php

                                    for ($x = 0; $x < $datediff; $x++) : ?>
                                        <?php $dateloop = date("Y-m-d", strtotime(date("Y-m-d") . " +" . ($x + 1) . " day")); ?>
                                        <div class="row cover">
                                            <div class="mb-3 col-md-4">
                                                <select name="action" id="dropDown" class="form-select amt_option" value="" required>
                                                    <?php if (isset($profitLossData[$j]['publishDate']) && strtotime($profitLossData[$j]['publishDate']) >= strtotime($dateloop . "00:00:00") && strtotime($profitLossData[$j]['publishDate']) <= strtotime($dateloop . "23:59:59")) : ?>
                                                        <option selected disabled><?php echo $profitLossData[$j]['type']; ?></option>
                                                    <?php endif; ?>
                                                    <option value="profit">Profit</option>
                                                    <option value="loss">Loss</option>
                                                    <option value="0">Swing</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <input type="number" placeholder="Amount" step="0.01" class="form-control fix_value" name="amount" value="<?php if (isset($profitLossData[$j]['publishDate']) && strtotime($profitLossData[$j]['publishDate']) >= strtotime($dateloop . "00:00:00") && strtotime($profitLossData[$j]['publishDate']) <= strtotime($dateloop . "23:59:59")) {
                                                                                                                                                                echo $profitLossData[$j]['amount'];
                                                                                                                                                                $j++;
                                                                                                                                                            } ?>">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <input type="date" value="<?php echo $dateloop ?>" class="form-control" name="date" readonly>
                                            </div>
                                            <!-- <input type="text" name="input" value="" /> -->
                                        </div>
                                    <?php endfor; ?>

                                    <div class="col-md-3">
                                        <button type="submit" id="submit" class="btn btn-success waves-effect waves-light" style="position: fixed; z-index:1;bottom: 10px;">Update </button>
                                    </div>
                                </form>
                                <div class="mt-2" style="text-align: right;">
                                    <button class="btn btn-primary" style="background-color: #0073B6;" id="addMoreBtn">Add More </button>
                                </div>
                            </div> <!-- end card-body -->
                        </div> <!-- end card-->
                        <!-- end row -->
                    </div> <!-- container -->
                </div> <!-- content -->
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div> <!-- END wrapper -->


    <?php echo view("/home/footer-scripts"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/schedule.js"></script>

</body>

</html>