<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Profile - <?php echo APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nvest Clients - Where you can invest" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php echo view("/home/header-links"); ?>
    <style>
        #profileImage:hover{
            transform: scale(1.1);
        }
        form i {
            margin-left: -30px;
            cursor: pointer;
        }
        .file_upload {
   opacity: 0.0;

   /* IE 8 */
   -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";

   /* IE 5-7 */
   filter: alpha(opacity=0);
 
   /* Netscape or and older firefox browsers */
   -moz-opacity: 0.0;

   /* older Safari browsers */
   -khtml-opacity: 0.0;

   /* position: absolute; */
   top: 0;
   left: 0;
   bottom: 0;
   right: 0;
    /* width: 100%;
   height:100%; */
}
.box{
    cursor: pointer;
        width: 100%;
        height: 100%;            
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;  / for demo purpose  /
    }
    .stack-top{
        z-index: 9;
        margin: 20px; / for demo purpose  /
    }
    .row1{
        width: 240px;
        height: 250px;
        position: relative;
        margin: 20px;
        margin-left: 37%;
    }
    @media (max-width: 450px) {
            .stack-top{
                margin-left: -125px;
            }
            .box{
                margin-left: -50px;
                margin-top: 20px;
                height: 200px;
                width: 200px;
                border: solid 5px #0075b2;
            }
            #update_pic_btn{
                margin-left: -145px !important;
            }
            .about_me{
                display: block !important;
            }
            .update_profile_btn{
                margin-top: -20px !important;
                margin-bottom: 15px !important;
            }
            

        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

</head>

<!-- body start -->

