</body>
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="<?php echo ELITEADMIN ?>js/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="<?php echo ELITEADMIN ?>js/bootstrap.bundle.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="<?php echo ELITEADMIN ?>js/perfect-scrollbar.jquery.min.js"></script>
<!--Wave Effects -->
<script src="<?php echo ELITEADMIN ?>js/waves.js"></script>
<!--Menu sidebar -->
<script src="<?php echo ELITEADMIN ?>js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="<?php echo ELITEADMIN ?>js/custom.min.js"></script>
<!-- Sweet-Alert -->
<script src="<?php echo ELITEADMIN ?>js/sweetalert2.all.min.js"></script>
<!-- Data table -->
<script src="<?php echo ELITEADMIN ?>js/jquery.dataTables.min.js"></script>
<script src="<?php echo ELITEADMIN ?>js/dataTables.responsive.min.js"></script>
<!-- step wizard & validate -->
<script src="<?php echo ELITEADMIN ?>js/jquery.steps.min.js"></script>
<script src="<?php echo ELITEADMIN ?>js/jquery.validate.min.js"></script>
<!-- jqBootstrapValidation -->
<script src="<?php echo ELITEADMIN ?>js/validation.js"></script>
<!-- Calendar JavaScript -->
<script src="<?php echo ELITEADMIN ?>js/jquery-ui.min.js"></script>
<script src="<?php echo ELITEADMIN ?>js/moment.js"></script>
<script src="<?php echo ELITEADMIN ?>js/fullcalendar.min.js"></script>
<script src="<?php echo ELITEADMIN ?>js/th.js"></script>
<!-- Magnific popup JavaScript -->
<script src="<?php echo ELITEADMIN ?>js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo ELITEADMIN ?>js/jquery.magnific-popup-init.js"></script>
<!-- Dropify JS -->
<script src="<?php echo ELITEADMIN ?>js/dropify.min.js"></script>
<!-- select 2 -->
<script src="<?php echo ELITEADMIN ?>js/select2.full.min.js"></script>
<!-- tiny mce -->
<script src="<?php echo ELITEADMIN ?>js/tinymce/tinymce.min.js"></script>
<!-- Session-timeout-idle -->
<script src="<?php echo ELITEADMIN ?>js/jquery.idletimeout.js"></script>
<script src="<?php echo ELITEADMIN ?>js/jquery.idletimer.js"></script>
<!-- tags input -->
<script src="<?php echo ELITEADMIN ?>js/bootstrap-tagsinput.min.js"></script>
<!-- input mask -->
<script src="<?php echo ELITEADMIN ?>js/jquery.inputmask.bundle.min.js"></script>
<!-- chat -->
<script src="<?php echo ELITEADMIN ?>js/chat.js"></script>
<!--stickey kit -->
<script src="<?php echo ELITEADMIN ?>js/sticky-kit.min.js"></script>
<script src="<?php echo ELITEADMIN ?>js/jquery.sparkline.min.js"></script>


<script>
    function showLoadingSweetalert() {
        Swal.fire({
            title: 'กำลังดำเนินการ',
            allowEscapeKey: false,
            allowOutsideClick: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            }
        })
    }

    function showErrorSweetalert(title = "", errorMessage = "", timer = 1000) {
        Swal.fire({
            type: 'error',
            title: title,
            text: errorMessage,
            showConfirmButton: false,
            timer: timer,
        })
    }

    function showSuccessSweetalert(title = "", successMessage = "", timer = 1000) {
        Swal.fire({
            type: 'success',
            title: title,
            text: successMessage,
            showConfirmButton: false,
            timer: timer,
        })
    }

    // session timeout handle function
    <?php if ($page != 'Auth') { ?>
        var UIIdleTimeout = function() {
            return {
                init: function() {
                    var o;
                    $("body").append(""), $.idleTimeout("#idle-timeout-dialog", ".modal-content button:last", {
                        idleAfter: 6000, // 1 hour 59 minute 30 second
                        timeout: 3e4, // time countdown after 30 second left
                        pollingInterval: 10, // keep alive every 10 seconds
                        keepAliveURL: "<?php echo base_url('crud/auth/keepAlive') ?>",
                        serverResponseEquals: "OK",
                        onTimeout: function() {
                            window.location = "<?php echo base_url('crud/auth/onSignOut') ?>"
                        },
                        onIdle: function() {
                            $("#idle-timeout-dialog").modal("show"), o = $("#idle-timeout-counter"), $("#idle-timeout-dialog-keepalive").on("click", function() {
                                $("#idle-timeout-dialog").modal("hide")
                            })
                        },
                        onCountdown: function(e) {
                            o.html(e)
                        }
                    })
                }
            }
        }();

        jQuery(document).ready(function() {
            UIIdleTimeout.init()
        });
    <?php } ?>
</script>

</html>