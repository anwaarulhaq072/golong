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
      <div class="card chat-card">
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

        <?php endforeach; ?>

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
        <form action="<?php echo base_url(); ?>/user/submitMessage" method="POST" class="flex-i msgform">
          <input type="hidden" name="userid" value="<?php echo $id; ?>" />
          <input type="text" class="mes__input" name="sendingMesage" placeholder="Message" required>
          <button class="msg__btn flex-a">
            <i class="fa-regular fa-paper-plane"></i>
          </button>
        </form>
      </div>
    </main>
  </div>
  <?php echo view("/home/new-footer-scripts"); ?>
</body>

</html>