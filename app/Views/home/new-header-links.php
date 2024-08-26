<script src="<?php echo base_url(); ?>/assets-new/js/theme.js"></script>
<?php echo view("/home/new-header-link"); ?>
<?php if (isset($_SESSION['success'])):   ?>
    <div class="toast toast-success">
        <div class="toast-content-wrapper">
            <div class="toast-icon">
                <span class="material-symbols-outlined text-dark">Success</span>
            </div>
            <div class="toast-message"> <?php echo $_SESSION['success']; ?></div>
            <div class="toast-progress" style="animation-duration: 5s;"></div>
        </div>
    </div>
<?php endif;
unset($_SESSION['success']); ?>
<?php if (isset($_SESSION['danger'])):  ?>
    <div class="toast toast-danger">
        <div class="toast-content-wrapper">
            <div class="toast-icon">
                <span class="material-symbols-outlined text-dark">Error</span>
            </div>
            <div class="toast-message"><?php echo $_SESSION['danger']; ?></div>
            <div class="toast-progress" style="animation-duration: 5s;"></div>
        </div>
    </div>
<?php endif;
unset($_SESSION['danger']); ?>