<body class="loading"
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}}'>
    <!-- Begin page -->
    <div id="wrapper">
    <?php echo view("/home/left-sidebar"); ?>
        
        <!-- include Top-bar -->
        <?php echo view("/home/top-bar", $notification) ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
            <div class="content-page" style=" background-color: #F5F5FC !important;">
                <div class="content" style="margin-top: 50px;">
                    <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
                    <!-- Start Content-->
                    <div class="container-fluid">
                     <?php if(isset($_GET['success']) && $_GET['success'] == true): ?>
                        <div class="alert alert-success" role="alert">
                        Profile Picture Updated Successfully
                        </div>
                        <?php elseif(isset($_GET['success_data']) && $_GET['success_data'] == true): ?>
                        <div class="alert alert-success" role="alert">
                        Profile Updated Successfully.
                        </div>
                        <?php elseif(isset($_GET['success_ps']) && $_GET['success_ps'] == true): ?>
                        <div class="alert alert-success" role="alert">
                        Password Changed Successfully.
                        </div>
                        <?php endif; ?>
                        <h2 class="header-title mt-4 mb-2">Profile Data</h2>
                                <div class="card text-center">
                                    <div class="card-body">
                                        <div id="profile-container" class="py-3">
                                                <form action="<?php echo base_url(); ?>/home/updateProfileImage" enctype="multipart/form-data" method="POST" >
                                                <div class="row1">
                                                <div>
                                                <input accept="image/*" type='file' class="file_upload box" name="profile_photo" id="imgInp" required>
                                                </div>
                                                <div>
                                                <img id="profileImage" class="rounded-circle avatar-xl stack-top"
                                                alt="profile-image" style="object-fit: contain; height: 200px; width: 200px; border: solid 5px #0075b2;"
                                                src="<?php echo ($profileInfo['profile_img'] && $profileInfo['profile_img']!=='') ? base_url().$profileInfo['profile_img'] : base_url().'/assets/images/users/user-1.jpg';?>" />
                                                </div>
                                                <div>
                                                <button type="submit" id="update_pic_btn" class="primary_btn" style="display: none;margin-left: 22px; margin-top: 22px;">Save Profile Picture</button>
                                                </div>
                                                </div>
                                                </form>
    
                                        </div>
                                        <div class="text-start" style="margin: 20px;">
                                            <!-- <h3 class="header-title">Profile Data</h3> -->
                                            <div class="about_me" style="display: flex; justify-content: space-between;">
                                                <h4 class="font-13 text-uppercase pb-3 stron">About Me :</h4>
                                                <div class="update_profile_btn" style="text-align:right;">
                                                    <button id="profileBtn" type="button"class="primary_btn">Update Profile</button>
                                                    <button id="passBtn" type="button" class="btn btn-info waves-effect waves-light" style="background-color: #0073B6;">Change Password </button>
                                                </div>
                                            </div>
                                            <!-- <h4 class="font-13 text-uppercase pb-3">About Me :</h4> -->
                                            <!-- <p class="text-muted font-13 mb-3">
                                            Hi I'm Johnathn Deo,has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type.
                                        </p> -->
                                            <p class="text-muted mb-2 font-13"><strong style="color: black;">Full Name :</strong> <span
                                                    class="ms-2"><?php echo $profileInfo['firstName'] . " " . $profileInfo['lastName']; ?></span>
                                            </p>
                                            <p class="text-muted mb-2 font-13"><strong style="color: black;">Mobile :</strong><span
                                                    class="ms-2"><?php echo $profileInfo['phone']; ?></span></p>
                                            <p class="text-muted mb-2 font-13"><strong style="color: black;">Email :</strong> <span
                                                    class="ms-2"><?php echo $profileInfo['email']; ?></span></p>
                                            <!-- <p class="text-muted mb-1 font-13"><strong>Location :</strong> <span class="ms-2">USA</span></p> -->
                                            <!-- <p class="text-muted mb-1 font-13"><strong>Zip :</strong> <span class="ms-2">11356</span></p> -->
                                        </div>
                                    </div>
                                </div>
                        <div class="row" id="profileSection">
                            <div class="col-lg-12 col-xl-12 mt-3">
                            <h3 class="header-title mt-2 mb-2">Update your Profile</h3>
                                <div class="card text-center" style="border-radius: 20px;">
                                    <div class="card-body">
                                        <div class="text-start mt-3">
                                            <!-- <h3 class="header-title">Update your Profile</h3> -->

                                            <form action="<?php echo base_url(); ?>/home/updateProfile" method="POST">
                                                <div class="row mt-3">
                                                    <input type="hidden" name="id"
                                                        value="<?php echo  $profileInfo['id']; ?>">
                                                    <div class="mb-3 col-md-5 col-lg-4 col-12">
                                                        <label for="Amount" class="form-label" style="color: black;"> First Name</label>
                                                        <input type="text" class="form-control" name="firstname"
                                                            value="<?php echo $profileInfo['firstName'] ?>" required>
                                                    </div>
                                                    <div class="mb-3 col-md-5 col-lg-4 col-12">
                                                        <label for="Amount" class="form-label" style="color: black;">Last Name</label>
                                                        <input type="text" class="form-control" name="lastname"
                                                            value="<?php echo $profileInfo['lastName'] ?>" required>
                                                    </div>
                                                    <div class="mb-3 col-md-5 col-lg-4 col-12">
                                                        <label for="Amount" class="form-label" style="color: black;">Phone</label>
                                                        <input type="tel" class="form-control" name="phone"
                                                            value="<?php echo $profileInfo['phone'] ?>" required>
                                                    </div>
                                                    <div class="mb-3 col-md-5 col-lg-4 col-12">
                                                        <label for="Amount" class="form-label" style="color: black;">Email (read only)</label>
                                                        <input type="email" class="form-control" name="email"
                                                            value="<?php echo $profileInfo['email'] ?>" readonly>
                                                    </div>
                                                    <div   class="mb-3 col-md-5 col-lg-4 col-12">
                                                        <button type="submit"
                                                            class="mt-3 btn btn-info waves-effect waves-light"  style="background-color: #0073B6; width:100%">Update
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="passwordSection">
                            <div class="col-lg-12 col-xl-12 mt-3">
                            <h3 class="header-title mt-2 mb-2">Change Password</h3>
                                <div class="card text-center" style="border-radius: 20px;">
                                    <div class="card-body">
                                        <div class="text-start mt-3">
                                            <!-- <h3 class="header-title">Change Password</h3> -->

                                            <form id="changepassword">
                                                <div>
                                                    <p style="color: red; text-align:center;" id="oldnotmatch"></p>
                                                </div>
                                                <div class="row mt-3">
                                                    <input type="hidden" name="id"
                                                        value="<?php echo  $profileInfo['id']; ?>">
                                                    <input type="hidden" id="base" value="<?php echo base_url(); ?>">
                                                    <!-- <div class="row"> -->
                                                        <div class="mb-3 col-md-5 col-lg-4 col-12">
                                                            <label for="Amount" class="form-label" style="color: black;">Old Password<span style="color: red;">*</span></label>
                                                            <p>
                                                                <input type="password" class="form-control" name="oldpassword" style="display: inline;" required>
                                                                <i class="bi bi-eye-slash togglePassword"></i>
                                                            </p>
                                                        </div>
                                                    <!-- </div> -->
                                                    <div class="mb-3  col-md-5 col-lg-4 col-12">
                                                        <label for="Amount" class="form-label" style="color: black;">New Password<span style="color: red;">*</span></label>
                                                        <p>
                                                            <input type="password" class="form-control" name="newpassword" id="newpassword" style="display: inline;" required>
                                                            <i class="bi bi-eye-slash togglePassword"></i>
                                                        </p>
                                                    </div>
                                                    <div class="mb-3 col-md-5 col-lg-4 col-12">
                                                        <label for="Amount" class="form-label" style="color: black;">Confirm Password<span style="color: red;">*</span></label>
                                                        <p>
                                                            <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" style="display: inline;" required>
                                                            <i class="bi bi-eye-slash togglePassword"></i>
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p style="color: red; text-align:center;" id="passmatch"></p>
                                                    </div>
                                                    <div class="mb-3 col-md-12 col-lg-12 col-12" style="text-align: center">
                                                        <button type="submit" class="btn btn-info waves-effect waves-light" style="background-color: #0073B6;">Change Password</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- container -->
                </div> <!-- content -->
            </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div> <!-- END wrapper -->

    <?php echo view("/home/footer-scripts"); ?>
    <script src="<?php echo base_url(); ?>/assets/js/ajax_login.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/changeProfileImage.js"></script>
    
    <script>
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
    </script>

</body>

</html>