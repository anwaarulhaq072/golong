<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Add Deposit - <?php echo APP_NAME ?></title>
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
            <div class="content">
                <!-- Start Content-->
                <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
                <div id="full-screen-loader">
                    <div class="spinner-grow avatar-lg text-secondary m-2" role="status"></div>
                </div>
                <div class="container-fluid mt-4">
                    <div class="row mt-4">
                        <div class="col-12" style="text-align: right;">
                            <a href="<?= base_url(); ?>/user/deposit"><button class="btn btn-primary" style=" border: 1px solid #000000; background-color: #000000;">Deposit History</button></a>
                        </div>
                    </div>
                    <h3 class=" my-4">Deposit Request</h3>
                    <div class="alert alert-danger">
                      <strong>Note! </strong>Crypto deposits/withdrawals are charged a 2.5% fee this is the cost of conversion when moving funds from your trading account. DO NOT DEPOSIT LESS THAN $25.00 USD to any crypto otherwise your funds will be lost.
                    </div>
                    <form id="deposit_form" action="<?php echo base_url(); ?>/user/submit_deposit" method="POST">
                        <div>
                            <h5 class="mb-3">Select Currency</h5>
                            <div class="row currency">
                                <?php foreach ($currency as $single) : ?>
                                    <div class="col-sm-6 col-md-4 box">
                                        <input id="<?= $single['slug']; ?>" class="currency_radio" type="radio" name="currency_type" value="<?= $single['id']; ?>" style="margin-right: 20px;" required hidden>
                                        <label class="col-10" for="<?= $single['slug']; ?>">
                                            <div class="card" style="cursor: pointer;">
                                                <div class="card-body">
                                                    <!-- <i class="fa fa-ellipsis-v text-muted float-end" style="font-size: 16px; padding-top: 5px; color: #333333 !important;" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= $single['name']; ?>"></i> -->
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
                            <h5 class="mb-3">Select option</h5>
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
                                                <div class="card-body" id="<?php echo str_replace(' ', '', $single['name']); ?>">
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
                        <a href="#" class="btn btn-primary proceed_btn" style=" border: 1px solid #000000; background-color: #000000;">Proceed</a>
                        <div class="description">
                            <div class="card">
                                <div class="card-body">
                                    <div class="alert alert-success text-center" id="copied_text_success_bar">
                                      <strong>Text Copied</strong>
                                    </div>
                                    <p><strong>Info: </strong><span class="info_d"> Deposit </span></p>
                                    <div class="usd_account_details">
                                        <p><strong>Account name: </strong><span class="info_d"> <?php echo ACCOUNT_NAME ?> </span></p>
                                        <p><strong>Account number: </strong><span class="info_d"> <?php echo ACCOUNT_NUMBER ?> </span></p>
                                        <p><strong>Routing number: </strong><span class="info_d"> <?php echo ACCOUNT_Routing ?> </span></p>
                                    </div>
                                    <div class="crypto_account_details">
                                        <p><strong>Wallet address <span id="method"></span>: </strong><span id="main_span" class="info_d copy_text_class" title="Copy text" style="cursor: pointer;"><i class="fas fa-copy" style="margin-left: 90px;"></span></i></p>
                                    </div>
                                    <p><strong>Method: </strong><span class="method_d"></span></p>
                                    <p><strong>Method details: </strong><span class="method_details_d"></span></p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <label for="amount"><h5>Amount<span style="color: red;">*</span></h5></label>
                                    <input type="number" class="form-control" id="amount" name="amount" for="amount" required >
                                    <label for="message"><h5>Message</h5></label>
                                    <textarea name="message" class="form-control" id="message" rows="4" placeholder="Write message here (optional)"></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary submit_deposit" style=" background-color: #0073B6;">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php echo view("/home/footer-scripts"); ?>
    <script>
        $('.copy_text_class').click(function(){
          var copyText = $(this).text();
          navigator.clipboard.writeText(copyText); 
          $('#copied_text_success_bar').show();
          $('#copied_text_success_bar').fadeOut(1000);
        });
        $('#copied_text_success_bar').hide();
        $('#full-screen-loader').hide();
        $('.usd_account_details').hide();
        $('.crypto_account_details').hide();
        $('.submit_deposit').hide();
        $('.currency_options').hide();
        $('.description').hide();
        $('.proceed_btn').hide();
        $(document).ready(function() {
            $('.currency_radio').change(function() {
                var $this = $(this);
                $this.closest('.currency').find('div.highlight').removeClass('highlight');
                $this.closest('.box').find('.card').addClass('highlight');
                $('.currency_options').show();
                if ($this.val() == '2') { // crypto
                    $('.usd_options').hide();
                    $('.crypto_options').show();
                    $('.crypto_account_details').show();
                    $('.usd_account_details').hide();
                } else if ($this.val() == '1') { // usd
                    $('.crypto_options').hide();
                    $('.usd_options').show();
                    $('.usd_account_details').show();
                    $('.crypto_account_details').hide();
                }
                $('.proceed_btn').hide();
                $('.submit_deposit').hide();
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
                $('.submit_deposit').hide();
                $('.description').hide();
            });
            $('.proceed_btn').click(function() {
                $('.submit_deposit').show();
                $('.description').show();
                $('.method_d').text($('input[name="currency_type"]:checked').parent().find('label').text());
                $('.method_details_d').text($('input[name="crypto_type"]:checked').parent().find('label').text());
                $(this).hide();
            });
            $('.submit_deposit').click(function(){
                if($('#amount').val() !== ''){
                    $('#full-screen-loader').show();
                }
            });
        });
        $('#Bitcoin').click(function() {
            $('#method').text('BTC');
            $('#main_span').text('N/A'); 
        });
        $('#USDT-TRX').click(function() {
            $('#method').text('(TRC20)');
            $('#main_span').text('TP7otRohfSGrnmQkJKcye5M7A6BKuLRXkG'); 
        });
        $('#USDT-ETH').click(function() {
            $('#method').text('(ERC20)');
            $('#main_span').text('0xc03ea0620f23c5fc29cfaa9c81e29a10781caff5'); 
        });
    </script>
</body>

</html>