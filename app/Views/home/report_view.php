<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Statement</title>
  <script src="<?php echo base_url(); ?>/assets/js/html2canvas.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/js/jspdf.umd.min.js"></script>
  <?php echo view("/home/new-header-links"); ?>
  <style>
    .check_s {
      padding: 10px;
      font-size: 19px;
      text-align: center;
      color: black;
      border-style: solid;
      border-color: black;
      margin-left: 10px;
    }

    .hname {
      font-size: 30px;
      font-weight: bold;
      color: black;
      font-family: sans-serif;
    }

    .csname {
      font-size: 20px;
      font-weight: bold;
      color: black;
      font-family: sans-serif;
    }

    .table_cla {
      color: black;
      margin-top: 10px;
      margin-bottom: 25px;
    }

    .table_div {
      padding-right: 10% !important;
      padding-left: 12px !important;
    }

    .clientInfo {
      margin-top: -40px;
      padding-left: 90px;
    }

    .serviceInfo {
      margin-top: -250px;
      margin-left: 0px;
      padding-left: 50px;
    }

    .table_div {
      margin-top: -15px;
      margin-bottom: -15px;
    }

    .youstatement {
      font-size: 30px !important;
      color: black;
      font-family: sans-serif;
      letter-spacing: 2px;
      margin-bottom: 25px;
    }

    @media (max-width: 550px) {
      .hname {
        font-size: 18px;
      }

      .csname {
        font-size: 15px;
      }

      .hname2 {
        margin: 0px !important;
      }

      .check_s {
        margin-left: 0px;
      }

      .table_div {
        padding-right: 0px !important;
      }

      .clientInfo {
        padding-left: 12px;
      }

      .youstatement {
        margin: 10px 0px 10px 0px !important;
      }

      .serviceInfo {
        padding-left: 0px;
      }
    }
  </style>
</head>

