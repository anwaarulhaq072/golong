<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" data-bs-theme="dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KYC/KYB Files - <?php echo APP_NAME ?></title>
  <?php echo view("/home/new-header-links"); ?>
  <style>
        /* Style for the modal (background and layout) */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            padding-top: 30px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
        }

        /* Style for the image inside the modal */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 550px;
        }

        /* Style for the close button */
        .close {
            position: absolute;
            top: 30px;
            right: 35px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Style for next/previous buttons */
        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 30px;
            transition: 0.6s ease;
            user-select: none;
        }

        .next {
            right: 0;
        }

        .prev {
            left: 0;
        }

        /* Hover effect for next/previous buttons */
        .prev:hover, .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Add animation */
        .modal-content, .close {
            animation: zoom 0.6s;
        }

        @keyframes zoom {
            from {transform: scale(0)}
            to {transform: scale(1)}
        }

        /* Change the cursor when hovering over the image */
        .modal-content:hover {
            cursor: zoom-out;
        }
    </style>
</head>

<body>
  <div class="app_wrapper">
    <?php echo view("/home/left-sidebar-new"); ?>


    <main class="main">
    <h2 class="notification-card__hdng notification-card__hdng--adduser" style="margin-top: 20px;"><?php echo $kycDetails['type']; ?> Documents</h2>
          <?php if(isset($kycDetails)): ?>
            <input type="hidden" id="user_id" name="id" value="<?php echo $userDetails['id']; ?>">
            <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
          <div class="card cus-details-card">
             <!-- Approval Radio Button -->
             <div class="d-flex justify-content-end align-items-center" style="margin-bottom: 15px;">
                  <p class="label-text" style="margin-right: 15px;"><?php echo $kycDetails['type']; ?> Status</p>
                  <div class="form-check" style="margin-right: 15px;">
                    <input type="radio" id="approved" name="approval_status" value="A" class="form-check-input approved" <?php echo ($userDetails['user_kyc_flag'] == 'A') ? 'checked' : '' ?>>
                    <label for="approved" class="form-check-label" style="color:var(--card-sub-heading-color);">Approved</label>
                  </div>
                  <div class="form-check">
                    <input type="radio" id="not-approved" name="approval_status" value="NA" class="form-check-input approved" <?php echo ($userDetails['user_kyc_flag'] == 'NA') ? 'checked' : '' ?>>
                    <label for="not_approved" class="form-check-label" style="color:var(--card-sub-heading-color);">Not Approved</label>
                  </div>
                </div>

            <?php if($kycDetails['type'] == "KYB"): ?>
              <div class="row row-gap2">
              <!-- Image Display Boxes -->
              <div class="col-sm-6 col-lg-2">
                <p class="label-text">ID Front</p>
                <div class="img-box">
                <img src="<?php echo base_url(); ?>/public/user_kyc_docs/<?php echo $userDetails['id']; ?>/<?php echo $kycDetails['id_front_side']; ?>" alt="ID Back Image" class="img-fluid thumbnail" style="width: 300px;height: 180px;border-radius: 5px;object-fit: cover;">
                </div>
              </div>
              <div class="col-sm-6 col-lg-2">
                <p class="label-text">ID Back</p>
                <div class="img-box">
                <img src="<?php echo base_url(); ?>/public/user_kyc_docs/<?php echo $userDetails['id']; ?>/<?php echo $kycDetails['id_back_side']; ?>" alt="ID Back Image" class="img-fluid thumbnail" style="width: 300px;height: 180px;border-radius: 5px;object-fit: cover;">
                </div>
              </div>
               <?php $kycDetails2 = json_decode($kycDetails['origination_docs'], true); foreach($kycDetails2 as $key => $value): ?>
              <div class="col-sm-6 col-lg-2">
                <p class="label-text">Origination Docs</p>
                <div class="img-box">
                <img src="<?php echo base_url(); ?>/public/user_kyc_docs/<?php echo $userDetails['id']; ?>/<?php echo $value; ?>" alt="ID Back Image" class="img-fluid thumbnail" style="width: 300px;height: 180px;border-radius: 5px;object-fit: cover;">
                </div>
              </div>
              <?php endforeach; ?>
              <div class="col-sm-6 col-lg-2">
                <p class="label-text">Shareholder Agreement</p>
                <div class="img-box">
                <img src="<?php echo base_url(); ?>/public/user_kyc_docs/<?php echo $userDetails['id']; ?>/<?php echo $kycDetails['shareholder_agreement']; ?>" alt="ID Back Image" class="img-fluid thumbnail" style="width: 300px;height: 180px;border-radius: 5px;object-fit: cover;">
                </div>
              </div>
              <div class="col-sm-6 col-lg-2">
                <p class="label-text">Proof of Good standing</p>
                <div class="img-box">
                <img src="<?php echo base_url(); ?>/public/user_kyc_docs/<?php echo $userDetails['id']; ?>/<?php echo $kycDetails['proof_of_good']; ?>" alt="ID Back Image" class="img-fluid thumbnail" style="width: 300px;height: 180px;border-radius: 5px;object-fit: cover;">
                </div>
              </div>
              <div class="col-sm-6 col-lg-2">
                <p class="label-text">Proof of Address</p>
                <div class="img-box">
                <img src="<?php echo base_url(); ?>/public/user_kyc_docs/<?php echo $userDetails['id']; ?>/<?php echo $kycDetails['proof_of_address']; ?>" alt="ID Back Image" class="img-fluid thumbnail" style="width: 300px;height: 180px;border-radius: 5px;object-fit: cover;">
                </div>
              </div>
            </div>
            <?php elseif($kycDetails['type'] == "KYC"): ?>
              <div class="row row-gap2">
              <!-- Image Display Boxes -->
              <div class="col-sm-6 col-lg-2">
                <p class="label-text">ID Front</p>
                <div class="img-box">
                <img src="<?php echo base_url(); ?>/public/user_kyc_docs/<?php echo $userDetails['id']; ?>/<?php echo $kycDetails['id_front_side']; ?>" alt="ID Back Image" class="img-fluid thumbnail" style="width: 300px;height: 180px;border-radius: 5px;object-fit: cover;">
                </div>
              </div>
              <div class="col-sm-6 col-lg-2">
                <p class="label-text">ID Back</p>
                <div class="img-box">
                <img src="<?php echo base_url(); ?>/public/user_kyc_docs/<?php echo $userDetails['id']; ?>/<?php echo $kycDetails['id_back_side']; ?>" alt="ID Back Image" class="img-fluid thumbnail" style="width: 300px;height: 180px;border-radius: 5px;object-fit: cover;">
                </div>
              </div>
              <div class="col-sm-6 col-lg-2">
                <p class="label-text">Proof of Address</p>
                <div class="img-box">
                <img src="<?php echo base_url(); ?>/public/user_kyc_docs/<?php echo $userDetails['id']; ?>/<?php echo $kycDetails['proof_of_address']; ?>" alt="ID Back Image" class="img-fluid thumbnail" style="width: 300px;height: 180px;border-radius: 5px;object-fit: cover;">
                </div>
              </div>
            </div>
            <?php endif; ?>
          </div>
          <?php endif; ?>
        </div>
        <!-- The Modal -->
      <div id="imageModal" class="modal">
          <!-- Close button -->
          <span class="close">&times;</span>
          <!-- Next/Previous buttons -->
          <a class="prev">&#10094;</a>
          <a class="next">&#10095;</a>
          <!-- Modal content (the full-size image) -->
          <img class="modal-content" id="fullImage">
      </div>
            </main>

  <?php echo view("/home/new-footer-scripts"); ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="<?= base_url(); ?>/assets/js/modalWorking.js"></script>
  <script src="<?= base_url(); ?>/assets/js/addProfitLoss.js"></script>
  <script>
        var modal = document.getElementById("imageModal");
        var modalImg = document.getElementById("fullImage");
        var closeBtn = document.getElementsByClassName("close")[0];
        var thumbnails = document.getElementsByClassName("thumbnail");
        var currentIndex = 0;

        // When the user clicks on any image, open the modal and display the full-size image
        for (let i = 0; i < thumbnails.length; i++) {
            thumbnails[i].onclick = function () {
                modal.style.display = "block";
                modalImg.src = this.src;
                currentIndex = i;
            }
        }

        // Close the modal
        closeBtn.onclick = function () {
            modal.style.display = "none";
        }

        // Close the modal when clicking outside the image
        modal.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }

        // Next/Previous controls
        var nextBtn = document.getElementsByClassName("next")[0];
        var prevBtn = document.getElementsByClassName("prev")[0];

        nextBtn.onclick = function () {
            currentIndex = (currentIndex + 1) % thumbnails.length; // Loop to first image after the last
            modalImg.src = thumbnails[currentIndex].src;
        }

        prevBtn.onclick = function () {
            currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length; // Loop to last image before the first
            modalImg.src = thumbnails[currentIndex].src;
        }

        // Add arrow key functionality
        document.onkeydown = function (event) {
            if (modal.style.display === "block") {
                if (event.key === "ArrowRight") {
                    nextBtn.onclick();
                } else if (event.key === "ArrowLeft") {
                    prevBtn.onclick();
                } else if (event.key === "Escape") {
                    modal.style.display = "none";
                }
            }
        }
    </script>
</body>

</html>