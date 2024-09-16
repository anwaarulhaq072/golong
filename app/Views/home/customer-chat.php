<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chat</title>
  <?php echo view("/home/new-header-links"); ?>
</head>

<body>
  <div class="app_wrapper">
    <?php echo view("/home/left-sidebar-new"); ?>
    <main class="main">
    <?php if($admin == 1): ?>
    <div class="chat_admin_header">
      <h4 class="header-title mb-2">Chat With <?php echo ucfirst($userInfo['firstName'])." ".ucfirst($userInfo['lastName']); ?></h4>
    </div>
    <?php endif; ?>
    <div class="row">
    <?php if($admin == 1): ?>
    <div class="col-md-3">
        <h4 class="header-title mt-4 mb-2">User's List</h4>
        <div class="card">
            <div class="card-body">
                <div class="user-list">
                    <div style="width:100%;float:right;margin: 6px 0px 0px 0px;height: 739px;overflow: auto;overflow-x: hidden;">
                        <?php if(isset($chat_user_list)): ?>
                        <?php for($user_list = 0; $user_list < sizeof($chat_user_list); $user_list++): ?>
                        <div class="outer_div_user">
                            <a href="<?php echo base_url().'/admin/chat?userid='.$chat_user_list[$user_list]['id']; ?>" style="color: black;">
                                <div class="row align-items-center">
                                    <div class="col-3 col-lg-2">
                                        <?php if(isset($chat_user_list[$user_list]['profile_img']) && $chat_user_list[$user_list]['profile_img'] != ''): ?>
                                        <img src="<?php echo ($chat_user_list[$user_list]['profile_img'] && $chat_user_list[$user_list]['profile_img'] !== '') ? base_url().$chat_user_list[$user_list]['profile_img'] : base_url().'/assets/images/users/user-1.jpg'; ?>" alt="Avatar" style="width: 42px; height: 45px; border-radius: 40px; margin-right: 17px;">
                                        <?php else: ?>
                                        <div style="width: 45px; height: 55px; margin-right: 8px;">
                                            <p style="color: white;background: #2F3F4F;text-align: center;font-size: xx-large;border: solid;border-radius: 40px;padding: 12px 6px;">
                                                <?php echo ucwords(substr($chat_user_list[$user_list]['firstName'], 0, 1)); ?>
                                            </p>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-9 col-lg-10">
                                        <p style="padding: 10px; padding-bottom: 20px; border-bottom: 1px solid #CBCBCB; color: var(--card-sub-heading-color);">
                                            <?php echo ucwords($chat_user_list[$user_list]['firstName'].' '.$chat_user_list[$user_list]['lastName']); ?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($admin == 1): ?>
    <div class="chat_admin_header2">
      <h4 class="header-title mt-4 mb-2">Chat With <?php echo ucfirst($userInfo['firstName'])." ".ucfirst($userInfo['lastName']); ?></h4>
    </div>
    <?php endif; ?>
    <?php endif; ?>
      <div class="card chat-card <?php if($admin == 1): ?> col-md-9 col-lg-9 <?php else: ?> col-md-12 col-lg-12 <?php endif; ?>" style="margin-top: 60px;overflow: auto;height: 807px;display: flex;flex-direction: column;justify-content: flex-end;">
        <?php
        $lastDate = ''; // Variable to store the last message date
        foreach ($allChat as $singleMessage) :
          // Extract the date part from the current message's createdAt field
          $currentDate = date('l, d M Y', strtotime($singleMessage['createdAt']));

          // Check if the current date is different from the last date
          if ($currentDate != $lastDate) :
            $lastDate = $currentDate; // Update the lastDate variable
        ?>
            <div class="chat-date">
              <span class="date"><?= $currentDate; ?></span>
            </div>
          <?php
          endif;
          ?>
          <?php if($admin == 1): ?>
            <div class="chat">
            <?php if ($singleMessage['msgFrom'] == 'Admin') : ?>
              <div class="chatbox">
              <img src="<?php echo ($_SESSION['user_data']['profile_img'] && $_SESSION['user_data']['profile_img'] !== '') ? base_url() . $_SESSION['user_data']['profile_img'] : base_url() . '/assets/images/users/user-1.jpg'; ?>" alt="" class="chatbox__img">
                <div class="chatbox__content">
                  <div class="flex-i nameRow">
                    <span class="chat_user_name">Admin</span>
                    <span class="chat_user_time"><?php echo date('g:i A', strtotime($singleMessage['createdAt'])); ?></span>
                  </div>
                  <p class="chat__mesg">
                    <?php echo $singleMessage['message']; ?>
                  </p>
                </div>
              </div>
            <?php elseif ($singleMessage['msgFrom'] != 'Admin') : ?>
              <div class="chatbox chat-sender">
                <div class="chatbox__content">
                  <div class="flex-i nameRow">
                    <span class="chat_user_time"><?php echo date('g:i A', strtotime($singleMessage['createdAt'])); ?></span>
                    <span class="chat_user_name"></span>
                  </div>
                  <p class="chat__mesg">
                    <?php echo $singleMessage['message']; ?>
                  </p>
                </div>
                <img src="<?php echo ($userInfo['profile_img'] && $userInfo['profile_img'] !== '') ? base_url() . $userInfo['profile_img'] : base_url() . '/assets/images/users/user-1.jpg'; ?>" alt="" class="chatbox__img">
              </div>
            <?php endif; ?>
          </div>
          <?php else: ?>
          <div class="chat">
            <?php if ($singleMessage['msgFrom'] == 'Admin') : ?>
              <div class="chatbox">
                <img src="<?php echo base_url(); ?>/assets/images/users/user-1.jpg" alt="" class="chatbox__img">
                <div class="chatbox__content">
                  <div class="flex-i nameRow">
                    <span class="chat_user_name">Admin</span>
                    <span class="chat_user_time"><?php echo date('g:i A', strtotime($singleMessage['createdAt'])); ?></span>
                  </div>
                  <p class="chat__mesg">
                    <?php echo $singleMessage['message']; ?>
                  </p>
                </div>
              </div>
            <?php elseif ($singleMessage['msgFrom'] != 'Admin') : ?>
              <div class="chatbox chat-sender">
                <div class="chatbox__content">
                  <div class="flex-i nameRow">
                    <span class="chat_user_time"><?php echo date('g:i A', strtotime($singleMessage['createdAt'])); ?></span>
                    <span class="chat_user_name"></span>
                  </div>
                  <p class="chat__mesg">
                    <?php echo $singleMessage['message']; ?>
                  </p>
                </div>
                <img src="<?php echo ($_SESSION['user_data']['profile_img'] && $_SESSION['user_data']['profile_img'] !== '') ? base_url() . $_SESSION['user_data']['profile_img'] : base_url() . '/assets/images/users/user-1.jpg'; ?>" alt="" class="chatbox__img">
              </div>
            <?php endif; ?>
          </div>
          <?php endif; ?>

        <?php endforeach; ?>
        <?php if($admin == 1 && isset($_GET['userid'])): ?>
        <form action="<?php echo base_url(); ?>/admin/submitMessage" method="POST" class="flex-i msgform">
          <input type="hidden" name="userid" value="<?php echo $id; ?>" />
          <input type="text" class="mes__input" name="sendingMesage" placeholder="Message" required>
          <button class="msg__btn flex-a">
            <i class="fa-regular fa-paper-plane"></i>
          </button>
          <?php else: ?>
        </form>
        <form action="<?php echo base_url(); ?>/user/submitMessage" method="POST" class="flex-i msgform">
          <input type="hidden" name="userid" value="<?php echo $id; ?>" />
          <input type="text" class="mes__input" name="sendingMesage" placeholder="Message" required>
          <button class="msg__btn flex-a">
            <i class="fa-regular fa-paper-plane"></i>
          </button>
        </form>
        <?php endif; ?>
            </div>

        <!-- <div class="chat">
          <div class="chat-date"><span class="date">16 Sep 2022</span></div>
          <div class="chatbox chat-sender">
            <div class="chatbox__content">
              <div class="flex-i nameRow">
                <span class="chat_user_time">03: 06 pm</span>
                <span class="chat_user_name">Admin</span>
              </div>
              <p class="chat__mesg">
                Looking for swings next trading day on the Dow Jones, If data releases as expected will be a massive
                play!
              </p>
            </div>
            <img src="assets/images/profile.png" alt="" class="chatbox__img">
          </div>
          <div class="chatbox">
            <img src="assets/images/profile.png" alt="" class="chatbox__img">
            <div class="chatbox__content">
              <div class="flex-i nameRow">
                <span class="chat_user_name">Admin</span>
                <span class="chat_user_time">03: 06 pm</span>
              </div>
              <p class="chat__mesg">
                Looking for swings next trading day on the Dow Jones, If data releases as expected will be a massive
                play!
              </p>
            </div>
          </div>
          <div class="chatbox">
            <img src="assets/images/profile.png" alt="" class="chatbox__img">
            <div class="chatbox__content">
              <div class="flex-i nameRow">
                <span class="chat_user_name">Admin</span>
                <span class="chat_user_time">03: 06 pm</span>
              </div>
              <p class="chat__mesg">
                Looking for swings next trading day on the Dow Jones, If data releases as expected will be a massive
                play!
              </p>
            </div>
          </div>
          <div class="chatbox chat-sender">
            <div class="chatbox__content">
              <div class="flex-i nameRow">
                <span class="chat_user_time">03: 06 pm</span>
                <span class="chat_user_name">Admin</span>
              </div>
              <p class="chat__mesg">
                Looking for swings next trading day on the Dow Jones, If data releases as expected will be a massive
                play!
              </p>
            </div>
            <img src="assets/images/profile.png" alt="" class="chatbox__img">
          </div>
        </div>
        <div class="chat">
          <div class="chat-date"><span class="date">16 Sep 2022</span></div>
          <div class="chatbox">
            <img src="assets/images/profile.png" alt="" class="chatbox__img">
            <div class="chatbox__content">
              <div class="flex-i nameRow">
                <span class="chat_user_name">Admin</span>
                <span class="chat_user_time">03: 06 pm</span>
              </div>
              <p class="chat__mesg">
                Looking for swings next trading day on the Dow Jones, If data releases as expected will be a massive
                play!
              </p>
            </div>
          </div>
          <div class="chatbox chat-sender">
            <div class="chatbox__content">
              <div class="flex-i nameRow">
                <span class="chat_user_time">03: 06 pm</span>
                <span class="chat_user_name">Admin</span>
              </div>
              <p class="chat__mesg">
                Looking for swings next trading day on the Dow Jones, If data releases as expected will be a massive
                play!
              </p>
            </div>
            <img src="assets/images/profile.png" alt="" class="chatbox__img">
          </div>
          <div class="chatbox">
            <img src="assets/images/profile.png" alt="" class="chatbox__img">
            <div class="chatbox__content">
              <div class="flex-i nameRow">
                <span class="chat_user_name">Admin</span>
                <span class="chat_user_time">03: 06 pm</span>
              </div>
              <p class="chat__mesg">
                Looking for swings next trading day on the Dow Jones, If data releases as expected will be a massive
                play!
              </p>
            </div>
          </div>
        </div> -->
      </div>
    </main>
  </div>
  <?php echo view("/home/new-footer-scripts"); ?>
</body>

</html>