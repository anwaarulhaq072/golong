<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Documents - <?php echo APP_NAME ?></title>
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
                <div class="container-fluid mt-4">
                <div class="mb-3 mt-5" style="display: inline-block; width: 90%; margin:auto; text-align:start;">
                <?php if($type == 'user'): ?>
                                    <form action="<?php echo base_url(); ?>/user/submit_upload_documents" enctype="multipart/form-data" method="POST">
                                    <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                    <div class="custom-file-container">
                                    <label class="inputFile__label-holder">
                                    <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                                    <input type="hidden" id="userid" name="userid" class="custom-file-input" value="<?php echo $userDetails['id']; ?>">
                                    <span class="inputFile__label">Choose file</span>
                                    <input type="file" name="fileInput" id="fileInput" class="form-control inputFile" style="padding: 13px 25px;">
                                    </label>
                                    <!-- <input type="hidden" id="userid" name="userid" class="custom-file-input" value="<?php echo $userDetails['id']; ?>">
                                        <input type="file" id="fileInput" name="fileInput" class="custom-file-input">
                                        <label for="fileInput" class="custom-file-label">Choose file</label> -->
                                    </div>
                                    <!-- <input type="file" id="fileInput" name="fileInput" class="custom-file-input">  -->
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                    <button class="document_btn" type="submit" style="margin-top: 33px;">Submit</button>
                                    </div>
                                    </div>
                                    </form>
                <?php elseif($type == 'admin'): ?>
                <form action="<?php echo base_url(); ?>/admin/submit_upload_documents" enctype="multipart/form-data" method="POST">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-1">
                    <label class="inputFile__label-holder">
                    <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                    <input type="hidden" id="userid" name="userid" class="custom-file-input" value="<?php echo $userDetails['id']; ?>">
                    <span class="inputFile__label">Choose file</span>
                    <input type="file" name="fileInput" id="fileInput" class="form-control inputFile" style="padding: 13px 25px;">
                    </label>
                    <!-- <div class="custom-file-container">
                        <input type="file" id="fileInput" name="fileInput" class="custom-file-input">
                        <label for="fileInput" class="custom-file-label">Choose file</label>
                    </div> -->
                    <!-- <input type="file" id="fileInput" name="fileInput" class="custom-file-input">  -->
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-1">
                            <!-- <label for="users">User's: </label> -->
                            <select name="user_id" id="user_id" class="form-control form-select cus-details-input" style="margin-top: 33px;">
                                    <?php if(sizeof($usersList) > 0) for($user = 0;$user < sizeof($usersList);$user++):?>
                                        <option value="<?php echo $usersList[$user]['id'] ;?>"><?php echo ucwords($usersList[$user]['firstName'])." ".ucwords($usersList[$user]['lastName']);?></option>
                                    <?php endfor; ?>
                                        </select>
                                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-1">
                    <button class="document_btn" type="submit" style="margin-top: 33px;">Submit</button>
                    </div>
                    </div>
                </form>
                                    <?php endif; ?>

                                </div>
            <div class="row">
                    <div class="col-sm-12">
                        <h4 class="header-title mt-4 mb-2">Documents</h4>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="demo-foo-filtering" style="text-align: center; margin-top: 10px;" class="table toggle-circle mb-0" data-page-size="15">
                                        <thead style="background-color: #F2F2F2;">
                                        <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>View File</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(sizeof($userDocs) > 0): ?>
                                        <?php for($i = 0; $i< sizeof($userDocs);$i++): ?>

                                            <tr>
                                                <td style="color: var(--card-sub-heading-color);padding: 0px;padding-top: 20px;"><?php echo $userDocs[$i]['id'] ?></td>
                                                <td style="color: var(--card-sub-heading-color);padding: 0px;padding-top: 20px;"><?php echo $userDocs[$i]['firstName']." ".$userDocs[$i]['lastName'] ?></td>
                                                <td style="color: var(--card-sub-heading-color);padding: 0px;padding-top: 20px;"><?php echo $userDocs[$i]['filename'] ?></td>
                                                <td style="padding: 0px;padding-top: 10px;">
                                                <a href="<?php echo $userDocs[$i]['link'] ?>" target="_blank"><button style="margin-bottom: 10px;" class="document_btn">View</button></a>
                                                <a href="<?php echo $userDocs[$i]['link'] ?>" download><button style="margin-bottom: 10px;" class="document_btn">Download</button></a>
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