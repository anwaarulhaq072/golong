<script src="<?php echo base_url(); ?>/assets-new/js/jquery-3.7.1.min.js"></script>
<script src="<?php echo base_url(); ?>/assets-new/dist/bootstrap-5.2.2/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>/assets-new/dist/bootstrap-5.2.2/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>/assets-new/dist/fontawesome/js/all.min.js"></script>
<script src="<?php echo base_url(); ?>/assets-new/dist/popperjs/popper.min.js"></script>
<script src="<?php echo base_url(); ?>/assets-new/dist/swiper/swiper-bundle.min.js"></script>
<script src="<?php echo base_url(); ?>/assets-new/dist/tippyjs/tippy-bundle.umd.min.js"></script>
<script src="<?php echo base_url(); ?>/assets-new/dist/chartsjs/chart.js"></script>
<script src="<?php echo base_url(); ?>/assets-new/dist/apexcharts/apexcharts.js"></script>
<script src="<?php echo base_url(); ?>/assets-new/dist/data-tables/dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>/assets-new/dist/datepicker/datepicker.js"></script>
<script>
  var servBoxSl = new Swiper(".loginboxSlider", {
    slidesPerView: 1,
    speed: 300,
    autoplay: true,
    loop: true,
    pagination: {
      clickable: true,
      el: ".loginboxSlider-pagination",
    },
  });
  const showToast2 = (
  message = "Sample Message",
  toastType = "info",
  duration = 5000) => {

  if (
    !Object.keys(icon).includes(toastType))
    toastType = "info";

  let box = document.createElement("div");
  box.classList.add(
    "toast", `toast-${toastType}`);
  box.innerHTML = ` <div class="toast-content-wrapper">
                <div class="toast-message">${message}</div>
                <div class="toast-progress"></div>
                </div>`;
  duration = duration || 5000;

  box.querySelector(".toast-progress").style.animationDuration =
    `${duration / 5000}s`;

  let toastAlready =
    document.body.querySelector(".toast");

  if (toastAlready) {
    toastAlready.style.display = "none";;
  }
  console.log(toastAlready);
  document.body.appendChild(box)
  // $('toast').addClass('d-block');
};
</script>