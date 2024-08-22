<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Chat - <?php echo APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nvest Clients - Where you can invest" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php echo view("/home/header-links"); ?>
</head>

<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}}'>
    <!-- Begin page -->
    <div id="wrapper">
        <?php echo view("/home/left-sidebar"); ?>
        <?php echo view("/home/top-bar", $notification) ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

        <div class="content-page" style=" background-color: #F5F5FC !important;">
            <div class="content" style="margin-top: 50px;">
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="margin-bottom: 0px;">
                            <div class="card-body" style="padding: 15px">
                                <h5>Conversation with Headoffice</h5>
                                <div class="col-lg-12" style="text-align: end;">
                                    <div class="message_box">
                                        <?php foreach ($allChat as $singleMessage) : ?>
                                            <?php if (!isset($date) || $date !== date('d M Y', strtotime($singleMessage['createdAt']))) : ?>
                                                <div class="row text-center">
                                                    <span class="line">
                                                        <h4><span><?= date('l, d M Y', strtotime($singleMessage['createdAt'])); ?></span></h4>
                                                    </span>
                                                </div>
                                            <?php $date = date('d M Y', strtotime($singleMessage['createdAt']));
                                            endif; ?>
                                            <?php if ($singleMessage['msgFrom'] == 'Admin') :
                                            ?>
                                                <div class="mb-2">
                                                    <div style="width:100%; float:left;">
                                                        <div style="float: left; margin-left:10px;">
                                                            <img src="<?php echo base_url(); ?>/assets/images/users/user-1.jpg" alt="Avatar" style="width: 40px; border-radius:40px;">
                                                        </div>
                                                        <span class="time-left" style="display: block; padding-left:50px; text-align:left; font-size: 12px;"><b>Admin </b> <?php echo date('g:i A', strtotime($singleMessage['createdAt'])); ?></span>
                                                        <div style="margin-left: 10px; float:left; max-width:70%;">
                                                            <p style="padding:5px 10px; text-align: start; color:#333333e0; margin-bottom:5px; border-radius:20px; font-size: 14px;">
                                                                <?php echo $singleMessage['message']; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php elseif ($singleMessage['msgFrom'] != 'Admin') :
                                            ?>
                                                <div class="mb-2">
                                                    <div style="width:100%; float:right;">
                                                        <div style="float: right; margin-left:10px;">
                                                            <img src="<?php echo base_url(); ?>/assets/images/users/user-1.jpg" alt="Avatar" style="width: 40px; border-radius:40px;">
                                                        </div>
                                                        <span class="time-right" style="display: block; padding-right:50px; font-size: 12px;"><?php echo date('g:i A', strtotime($singleMessage['createdAt'])); ?></span>
                                                        <div style="float:right; max-width:70%;">
                                                            <p style="padding:5px 10px; text-align: start; color:#333333e0; margin-bottom:5px; border-radius:20px; font-size: 14px;"><?php echo $singleMessage['message']; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="mt-2" style="display: inline-block; width: 100%; margin:auto; text-align:start;">
                                        <form action="<?php echo base_url(); ?>/user/submitMessage" method="POST">
                                            <input type="hidden" name="userid" value="<?php echo $id; ?>" />
                                            <div class="d-flex flex-row">
                                                <textarea class="form-control" name="sendingMesage" placeholder="Message" rows="1" style="margin:auto; border-radius:20px; background-color: #F2F2F2; color:black;" required></textarea>
                                                <button class="save btn btn-primary waves-effect waves-light" type="submit" style="border-radius:30px; padding: 6px 10px; margin-left:8px; background-color:#008DFF;">
                                                    <i class="fa fa-paper-plane" style="color:white; font-size:14px;"></i>
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo view("/home/footer-scripts"); ?>
</body>

</html>