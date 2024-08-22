<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Withdrawal Request - <?php echo APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nvest Clients - Where you can invest" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php echo view("/home/header-links"); ?>

    <style>
        .highlight {
            border: 3px solid #0075b2;
        }
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
        <?php echo view("/home/top-bar", $notification); ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="content-page" style="background-color: #F5F5FC !important;">
            <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
            <div class="content">
                <!-- Start Content-->
                <div id="full-screen-loader">
                    <div class="spinner-grow avatar-lg text-secondary m-2" role="status"></div>
                </div>
                <div class="container-fluid mt-4">
                    <div class="row mt-4">
                        <div class="col-12" style="text-align: right;">
                            <a href="<?= base_url(); ?>/user/withdrawal"><button class="primary_btn" style="color:#ffffff; border: 1px solid #000000; background-color: #000000;">Withdrawal History</button></a>
                        </div>
                    </div>
                    <h3 class=" my-4">Withdrawal Request</h3>
                    <div class="alert alert-danger">
                      <strong>Note! </strong>Crypto deposits/withdrawals are charged a 2.5% fee this is the cost of conversion when moving funds from your trading account. DO NOT DEPOSIT LESS THAN $25.00 USD to any crypto otherwise your funds will be lost.
                    </div>
                    <form id="withdrawal_form" action="<?php echo base_url(); ?>/user/submit_withdrawal" method="POST">
                        <div>
                            <h5 class="mb-3">Select Currency</h5>
                            <div class="row currency">
                                <?php foreach ($currency as $single) : ?>
                                    <div class="col-sm-6 col-md-4 box">
                                        <input id="<?= $single['slug']; ?>" class="currency_radio" type="radio" name="currency_type" value="<?= $single['id']; ?>" style="margin-right: 20px;" required hidden>
                                        <label class="col-10" for="<?= $single['slug']; ?>">
                                            <div class="card" style="cursor: pointer;">
                                                <div class="card-body">
                                                    <?php if(isset($single['name']) && $single['name'] == 'USD'): ?>
                                                    <img src="<?= base_url(); ?>/assets/images/usd.png" alt="">
                                                    <?php elseif(isset($single['name']) && $single['name'] == 'Crypto'): ?>
                                                    <img src="<?= base_url(); ?>/assets/images/crypto.png" alt="">
                                                    <?php endif; ?>
                                                    <h5 class="mt-3 mb-0 text-left"><?= $single['name']; ?></h5>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="currency_options">
                            <h5 class="mb-3">Select Crypto option</h5>
                            <div class="row usd_options">
                                <?php foreach ($currency_options['usd'] as $single) : ?>
                                    <div class="col-sm-6 col-md-4 box_crypto">
                                        <input id="<?= $single['slug']; ?>" class="crypto_type" type="radio" name="crypto_type" value="<?= $single['id']; ?>" style="margin-right: 20px;" required hidden>
                                        <label class="col-10" for="<?= $single['slug']; ?>">
                                            <div class="card" style="cursor: pointer;">
                                                <div class="card-body">
                                                    <!-- <i class="fa fa-ellipsis-v text-muted float-end" style="font-size: 16px; padding-top: 5px; color: #333333 !important;" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= $single['name']; ?>"></i> -->
                                                    <?php if(isset($single['name']) && $single['name'] == 'ACH Request'): ?>
                                                    <img src="<?= base_url(); ?>/assets/images/ach.png" alt="">
                                                    <?php elseif(isset($single['name']) && $single['name'] == 'Bank Wire'): ?>
                                                    <img src="<?= base_url(); ?>/assets/images/bank.png" alt="">
                                                    <?php endif; ?>
                                                    <h5 class="mt-3 mb-0 text-left"><?= $single['name']; ?></h5>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="row crypto_options">
                                <?php foreach ($currency_options['crypto'] as $single) : ?>
                                    <div class="col-sm-6 col-md-4 box_crypto">
                                        <input id="<?= $single['slug']; ?>" class="crypto_type" type="radio" name="crypto_type" value="<?= $single['id']; ?>" style="margin-right: 20px;" required hidden>
                                        <label class="col-10" for="<?= $single['slug']; ?>">
                                            <div class="card" style="cursor: pointer;">
                                                <div class="card-body">
                                                    <!-- <i class="fa fa-ellipsis-v text-muted float-end" style="font-size: 16px; padding-top: 5px; color: #333333 !important;" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= $single['name']; ?>"></i> -->
                                                    <?php if(isset($single['name']) && $single['name'] == 'Bitcoin'): ?>
                                                    <img src="<?= base_url(); ?>/assets/images/btc.png" alt="">
                                                    <?php elseif(isset($single['name']) && $single['name'] == 'USDT - TRX'): ?>
                                                    <img src="<?= base_url(); ?>/assets/images/tron.png" alt="">
                                                    <?php elseif(isset($single['name']) && $single['name'] == 'USDT - ETH'): ?>
                                                    <img src="<?= base_url(); ?>/assets/images/eth.png" alt="">
                                                    <?php endif; ?>
                                                    <h5 class="mt-3 mb-0 text-left"><?= $single['name']; ?></h5>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <a href="#" class="primary_btn proceed_btn" style="color:#ffffff; border: 1px solid #000000; background-color: #000000;">Proceed</a>
                        <div class="description">
                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Info: </strong><span class="info_d"> Withdrawal </span></p>
                                    <p><strong>Method: </strong><span class="method_d"></span></p>
                                    <p><strong>Method details: </strong><span class="method_details_d"></span></p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <label for="amount"><h5>Amount<span style="color: red;">*</span></h5></label>
                                    <input type="number" class="form-control" id="amount" min="0" name="amount" for="amount" max="<?php echo $balance ?>" required >
                                    <div class="crypto_inputs">
                                        <label for="wallet_address"><h5>Wallet Address/Bank Detail<span style="color: red;">*</span></h5></label>
                                        <input type="text" id="wallet_address" class="form-control" name="wallet_address" for="wallet_address" required >
                                    </div>
                                    <div class="usd_inputs">
                                        <label for="account_name"><h5>Account Name<span style="color: red;">*</span></h5></label>
                                        <input type="text" id="account_name" class="form-control" name="account_name" for="account_name" required >
                                        <label for="account_no"><h5>Account Number<span style="color: red;">*</span></h5></label>
                                        <input type="text" id="account_no" class="form-control" name="account_no" for="account_no" required >
                                        <label for="routing_no"><h5>Routing Number<span style="color: red;">*</span></h5></label>
                                        <input type="text" id="routing_no" class="form-control" name="routing_no" for="routing_no" required >
                                    </div>
                                    <label for="message"><h5>Message</h5></label>
                                    <textarea name="message" class="form-control" id="message" rows="4" placeholder="Write message here (optional)"></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary submit_withdrawal" style=" background-color: #0073B6;">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php echo view("/home/footer-scripts"); ?>
    <script>
        $('#full-screen-loader').hide();
        $('.crypto_inputs').hide();
        $('.usd_inputs').hide();
        $('.submit_withdrawal').hide();
        $('.currency_options').hide();
        $('.description').hide();
        $('.proceed_btn').hide();
        $(document).ready(function() {
            $('.currency_radio').change(function() {
                var $this = $(this);
                $this.closest('.currency').find('div.highlight').removeClass('highlight');
                $this.closest('.box').find('.card').addClass('highlight');
                $('.currency_options').show();
                if ($this.val() == '2') {   // crypto
                    $('.usd_options').hide();
                    $('.crypto_options').show();
                    $('.crypto_inputs').show();
                    $('.usd_inputs').hide();
                    $("#wallet_address").prop('required',true);
                    $("#account_name").prop('required',false);
                    $("#account_no").prop('required',false);
                    $("#routing_no").prop('required',false);
                } else if ($this.val() == '1') {  // usd
                    $('.crypto_options').hide();
                    $('.usd_options').show();
                    $('.crypto_inputs').hide();
                    $('.usd_inputs').show();
                    $("#wallet_address").prop('required',false);
                    $("#account_name").prop('required',true);
                    $("#account_no").prop('required',true);
                    $("#routing_no").prop('required',true);
                }
                $('.proceed_btn').hide();
                $('.submit_withdrawal').hide();
                $('.description').hide();
                $('.crypto_options').find('div.highlight').removeClass('highlight');
                $('.usd_options').find('div.highlight').removeClass('highlight');
                $('.crypto_type').prop('checked', false);
            });
            $('.crypto_type').change(function() {
                var $this = $(this);
                $this.closest('.crypto_options').find('div.highlight').removeClass('highlight');
                $this.closest('.usd_options').find('div.highlight').removeClass('highlight');
                $this.closest('.box_crypto').find('.card').addClass('highlight');
                $('.proceed_btn').show();
                $('.submit_withdrawal').hide();
                $('.description').hide();
            });
            $('.proceed_btn').click(function() {
                $('.submit_withdrawal').show();
                $('.description').show();
                $('.method_d').text($('input[name="currency_type"]:checked').parent().find('label').text());
                $('.method_details_d').text($('input[name="crypto_type"]:checked').parent().find('label').text());
                $(this).hide();
            });
            $('.submit_withdrawal').click(function(){
                if($('#wallet_address').val() !== '' && $('#amount').val() !== ''){
                    $('#full-screen-loader').show();
                }
            });
        });
    </script>
</body>

</html>