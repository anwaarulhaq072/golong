<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Account - <?php echo APP_NAME ?></title>
  <?php echo view("/home/new-header-links"); ?>
</head>

<body>
  <div class="app_wrapper">
    <?php echo view("/home/left-sidebar-new"); ?>
    <main class="main">
          <div class="card profileCard">
            <div class="profileCard__header">
              <div class="profileCardBox">
                <img src="<?php echo ($profileInfo['profile_img'] && $profileInfo['profile_img'] !== '') ? base_url() . $profileInfo['profile_img'] : base_url() . '/assets/images/users/user-1.jpg'; ?>" alt="" class="profileCardBox__img">
                <h2 class="profileCardBox__name"><?php echo $profileInfo['firstName'] . " " . $profileInfo['lastName']; ?></h2>
                <p class="profileCardBox__para">
                  <?php echo $profileInfo['bio']; ?>
                </p>
                <div class="flex-i profile-edit-btn-wrpr">
                  <button class="flex-a profile-edit-btn" type="button" data-bs-toggle="modal"
                    data-bs-target="#profilee-dit-modal">
                    <img src="<?php echo base_url(); ?>/assets-new/images/icons/pen.svg" alt="">
                    Edit
                  </button>
                  <button class="flex-a profile-edit-btn profile-edit-btn--tr" type="button" data-bs-toggle="modal"
                    data-bs-target="#change-password">
                    Change Password
                  </button>
                </div>
              </div>
            </div>
            <div class="profileCard__body">
              <h3 class="profileCard__hdng">Personal Info...</h3>
              <form class="row profile-edit-row">
                <div class="col-lg-4">
                  <p class="profile-edit__para">First Name</p>
                  <input readonly disabled type="text" placeholder="First Name" name="firstName" value="<?php echo $profileInfo['firstName']; ?>" class="form-control profile-edit__input">
                </div>
                <div class="col-lg-4">
                  <p class="profile-edit__para">Last Name</p>
                  <input readonly disabled type="text" placeholder="Last Name" name="lastName" value="<?php echo $profileInfo['lastName']; ?>" class="form-control profile-edit__input">
                </div>
                <div class="col-lg-4">
                  <p class="profile-edit__para">Phone Number</p>
                  <input readonly disabled type="text" placeholder="Phone Number" name="phone" value="<?php echo $profileInfo['phone']; ?>"
                    class="form-control profile-edit__input">
                </div>
                <div class="col-lg-12">
                  <p class="profile-edit__para">Bio</p>
                  <input readonly disabled type="text" placeholder="Add about yourself" name="bio"
                    value="<?php echo $profileInfo['bio']; ?>"
                    class="form-control profile-edit__input">
                </div>
              </form>
            </div>
          </div>
    </main>
  </div>
  <div class="modal fade" id="profilee-dit-modal" tabindex="-1" aria-labelledby="profilee-dit-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content profile-edit">
        <button class="profile-edit__btnclose flex-a" data-bs-dismiss="modal">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <img src="<?php echo ($profileInfo['profile_img'] && $profileInfo['profile_img'] !== '') ? base_url() . $profileInfo['profile_img'] : base_url() . '/assets/images/users/user-1.jpg'; ?>" alt="" class="profile-edit__img">
        <form action="<?php echo base_url(); ?>/home/updateProfile" method="POST" class="row profile-edit-row">
          <input type="hidden" name="id" value="<?php echo  $profileInfo['id']; ?>">
          <div class="col-lg-4">
            <p class="profile-edit__para">First Name</p>
            <input type="text" placeholder="First Name" name="firstName" value="<?php echo $profileInfo['firstName']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-lg-4">
            <p class="profile-edit__para">Last Name</p>
            <input type="text" placeholder="Last Name" name="lastName" value="<?php echo $profileInfo['lastName']; ?>" class="form-control profile-edit__input">
          </div>
          <div class="col-lg-4">
            <p class="profile-edit__para">Phone Number</p>
            <input type="text" placeholder="Phone Number" name="phone" value="<?php echo $profileInfo['phone']; ?>"
              class="form-control profile-edit__input">
          </div>
          <div class="col-lg-12">
            <p class="profile-edit__para">Bio</p>
            <textarea placeholder="Add about yourself" name="bio"
              class="form-control profile-edit__input profile-edit__input--textarea"><?php echo $profileInfo['bio']; ?></textarea>
          </div>
          <div class="col-lg-12">
            <div class="flex-a profile-edit-btns-wrpr">
              <button type="submit" class="profile-edit__btn">Update</button>
              <button type="button" class="profile-edit__btn profile-edit__btn--tr"
                data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="change-password" tabindex="-1" aria-labelledby="profilee-dit-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content profile-edit">
        <button class="profile-edit__btnclose flex-a" data-bs-dismiss="modal">
          <i class="fa-solid fa-xmark"></i>
        </button>

        <form class="row profile-edit-row" id="changepasswordnew" method="POST">
          <div>
            <p style="color: red; text-align:center;" id="oldnotmatch"></p>
          </div>
          <input type="hidden" name="profileInfoid" value="<?php echo  $profileInfo['id']; ?>">
          <input type="hidden" id="base" value="<?php echo base_url(); ?>">
          <div class="col-12">
            <div class="profile-content">
              <h2 class="profile-content__hdng">Would you like to change your password</h2>
              <p class="profile-content__para">You have received a new deposit request from Muhammad Adnan Akhtar</p>
            </div>
          </div>
          <div class="col-lg-4">
            <p class="profile-edit__para">Old Password</p>
            <input type="password" placeholder="Enter old password" name="oldpassword" id="oldpassword" class="form-control profile-edit__input">
          </div>
          <div class="col-lg-4">
            <p class="profile-edit__para">New Password</p>
            <input type="password" placeholder="New Password" name="newpassword" id="newpassword"  class="form-control profile-edit__input">
          </div>
          <div class="col-lg-4">
            <p class="profile-edit__para">Confirm password</p>
            <input type="password" placeholder="Confirm password" name="confirmpassword" id="confirmpassword" class="form-control profile-edit__input">
          </div>
          <div>
            <p style="color: red; text-align:center;" id="passmatch"></p>
          </div>
          <div class="col-lg-12">
            <div class="flex-a profile-edit-btns-wrpr">
              <button type="submit" class="profile-edit__btn" id="changepasswordbtn">Update</button>
              <button type="button" class="profile-edit__btn profile-edit__btn--tr"
                data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php echo view("/home/new-footer-scripts"); ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets-new/js/ajax_login.js"></script>
  <script src="<?php echo base_url(); ?>/assets-new/js/changeProfileImage.js"></script>
  

  <!-- <script>
        history.pushState(null, "", location.href.split("?")[0]);
        $('.alert-success').fadeOut(5000);
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                profileImage.src = URL.createObjectURL(file)
                $('#update_pic_btn').show();
            }
            }
        $(".togglePassword").click(function () {
            // toggle the type attribute
            const password = $(this).closest('p').find("input");
            const type = password.attr("type") === "password" ? "text" : "password";
            password.attr("type", type);
            
            // toggle the icon
            this.classList.toggle("bi-eye");
        });
    </script> -->
</body>

</html>