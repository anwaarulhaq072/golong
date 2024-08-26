<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Update Bulk Records - <?php echo APP_NAME ?></title>
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

<!-- body start -->

<body class="loading"
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}}'>

    <!-- Begin page -->
    <div id="wrapper">
    <?php echo view("/home/left-sidebar"); ?>
        <!-- include Top-bar -->
        <?php echo view("/home/top-bar" , $notification) ?>

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page" >
                <div class="content-page" style="margin-left: unset;">
                    <div class="content">
                        <div id="full-screen-loader">
                            <div class="spinner-grow avatar-lg text-secondary m-2" role="status"></div>
                        </div>
                        <div class="alert alert-success text-center" id="success_bar">
                            <strong>All records updated successfully</strong>
                        </div>
                        <!-- Start Content-->
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-12">
                                <h4 class="header-title mb-3">Update Bulk Records</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- <h4 class="header-title mb-4">Update Bulk Records</h4> -->


                                            <!-- <p class="text-muted font-13">More complex layouts can also be created with the grid -->
                                            <!-- system.</p> -->
                                            <form id="submitBulkUpdate" method="POST">
                                                <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">

                    
                                                <!-- <p id="message"></p> -->
                                                <div class="alert alert-primary" role="alert" id="message" style="padding: 5px;">
                                                Some Records already exist for this date. Instead of creating new records, they will be updated in the database.
                                                    </div>
                                                <div class="row">
                                                <div class="mb-3 col-md-3">
                                                    <input type="date" id="dateRangeSelector"
                                                        value="<?php echo date("Y-m-d", strtotime(date("Y-m-d"))); ?>"
                                                        class="form-control" name="date">

                                                </div>
                                                <div class="mb-3 col-md-3 offset-md-3">
                                                            <select name="action1" id="dropDownforall" onchange="dropdownvalue()"
                                                                class="form-select amt_option_for_all">
                                                                <option value="Profit">Profit</option>
                                                                <option value="Loss">Loss</option>
                                                                <option value="Swing">Swing</option>
                                                            </select>
                                                        </div>
                                                 <div class="mb-3 col-md-3">
                                                            <input type="number" class="form-control allpercentage" name="allpercentage" id="allpercentage" step="any"
                                                                value="" placeholder="Enter Percentage for all fields" onkeyup="Change_all_percentage()">
                                                        </div>
                                                        </div>
                                                <!-- <div class=" justify-content-center">
                                                <div class="col-4">

                                                </div>

                                            </div> -->
                                                <div class="bulkDataContainer">
                                                    <?php
                                                for ($j = 0; $j < sizeof($bulkData); $j++) :
                                                ?>
                                                    <div class="row cover">
                                                        <input type="hidden" id="id<?php echo $j ?>" name="id"
                                                            value="<?php echo $bulkData[$j]['id']; ?>">
                                                        <div class="mb-3 col-md-3">
                                                            <input type="text" class="form-control name" name="name"
                                                                value="<?php echo $bulkData[$j]['firstName'] . " " . $bulkData[$j]['lastName']; ?>">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <select name="action" id="dropDown"
                                                                class="form-select amt_option" required>
                                                                <option value="Profit"
                                                                    <?= $bulkData[$j]['TYPE'] == 'Profit' ? ' selected="selected"' : ''; ?>>
                                                                    Profit</option>
                                                                <option value="Loss"
                                                                    <?= $bulkData[$j]['TYPE'] == 'Loss' ? ' selected="selected"' : ''; ?>>
                                                                    Loss</option>
                                                                <option value="Swing"
                                                                    <?= $bulkData[$j]['TYPE'] == 'Swing' ? ' selected="selected"' : ''; ?>>
                                                                    Swing</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <input type="number" placeholder="Amount" step="any"
                                                                class="form-control fix_value" name="amount" id="amountfield<?php echo $j ?>"
                                                                value="<?php echo $bulkData[$j]['amount']; ?>"
                                                                <?php if ($bulkData[$j]['TYPE'] == 'Swing') :
                                                                                                                                                                                                                ?>readonly<?php endif ?>>
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <input type="number" placeholder="Percentage" step="any"
                                                                class="form-control percentage" min="0"
                                                                name="percentage"
                                                                value="<?php echo $bulkData[$j]['percentage']; ?>"
                                                                <?php if ($bulkData[$j]['TYPE'] == 'Swing') :
                                                                                                                                                                                                                ?>readonly<?php endif ?>>
                                                        </div>

                                                    </div>
                                                    <?php endfor; ?>
                                                    <!-- <input type="text" name="input" value="" /> -->
                                                </div>
                                                <div class="col-md-12 mt-4" style="text-align: center;">
                                                    <button type="submit" id="submit" class="btn btn-success waves-effect waves-light" style="padding: 7px 57px; background-color: #0073B6;">Update Now</button>
                                                </div>
                                            </form>
                                        </div> <!-- end card-body -->
                                    </div> <!-- end card-->
                                </div> <!-- end col -->
                            </div>
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
    <script src="<?php echo base_url(); ?>/assets/js/bulkUpdate.js"></script>
    <script>
        $('#success_bar').hide();
        $('#full-screen-loader').hide();
        function Change_all_percentage() {
           var r = $('#allpercentage').val();
           $('.percentage').val(r);
        }
        function dropdownvalue() {
           var value = $('#dropDownforall').val();
           $('.amt_option').val(value);
        }
    </script>

</body>

</html>