<body>
  <div class="app_wrapper">
  <?php echo view("/home/left-sidebar-new"); ?>
    <main class="main">
      <button onclick="Convert_HTML_To_PDF();" class="flex-a statement_btn">Create Pdf</button>
      <div class="card statement-card">
        <h2 class="cus-details-card__hadng">Filter</h2>
        <?php if (isset($callChartAdmin) && $callChartAdmin == true) : ?>
          <form id="deposit_form" action="<?php echo base_url(); ?>/admin/report_genrate" method="POST">
            <input type="hidden" name="userid" value="<?php if (isset($_GET['userid'])) echo $_GET['userid'];
                                                      else echo $userid; ?>" />
          <?php else: ?>
            <form id="deposit_form" action="<?php echo base_url(); ?>/user/report_genrate" method="POST">
            <?php endif; ?>
            <div class="flex-i filterwrpr">
              <select type="text" class="filterwrpr__select form-select form-control" id="select_duration" name="select_duration" placeholder="">
                <option value="0">Choose</option>
                <option value="TM">This Month</option>
                <option value="LM">Last Month</option>
                <option value="L9D">Last 90 Days</option>
                <option value="CY">Current Year</option>
                <option value="Custom_date">Custom Date</option>
              </select>
   
              <button class="filterwrpr__btn flex-a statement_btn">Search</button>
            </div>
            <div class="row d-none mt-3" id="cutome_dates_input" >
                <div class="mb-3 col-md-12">
                  <label for="start_date" class="form-label">Start Date</label><br>
                  <input type="date" class="form-control filterwrpr__select filterwrpr__select2 " id="start_date" name="start_date" style="background-image:none;" />
                </div>
                <div class="mb-3 col-md-12">
                  <label for="start_date" class="form-label">End Date</label><br>
                  <input type="date" class="form-control filterwrpr__select" id="end_date" name="end_date" style="background-image:none;" />
                </div>
              </div>
            </form>
      </div>
      <div class="card statement-card">
        <?php if (isset($userInfo) && isset($all_Data)): ?>
          <!-- end row -->
          <h3 class="header-title mt-4 mb-3">Client's Report</h3>
          <div class="row" id="contentToPrint" style="font-family: sans-serif;">
            <div class="col-12">
              <div class="card">
                <div class="card-body" style="padding: 3.5rem 2.5rem;">
                  <div class="row" style="margin-top: -60px;">
                    <div class="hname2 mb-5 col-md-9" style="margin-left: 30px">
                      <h2 class="hname"><img style="" src="<?php echo base_url(); ?>/assets/images/G_logo.png" alt="" height="200"></h2>
                      <p style="color: black;margin-left: 50px;margin-top: -30px;">1435 FM 1463 Katy,<br>TX 77494</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="hname2 clientInfo col-md-7">
                      <p style="margin-bottom: 2px;font-size: 12px;font-weight: bold;color: black;"><?php echo $userInfo['firstName'] . " " . $userInfo['lastName'] ?></p>
                      <p style="margin-bottom: 2px;font-size: 12px;font-weight: bold;color: black;"><?php echo $userInfo['email'] ?></p>
                      <p style="margin-bottom: 2px;font-size: 12px;font-weight: bold;color: black;"><?php echo $userInfo['phone'] ?></p>
                    </div>
                    <div class="hname2 serviceInfo mb-1 col-md-5">
                      <h2 class="hname2 youstatement">Your Statement</h2>
                      <div class="row table_div">
                        <table class="table_cla">
                          <tr>
                            <td>Account Number</td>
                            <td style="text-align: end;">0000<?php echo $userInfo['id']; ?></td>
                          </tr>
                          <tr>
                            <td><?php echo '<hr style="color: black;height: 3px;margin-top: 5px;margin-bottom: 5px;">'; ?></td>
                            <td><?php echo '<hr style="color: black;height: 3px;margin-top: 5px;margin-bottom: 5px;">'; ?></td>
                          </tr>
                          <tr>
                            <td>Statement Period</td>
                            <td style="text-align: end;"><?php if (isset($start_date) && isset($end_date)) $start_date =  date('j M Y', strtotime($start_date));
                                                          $end_date =  date('j M Y', strtotime($end_date));
                                                          echo $start_date . " to " . $end_date; ?></td>
                          </tr>
                          <tr>
                            <td><?php echo '<hr style="color: black;height: 3px;margin-top: 5px;margin-bottom: 5px;">'; ?></td>
                            <td><?php echo '<hr style="color: black;height: 3px;margin-top: 5px;margin-bottom: 5px;">'; ?></td>
                          </tr>
                          <tr>
                            <td>Beginning Balance</td>
                            <td style="text-align: end;"><?php echo '$' . number_format($startAmount); ?></td>
                          </tr>
                          <tr>
                            <td><?php echo '<hr style="color: black;height: 3px;margin-top: 5px;margin-bottom: 5px;">'; ?></td>
                            <td><?php echo '<hr style="color: black;height: 3px;margin-top: 5px;margin-bottom: 5px;">'; ?></td>
                          </tr>
                          <tr>
                            <td>Deposits And Additions</td>
                            <td style="text-align: end;"><?php echo "+" . number_format($depositSum + ($PSum - $LSum)); ?></td>
                          </tr>
                          <tr>
                            <td><?php echo '<hr style="color: black;height: 3px;margin-top: 5px;margin-bottom: 5px;">'; ?></td>
                            <td><?php echo '<hr style="color: black;height: 3px;margin-top: 5px;margin-bottom: 5px;">'; ?></td>
                          </tr>
                          <tr>
                            <td>Withdrawals</td>
                            <td style="text-align: end;"><?php echo "-" . number_format($withdrawSum + $payoutSum); ?></td>
                          </tr>
                          <tr>
                            <td><?php echo '<hr style="color: black;height: 3px;margin-top: 5px;margin-bottom: 5px;">'; ?></td>
                            <td><?php echo '<hr style="color: black;height: 3px;margin-top: 5px;margin-bottom: 5px;">'; ?></td>
                          </tr>
                          <tr>
                            <td>Ending Balance</td>
                            <td style="text-align: end;"><?php echo '$' . number_format($endAmount); ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="margin-top: 50px;">
                    <div class="mb-2 col-md-3 check_s csname">
                      Smart Access
                    </div>
                    <input type="hidden" id="data_size" value="<?php if (isset($all_Data)) echo sizeof($all_Data) ?>">
                    <div class="col-md-9" style="margin: 16px 0px 0px -12px;">
                      <hr style="color: black;height: 2px;">
                    </div>
                    <p style="color: black">Interested in learning how to diversify? We are currently in developing stages with new partnerships and looking to share them with you! Contact your account representative to learn more!<br><br>
                      <!--Name:  GoLong Investments LLC<br>-->
                      <!--    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C/O GoLong Investments LLC<br>-->
                      <!--    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;www.golongclients.com<br><br>-->
                      Note: Have you checked your statement today? Should you have any questions on fees or see an error please contact your account representative on the details above. Please make sure any outstanding fees or charges are pail prior to your next withdrawal.
                    </p>
                    <div class="row">
                      <div class="mb-2 col-md-3 check_s csname">
                        TRANSACTION DETAIL
                      </div>
                      <div class="col-md-9" style="margin: 16px 0px 0px -12px;">
                        <hr style="color: black;height: 2px;">
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table id="" class="table toggle-circle mb-0" data-page-size="<?php echo sizeof($all_Data); ?>">
                        <thead style="background-color: #F2F2F2;">
                          <tr>
                            <!-- <th>Name</th> -->
                            <th>Date</th>
                            <!-- <th>Transition</th>
                                                    <th>Withdrawals</th>
                                                    <th>Deposits</th>
                                                    <th>Payout</th> -->
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Balance</th>
                          </tr>
                        </thead>


                        <tbody>
                          <?php for ($i = 0; $i < sizeof($all_Data); $i++): ?>
                            <?php if ($i == 0): ?>
                              <tr>
                                <td><?php if (isset($start_date)) $date = explode(" ", $start_date);
                                    echo date('m/d/y', strtotime($start_date)); ?></td>
                                <td> Starting Balance </td>
                                <td> - </td>
                                <td><?php if (isset($startAmount)) echo '$' . number_format($startAmount) ?></td>

                              </tr>
                            <?php endif; ?>
                            <?php if ($all_Data[$i]['type'] != 'Swing'): ?>
                              <tr>
                                <!-- <td></td> -->
                                <td><?php if (isset($all_Data[$i]['date'])) $date = explode(" ", $all_Data[$i]['date']);
                                    echo date('m/d/y', strtotime($date[0])); ?></td>
                                <!-- <td>
                                                        <?php if (isset($all_Data[$i]['type']) && $all_Data[$i]['type'] == 'Profit') : ?>
                                                            <i class="fa fa-arrow-circle-up" aria-hidden="true" style="font-size: 23px; color: #1ABC9C;"></i> &nbsp; $<?php echo $all_Data[$i]['trasition']; ?>
                                                            <?php elseif (isset($all_Data[$i]['type']) && $all_Data[$i]['type'] == 'Loss') : ?>
                                                                <i class="fa fa-arrow-circle-down" aria-hidden="true" style="font-size: 23px; color: #D06162;"></i> &nbsp; $<?php echo $all_Data[$i]['trasition']; ?>
                                                                <?php elseif (isset($all_Data[$i]['type'])): ?>
                                                                    $<?php echo "(S)" . $all_Data[$i]['trasition']; ?>
                                                                    <?php endif; ?>
                                                                </td>
                                                    <td><?php if (isset($all_Data[$i]['widthra'])) echo $all_Data[$i]['widthra'] ?></td>
                                                    <td><?php if (isset($all_Data[$i]['deposit'])) echo $all_Data[$i]['deposit'] ?></td>
                                                    <td><?php if (isset($all_Data[$i]['payout'])) echo $all_Data[$i]['payout'] ?></td> -->
                                <td><?php if (isset($all_Data[$i]['payout'])): echo 'Payout Sent To Client';
                                    elseif (isset($all_Data[$i]['widthra'])): echo 'Amount Withdrawn By Client';
                                    elseif (isset($all_Data[$i]['deposit'])): echo 'Amount Deposited By Client';
                                    elseif (isset($all_Data[$i]['trasition'])): if (isset($all_Data[$i]['type']) && $all_Data[$i]['type'] == 'Profit'): echo 'Profit Added In Account';
                                      elseif (isset($all_Data[$i]['type']) && $all_Data[$i]['type'] == 'Loss'): echo 'Loss Deduct From Account';
                                      endif;
                                    endif; ?></td>
                                <td><?php if (isset($all_Data[$i]['payout'])): echo '$' . number_format($all_Data[$i]['payout']);
                                    elseif (isset($all_Data[$i]['widthra'])): echo '$' . number_format($all_Data[$i]['widthra']);
                                    elseif (isset($all_Data[$i]['deposit'])): echo '$' . number_format($all_Data[$i]['deposit']);
                                    elseif (isset($all_Data[$i]['trasition'])): if (isset($all_Data[$i]['type']) && $all_Data[$i]['type'] == 'Profit'): echo '$' . number_format($all_Data[$i]['trasition']);
                                      elseif (isset($all_Data[$i]['type']) && $all_Data[$i]['type'] == 'Loss'): echo '-$' . number_format($all_Data[$i]['trasition']);
                                      endif;
                                    endif; ?></td>
                                <td><?php if (isset($all_Data[$i]['balance'])) echo '$' . number_format($all_Data[$i]['balance']) ?></td>

                              </tr>
                            <?php endif; ?>
                          <?php endfor ?>
                        </tbody>
                      </table>
                    </div>

                  </div> <!-- end card body-->
                </div> <!-- end card -->
              </div><!-- end col-->
            </div>
            <!-- end row-->
          </div>
        <?php endif; ?>
      </div>
    </main>
  </div>
  <?php echo view("/home/new-footer-scripts"); ?>
  <script>
            $("#select_duration").change(function() {
                if ($("#select_duration").val() == 'Custom_date') {
                    $('#cutome_dates_input').removeClass("d-none");
                } else {
                    $('#cutome_dates_input').addClass("d-none");
                }

            });
            window.jsPDF = window.jspdf.jsPDF;

            // Convert HTML content to PDF
            function Convert_HTML_To_PDF() {
                var size = document.getElementById("data_size").value;
                var doc = new jsPDF("pl", "mm");

                // Source HTMLElement or a string containing HTML.
                var elementHTML = document.querySelector("#contentToPrint");
                const options = {
                    compress: true, // Enable compression
                    precision: 2, // Set compression precision (optional)
                };
                doc.html(elementHTML, {
                    callback: function(doc) {
                        // Save the PDF
                        var pageCount = doc.internal.getNumberOfPages();
                        if (size < 14) {
                            for (var i = pageCount; i > 1; i--) {
                                doc.deletePage(i);
                            }
                        } else if (size >= 14 && size <= 43) {
                            for (var i = pageCount; i > 2; i--) {
                                doc.deletePage(i);
                            }
                        } else if (size >= 43 && size <= 72) {
                            for (var i = pageCount; i > 3; i--) {
                                doc.deletePage(i);
                            }
                        } else if (size >= 72 && size <= 101) {
                            for (var i = pageCount; i > 4; i--) {
                                doc.deletePage(i);
                            }
                        } else if (size >= 101 && size <= 130) {
                            for (var i = pageCount; i > 5; i--) {
                                doc.deletePage(i);
                            }
                        } else if (size >= 130 && size <= 159) {
                            for (var i = pageCount; i > 6; i--) {
                                doc.deletePage(i);
                            }
                        } else if (size >= 159 && size <= 188) {
                            for (var i = pageCount; i > 7; i--) {
                                doc.deletePage(i);
                            }
                        } else if (size >= 188 && size <= 217) {
                            for (var i = pageCount; i > 8; i--) {
                                doc.deletePage(i);
                            }
                        } else if (size >= 217 && size <= 246) {
                            for (var i = pageCount; i > 9; i--) {
                                doc.deletePage(i);
                            }
                        } else if (size >= 246 && size <= 275) {
                            for (var i = pageCount; i > 10; i--) {
                                doc.deletePage(i);
                            }
                        } else if (size >= 274 && size <= 304) {
                            for (var i = pageCount; i > 11; i--) {
                                doc.deletePage(i);
                            }
                        } else if (size >= 304 && size <= 333) {
                            for (var i = pageCount; i > 12; i--) {
                                doc.deletePage(i);
                            }
                        } else if (size >= 333 && size <= 362) {
                            for (var i = pageCount; i > 13; i--) {
                                doc.deletePage(i);
                            }
                        } else if (size >= 362 && size <= 391) {
                            for (var i = pageCount; i > 14; i--) {
                                doc.deletePage(i);
                            }
                        }
                        doc.save('Report.pdf', options);
                    },
                    margin: [10, 10, 10, 10],
                    autoPaging: 'text',
                    x: 0,
                    y: 0,
                    width: 190, //target width in the PDF document
                    windowWidth: 1000, //window width in CSS pixels
                });
            }
        </script>
</body>

</html>