<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KYC/KYB - <?php echo APP_NAME ?></title>
  <?php echo view("/home/new-header-links"); ?>
 
</head>
 
<body>
<svg style="width: 0; height: 0; position: absolute;">
    <defs>
      <linearGradient id="Gradient2" x1="0" x2="0" y1="0" y2="1">
        <stop offset="0%" stop-color="#6B788E" />
        <stop offset="100%" stop-color="#6B788E" stop-opacity="0" />
      </linearGradient>
    </defs>
  </svg>
  <div class="app_wrapper">

    <?php echo view("/home/left-sidebar-new"); ?>


        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <main class="main">
                <!-- Start Content-->
                <div class="container-fluid">
            <div class="row">
                    <div class="col-sm-12">
                        <h4 class="header-title mb-2">KYC/KYB Client</h4>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="demo-foo-filtering" style="text-align: center; margin-top: 10px;" class="table toggle-circle mb-0" data-page-size="15">
                                        <thead style="background-color: #F2F2F2;">
                                        <tr>
                                        <th class="all-cutomers-t__col--head">Name</th>
                                        <th class="all-cutomers-t__col--head">Joining Date</th>
                                        <th class="all-cutomers-t__col--head">Type</th>
                                        <th class="all-cutomers-t__col--head">Documents Status</th>
                                        <th class="all-cutomers-t__col--head">Action</th>
                                        <th class="all-cutomers-t__col--head">View File</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(sizeof($kycClients) > 0): ?>
                                        <?php for($i = 0; $i< sizeof($kycClients);$i++): ?>

                                            <tr>
                                                <td style="color: var(--card-sub-heading-color);padding: 0px;padding-top: 20px;padding-left: 6px;"><?php echo $kycClients[$i]['firstName']." ".$kycClients[$i]['lastName'] ?></td>
                                                <td style="color: var(--card-sub-heading-color);padding: 0px;padding-top: 20px;padding-left: 6px;"><?php echo date('M d, Y', strtotime($kycClients[$i]['joiningData'])); ?></td>
                                                <td style="color: var(--card-sub-heading-color);padding: 0px;padding-top: 20px;padding-left: 6px;"><?php echo $kycClients[$i]['type'] ?></td>
                                                <td style="color: var(--card-sub-heading-color);padding: 0px;padding-top: 20px;padding-left: 6px;"><?php if($kycClients[$i]['user_kyc_flag'] == "N"){ echo "Not Submitted"; }else { echo "Submitted"; } ?></td>
                                                <td style="color: var(--card-sub-heading-color);padding: 0px;padding-top: 20px;padding-left: 6px;"><?php if($kycClients[$i]['user_kyc_flag'] == "N"){ echo "Not Submitted"; }elseif($kycClients[$i]['user_kyc_flag'] == "PA") { echo "Pending"; }elseif($kycClients[$i]['user_kyc_flag'] == "NA"){echo "Not Approved";}elseif($kycClients[$i]['user_kyc_flag'] == "A"){echo "Approved";}  ?></td>
                                                <td style="padding: 0px;padding-top: 10px;padding-left: 6px;">
                                                <a <?php if($kycClients[$i]['user_kyc_flag'] != "N"): ?> href="<?= base_url(); ?>/admin/kyc_documents_by_user?userid=<?php echo $kycClients[$i]['id']; ?>"<?php else: ?> href="#" <?php endif; ?>><button style="margin-bottom: 10px;" class="document_btn">View</button></a>
                                            </td>
                                            </tr>
                                            <?php 
                                            endfor;
                                            endif; ?>
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
        

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


                                        </main>
    <!-- END wrapper -->

    <?php echo view("/home/new-footer-scripts"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/modalWorking.js"></script>
    <script src="<?= base_url(); ?>/assets/js/addProfitLoss.js"></script>

</body>

</html>