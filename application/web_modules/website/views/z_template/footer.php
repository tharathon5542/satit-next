<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>
<!-- JavaScripts
============================================= -->
<script src="<?php echo CANVAS ?>js/jquery.js"></script>
<script src="<?php echo CANVAS ?>js/plugins.min.js"></script>
<!-- Footer Scripts
============================================= -->
<script src="<?php echo CANVAS ?>js/functions.js"></script>
<script src="<?php echo CANVAS ?>js/custom.js"></script>
<!-- Sweet-Alert -->
<script src="<?php echo ELITEADMIN ?>js/sweetalert2.all.min.js"></script>
<!-- Calendar JavaScript -->
<script src="<?php echo ELITEADMIN ?>js/jquery-ui.min.js"></script>
<script src="<?php echo ELITEADMIN ?>js/moment.js"></script>
<script src="<?php echo ELITEADMIN ?>js/fullcalendar.min.js"></script>
<script src="<?php echo ELITEADMIN ?>js/th.js"></script>

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
</script>

</html>